<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="payments")
 */
class Payments {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $paymentId;

    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $companyId;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $ccnumber;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $ccexp;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $checkname;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $checkaba;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $checkaccount;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $account_holder_type;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $account_type;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $cvv;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $payment;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $orderdescription;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $orderid;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $address1;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $address2;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $zip;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $ipaddress;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $details;

    /**
     * @ORM\Column (type="string", length=2048, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $added;

    function __construct() {
        $this->added = time();
    }

    public function getPaymentId() {
        return $this->paymentId;
    }

    public function getCompanyId() {
        return $this->companyId;
    }

    public function setCompanyId($companyId) {
        $this->companyId = $companyId;
    }

    public function getCcnumber() {
        return $this->ccnumber;
    }

    public function setCcnumber($ccnumber) {
        $this->ccnumber = substr($ccnumber, 0, -4);
    }

    public function getCcexp() {
        return $this->ccexp;
    }

    public function setCcexp($ccexp) {
        $this->ccexp = $ccexp;
    }

    public function getCheckname() {
        return $this->checkname;
    }

    public function setCheckname($checkname) {
        $this->checkname = $checkname;
    }

    public function getCheckaba() {
        return $this->checkaba;
    }

    public function setCheckaba($checkaba) {
        $this->checkaba = $checkaba;
    }

    public function getCheckaccount() {
        return $this->checkaccount;
    }

    public function setCheckaccount($checkaccount) {
        $this->checkaccount = $checkaccount;
    }

    public function getAccountHolderType() {
        return $this->account_holder_type;
    }

    public function setAccountHolderType($accountHolderType) {
        $this->account_holder_type = $accountHolderType;
    }

    public function getAccountType() {
        return $this->account_type;
    }

    public function setAccountType($accountType) {
        $this->account_type = $accountType;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getCvv() {
        return $this->cvv;
    }

    public function setCcv($cvv) {
        $this->cvv = $cvv;
    }

    public function getPayment() {
        return $this->payment;
    }

    public function setPayment($payment) {
        $this->payment = $payment;
    }

    public function getOrderDescription() {
        return $this->orderdescription;
    }

    public function setOrderDescription($orderDescription) {
        $this->orderdescription = $orderDescription;
    }

    public function getOrderId() {
        return $this->orderid;
    }

    public function setOrderId($orderId) {
        $this->orderid = $orderId;
    }

    public function getFirtstName() {
        return $this->firstname;
    }

    public function setFirtstName($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function setLastName($lastName) {
        $this->lastname = $lastName;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getAddress1() {
        return $this->address1;
    }

    public function setAddress1($address1) {
        $this->address1 = $address1;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function setAddress2($address2) {
        $this->address2 = $address2;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getFax() {
        return $this->fax;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getIpAddress() {
        return $this->ipaddress;
    }

    public function setIpAddress($ipAddress) {
        $this->ipaddress = $ipAddress;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getAdded() {
        return $this->added;
    }
}
