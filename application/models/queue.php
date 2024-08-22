<?php
class Queue extends MY_Model {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var CI_DB_driver
     */
    var $db;

    function __construct() {
        parent::__construct();
    }

    function addEmail(array $emailSettings, $delay = 60) {
        $email = new \models\Email_queue();
        //check $emailSettings integrity and defaults
        $due = time() + $delay;
        $email->setDue($due);
        if (!@$emailSettings['fromName']) {
            $emailSettings['fromName'] = $this->settings->get('from_name');
        }
        if (!@$emailSettings['fromEmail']) {
            $emailSettings['fromEmail'] = $this->settings->get('from_email');
        }
        if (!@$emailSettings['subject']) {
            $emailSettings['subject'] = 'No Subject';
        }
        $email->setSubject($emailSettings['subject']);
        if (!@$emailSettings['recipient']) {
            $emailSettings['recipient'] = 'chris@pavementlayers.com';
        }
        $email->setRecipient($emailSettings['recipient']);
        if (!@$emailSettings['body']) {
            $emailSettings['body'] = 'No Message Body!';
        }

        if (@$emailSettings['replyTo']) {
            $email->setReplyTo($emailSettings['replyTo']);
        }
        

        $email->setBody($emailSettings['body']);
        $email->setFromEmail($emailSettings['fromEmail']);
        $email->setFromName($emailSettings['fromName']);


        $email->setCompleted(0);
        $this->em->persist($email);
        $this->em->flush();
    }

}