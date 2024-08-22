<?php
    /* @var \models\Proposals $proposal */

    if ($proposal->audit_key && !$proposal->audit_view_time) {
        $title = 'Audit Linked';

        if ($proposal->audit_reminder_sent) {
            $title.= ' - Reminder Sent: ' . date('m/d/Y g:ia', realTime($proposal->audit_reminder_sent)); 
        }
?>
        <span class="badge gray tiptipleft"
              title="<?php echo $title; ?>">A</span>
<?php
    }
    else if ($proposal->audit_view_time) {
?>
        <span class="badge green tiptipleft"
              title="Audit Last Opened: <?php echo date('m/d/Y g:ia', realTime($proposal->audit_view_time)); ?>">A</span>
<?php
    }
?>