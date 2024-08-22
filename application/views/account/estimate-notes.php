<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>Notes</title>
<style type="text/css">
    body {
        margin: 0;
        padding: 10px 0;
        font-family: Arial;
        font-size: 12px;
    }

    table {
        border-top: 1px solid #ddd;
        border-left: 1px solid #ddd;
    }

    thead {
    }

    tr {
    }

    tr.even {
        background: #F9F9F9;
    }

    td {
        padding: 3px 8px;
        color: #444;
        border-bottom: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }

    thead tr {
        background: #f4f4f4;
    }

    thead td {
        font-weight: bold;
    }

    span.tiptip {
        border-bottom: 1px dashed #25AAE1;
        cursor: pointer;
        position: relative;
    }
</style>


</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td width="15%">Date</td>
        <td width="30%">Item</td>
        <td width="30%">Text</td>
        <td width="25%">User</td>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!count($notes)) {
        ?>
    <tr class="even">
        <td colspan="3" align="center">No notes!</td>
    </tr>
        <?php
    } else {
        $k = 0;
        $users = array();
        foreach ($notes as $note) {
            if (!isset($users[$note->getUser()])) {
                $user = $this->em->find('models\Accounts', $note->getUser());
                if ($user) {
                    $name = '';
                    $names = explode(' ', trim($user->getFullName()));
                        $name .= substr($user->getFirstName(), 0, 1) . '. ';
                        $name .= substr($user->getLastName(), 0, 1) . '.';
                    $name = trim($name);
                    $users[$note->getUser()] = array($name, $user->getFullName());
                } else {
                    $users[$note->getUser()] = array('N / A', 'No User');
                }
            }
            $k++;
            ?>
        <tr class="<?php echo (!($k % 2)) ? 'even' : 'odd'; ?>">
            <td><?php echo date('m/d/Y h:i A', $note->getAdded()) ?></td>
            <td>
                <?php
                // Estimate Note
                if ($note->getType() == 'estimate') {
                    echo 'Estimate Note';
                } else {
                    // Estimate Line Item Note
                    echo $note->getEstimateItemName();
                }
                ?>
            </td>
            <td><?php echo $note->getNoteText() ?></td>
            <td><?php echo $users[$note->getUser()][1]; ?></td>
        </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
</body>
</html>