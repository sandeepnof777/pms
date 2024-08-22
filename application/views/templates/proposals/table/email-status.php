<?php
    if ($proposal->email_status > 0) {

        switch ($proposal->email_status) {
            case \models\Proposals::EMAIL_UNSENT:
                $image = 'email_unsent.png';
                $title="Proposal has not been sent";
                break;
            case \models\Proposals::EMAIL_SENT:
                $image = 'email_sent.png';
                $title="Proposal has been sent to contact";
                if ($proposal->emailSendTime) {
                    $title.= "<br />Email Sent: " . date('m/d/Y g:ia', realTime($proposal->emailSendTime));
                }
                break;
            case \models\Proposals::EMAIL_EDITED:
                $image = 'email_edited.png';
                $title="Proposal has been edited since being sent";
                if ($proposal->emailSendTime) {
                    $title.= "<br />Email Sent: " . date('m/d/Y g:ia', realTime($proposal->emailSendTime));
                }
                break;
        }
?>
    <img src="/3rdparty/icons/<?php echo $image ?>" class="tiptipleft" title="<?php echo $title; ?>">
<?php
    }