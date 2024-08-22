<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use \Carbon\Carbon;

/**
 * @ORM\Entity
 * @ORM\Table(name="events")
 */
class Event extends \MY_Model{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne (targetEntity="Companies", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn (name="company", referencedColumnName="companyId", nullable=true))
     */
    private $company;
    /**
     * @ORM\ManyToOne (targetEntity="EventType", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn (name="type", referencedColumnName="id", nullable=true)
     */
    private $type;
    /**
     * @ORM\ManyToOne (targetEntity="Accounts", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn (name="account", referencedColumnName="accountId")
     */
    private $account;
    /**
     * @ORM\ManyToOne (targetEntity="Proposals", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn (name="proposal", referencedColumnName="proposalId")
     */
    private $proposal;
    /**
     * @ORM\ManyToOne (targetEntity="Leads", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn (name="lead", referencedColumnName="leadId")
     */
    private $lead;
    /**
     * @ORM\ManyToOne (targetEntity="Clients", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn (name="client", referencedColumnName="clientId")
     */
    private $client;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $text;
    /**
     * @ORM\Column(type="integer")
     */
    private $created;
    /**
     * @ORM\Column(type="integer")
     */
    private $updated;
    /**
     * @ORM\Column(type="integer")
     */
    private $startTime;
    /**
     * @ORM\Column(type="integer")
     */
    private $endTime;
    /**
     * @ORM\Column(type="integer")
     */
    private $reminderTime;
    /**
     * @ORM\Column(type="integer")
     */
    private $reminderSentTime;
    /**
     * @ORM\Column(type="integer")
     */
    private $eventCompleteTime;


    function __construct() {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return \models\EventType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \models\Accounts
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getProposal()
    {
        return $this->proposal;
    }

    /**
     * @param mixed $proposal
     */
    public function setProposal($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * @return mixed
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param mixed $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getStartTime($format = false)
    {
        if ($format) {
            return Carbon::createFromTimestamp($this->startTime)->format('n/j g:ia');
        }

        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return mixed
     */
    public function getReminderTime()
    {
        return $this->reminderTime;
    }

    /**
     * @param mixed $reminderTime
     */
    public function setReminderTime($reminderTime)
    {
        $this->reminderTime = $reminderTime;
    }

    /**
     * @return mixed
     */
    public function getReminderSentTime()
    {
        return $this->reminderSentTime;
    }

    /**
     * @param mixed $reminderSentTime
     */
    public function setReminderSentTime($reminderSentTime)
    {
        $this->reminderSentTime = $reminderSentTime;
    }

    /**
     * @return mixed
     */
    public function getEventCompleteTime()
    {
        return $this->eventCompleteTime;
    }

    /**
     * @param mixed $eventCompleteTime
     */
    public function setEventCompleteTime($eventCompleteTime)
    {
        $this->eventCompleteTime = $eventCompleteTime;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

}