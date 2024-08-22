<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>Notes</title>
<link rel="stylesheet" type="text/css" href="/3rdparty/fontawesome/css/font-awesome.min.css" media="all">
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
    table th {
    background-color: #f4f4f4 !important;
    border-right: 1px solid #d5d5d5 !important;
    padding: 5px!important;
    border-bottom:1px solid #fff !important;
}
table td {
border-top: 1px solid #fff !important;
    border-bottom: 1px solid #eee !important;
    border-right: 1px solid #eee !important;
}
table th {

    border-right: 1px solid #eee !important;
}
.dataTables_paginate{display:none;}
#notes_table_filter{
    float: none;
    text-align: center;
    padding-bottom: 5px;
    background: white!important;
}
.ui-widget-header{
        border:none!important;
    }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
 border:none!important;
    }

</style>


</head>
<body>
    

<?php

if (!count($notes)) {
    ?>
     <div style="width:100%; text-align:center;"> No notes!</div>
    <?php }else{?>
<table id="notes_table" class="display  dataTable no-footer" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th width="30%" style="text-align: left;">Date</th>
        <th width="40%" style="text-align: left;">Text</th>
        <th width="10%" style="text-align: left;">User</th>
        <th width="10%" style="text-align: left;">Eidt </th>
        <th width="10%" style="text-align: left;">Delete </th>
    <?php if($this->uri->segment(3) =='proposal' && count($notes)){ ?>
       
        <th width="13%">Work Order </th>
    <?php } ?>
    </tr>
    </thead>
    <tbody>

    <!-- <tr class="even">
        <td colspan="4" align="center">No notes!</td>
        <td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td>
    </tr> -->
        <?php
 
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
            <td><?php echo date('m/d/Y g:ia', $note->getAdded() + TIMEZONE_OFFSET) ?></td>
             <td>
                <span class="note-text "><?php echo $note->getNoteText() ?></span>
                <input type="text" class="note-input" style="display:none;" value="<?php echo $note->getNoteText() ?>">
                <button class="save-note" style="display:none;" data-note-id="<?php echo $note->getNoteId(); ?>">Save</button>
            </td>
            <td style="text-align: left;"><span class="tiptip" title="<?=$users[$note->getUser()][1];?>"><?php echo $users[$note->getUser()][0]; ?></span></td>
          
            <td style="text-align: left;"><span class="tiptip  getNotesID edit-note"  title="Eidt" data-notesId="<?php echo $note->getNoteId();?>" > <a href="#"> <img src="/3rdparty/icons/building_edit.png"></a>
        
            </td>
            <td style="text-align: left;"><span class="tiptip confirm-deletion getNotesID"  title="Delete" data-notesId="<?php echo $note->getNoteId();?>" > <a href="#"> <img src="/3rdparty/icons/delete.png"></a></td>

            <?php if($this->uri->segment(3) =='proposal' && count($notes)){?>
            <td style="text-align: center">
                <input type="checkbox" onclick="update_show_work_order(this,<?= $note->getNoteId();?>)"  <?php echo $note->getWorkOrder() ? 'checked' : ''; ?> >
        </td>
        <?php } ?>
        </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
<div class="javascript_loaded">

<div id="confirm-delete-message" title="Confirmation" style="display: none;">
                    <p>Are you sure you want to delete Note?</p>
                    <a id="client-delete" href="" rel=""></a>
                </div>
</div>
<link rel="stylesheet" type="text/css" href="<?= base_url();?>3rdparty/tiptip/tipTip.css" media="all">
<link rel="stylesheet" type="text/css" href="<?= base_url();?>3rdparty/DataTables-new/datatables.min.css" media="all">
<script type="text/javascript" src="<?= base_url();?>static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>static/js/jquery-ui.min.js"></script>


<script type="text/javascript" src="<?= base_url();?>3rdparty/tiptip/jquery.tipTip.minified.js"></script>
<script type="text/javascript" src="<?= base_url();?>3rdparty/dataTables/media/js/jquery.dataTables.min.js"></script>

<script>
    $( document ).ready(function() {
        
        $('#notes_table').DataTable({
            "iDisplayLength": 10,
            "ordering": false,
            "searching":true,
            "lengthChange":false,
           
            "info":false,
            
            "jQueryUI": true,
            "autoWidth": true,
            "stateSave": false,
            "paginationType": "full_numbers",
            "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
             "columnDefs": [
            <?php if($this->uri->segment(3) == 'proposal' && count($notes)){ ?>
                { "targets": [4], "visible": true }
            <?php }   ?>
                 
        ]
            
        });
        $('.tiptip').tipTip({
            defaultPosition: "top",
            delay: 0,
            maxWidth: '330px;'
        });
});
function update_show_work_order(e,id){
    var work_order = 0;
    if($(e).prop("checked") == true){
        work_order = 1;
    }else{
        work_order = 0;
    }
    $.ajax({
            url: '/ajax/update_show_work_order/',
            type: 'post',
            data: {
                'note_id': id,
                'work_order':work_order,
            },
            success: function(data){
               console.log(data);
            }
        });
}


 
</script>
<script>
      $(document).ready(function() {
    var notesIdToDelete = null;

    // Show Confirm Deletion Dialog on click
    $(document).on('click', '.confirm-deletion', function () {
        notesIdToDelete = $(this).data('notesid'); 
        // Open the confirmation dialog
        $("#confirm-delete-message").show();
        $("#confirm-delete-message").dialog('open');
        return false; // Prevent default action
    });

    // Initialize the dialog
    $("#confirm-delete-message").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function () {
                if (notesIdToDelete !== null) {
                    var deleteUrl = "<?php echo site_url('ajax/deleteNotes'); ?>/" + notesIdToDelete;
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        success: function(response) {
                            // Handle success response
                            if (response) {
                                
                                location.reload(); // Reload the page to reflect the changes
                            } else {
                                alert('Deletion failed');
                            }
                        },
                        error: function() {
                            alert('Error occurred during deletion');
                        }
                    });
                } else {
                    alert('No note ID to delete');
                }
                $(this).dialog("close");
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
});

 // Save note on save button click

   // Show input field and save button on edit button click
   $(document).on('click', '.edit-note', function() {
        var noteId = $(this).data('note-id');
        var row = $(this).closest('tr');
        row.find('.note-text').hide();
        row.find('.note-input').show();
        row.find('.save-note').show();
    });

 // Edit  note on save button click
 $(document).on('click', '.save-note', function() {
        var noteId = $(this).data('note-id');
        var row = $(this).closest('tr');
        var newText = row.find('.note-input').val();

        $.ajax({
            url: '/ajax/update_note',
            type: 'POST',
            data: {
                'note_id': noteId,
                'note_text': newText
            },
            success: function(response) {
                console.log("Response",response);
                if (response) {
                    row.find('.note-text').text(newText).show();
                    row.find('.note-input').hide();
                    row.find('.save-note').hide();
                } else {
                    alert('Update failed');
                }
            },
            error: function() {
                alert('Error occurred during update');
            }
        });
    });

    </script>
</body>
</html>