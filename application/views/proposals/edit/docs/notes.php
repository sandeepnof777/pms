<style type="text/css">
    body {
        margin: 0;
        padding: 10px 0;
        font-family: Arial;
        font-size: 12px;
    }

    table#proposalNotesTable {
        border-top: 1px solid #ddd;
        border-left: 1px solid #ddd;
    }

    table#proposalNotesTable tr.even {
        background: #F9F9F9;
    }

    table#proposalNotesTable td {
        padding: 3px 8px;
        color: #444;
        border-bottom: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }

    table#proposalNotesTable thead tr {
        background: #f4f4f4;
    }

    table#proposalNotesTable thead td {
        font-weight: bold;
    }

    table#proposalNotesTable span.tiptip {
        border-bottom: 1px dashed #25AAE1;
        cursor: pointer;
        position: relative;
    }
</style>

<p>
    <label>Add Note</label>
    <input type="text" name="noteText" id="noteText" style="width: 500px;">
    <input type="hidden" name="relationId" id="relationId" value="0">
    <button id="addNote" class="btn update-button"><i class="fa fa-fw fa-plus"></i> Add Note</button>
</p>
<br /><br />
<iframe id="notesFrame" src="<?php echo site_url('account/notes/proposal/' . $proposal->getProposalId()); ?>" frameborder="0" width="100%" height="300"></iframe>
