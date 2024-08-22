<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="log")
 */
class Log {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $logId;
    /**
     * @ORM\ManyToOne(targetEntity="Accounts")
     * @ORM\JoinColumn(name="account", referencedColumnName="accountId")
     */
    private $account;
    /**
     * @ORM\ManyToOne(targetEntity="Companies")
     * @ORM\JoinColumn(name="company", referencedColumnName="companyId")
     */
    private $company;
    /**
     * @ORM\ManyToOne(targetEntity="Clients")
     * @ORM\JoinColumn(name="client", referencedColumnName="clientId")
     */
    private $client;
    /**
     * @ORM\ManyToOne(targetEntity="Proposals")
     * @ORM\JoinColumn(name="proposal", referencedColumnName="proposalId")
     */
    private $proposal;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ip;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $timeAdded;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $action;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $details;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $userName;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statusFrom;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statusTo;

    function __construct() {
        $this->timeAdded = time();
        $this->proposal = NULL;
        $this->client = NULL;
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function getLogId() {
        return $this->logId;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setAccount($account) {
        $this->account = $account;
    }

    public function getTimeAdded() {
        return $this->timeAdded;
    }

    public function getIp() {
        return $this->ip;
    }

    /*
    *  Returns the html for a link to mapping the approximate location of the IP
    */
    public function IpMapLink($tip='View Location'){
        return mapIP($this->ip, $tip);
    }

    /**
     * @return \models\Proposals
     */
    public function getProposal() {
        return $this->proposal;
    }

    public function setProposal($proposal) {
        $this->proposal = $proposal;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getClient() {
        return ($this->client) ? $this->client : NULL;
    }

    public function setClient($client) {
        $this->client = $client;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getStatusFrom(){
        return $this->statusFrom;
    }

    public function getStatusTo(){
        return $this->statusTo;
    }


}
