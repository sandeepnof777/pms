<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_queue")
 */
class Email_queue {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $taskId;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $due;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fromEmail;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fromName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recipient;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $body;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completed;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completedAt;

    /**
     * @ORM\Column(type="string", length=145, nullable=true)
     */
    private $reply_to;

    public function getTaskId() {
        return $this->taskId;
    }

    public function getDue() {
        return $this->due;
    }

    public function setDue($due) {
        $this->due = $due;
    }

    public function getFromEmail() {
        return $this->fromEmail;
    }

    public function setFromEmail($from) {
        $this->fromEmail = $from;
    }

    public function getFromName() {
        return $this->fromName;
    }

    public function setFromName($fromName) {
        $this->fromName = $fromName;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getRecipient() {
        return $this->recipient;
    }

    public function setRecipient($recipient) {
        $this->recipient = $recipient;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getCompleted() {
        return $this->completed;
    }

    public function setCompleted($completed) {
        if ($completed) {
            $this->completedAt = time();
        }
        $this->completed = $completed;
    }

    public function getCompletedAt() {
        return $this->completedAt;
    }

    public function setCompletedAt($completedAt) {
        $this->completedAt = $completedAt;
    }

    public function setReplyTo($reply_to) {
        $this->reply_to = $reply_to;
    }

    public function getReplyTo() {
        return $this->reply_to;
    }


}