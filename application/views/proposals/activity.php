<?php $this->load->view('global/header') ?>
<style>
     .dataTables_phistory tr td {
  padding: 8px 10px !important;
}
 
#DataTables_Table_0_wrapper #DataTables_Table_0  tbody td {
    border-top: 1px solid #ddd!important;
    border-bottom: 1px solid #d5d5d5 !important;
    border-top: none !important;
    border-left: none !important;
    border-right: 1px solid #d5d5d5 !important;
}
#DataTables_Table_0{
		font-size: 13px!important;
		border-top: 1px solid #ddd!important;
    }
</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Proposal Activity for: <span><?php echo $proposal->getProjectName() ?></span>
                <a class="box-action" href="<?php echo site_url('proposals') ?>">Back</a>
            </div>
            <div class="box-content">
                <table cellpadding="0" cellspacing="0" border="0" class="dataTables_phistory display">
                    <thead>
                    <tr>
                        <td>ID#</td>
                        <td>Date</td>
                        <td>User</td>
                        <td>IP Address</td>
                        <td>Proposal</td>
                        <td>Details</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($logs as $log) {
                    ?>
                    <tr>
                        <td><?php echo $log->logId; ?></td>
                        <td style="white-space: nowrap"><?php echo date('m/d/Y h:i:s A', $log->timeAdded + TIMEZONE_OFFSET) ?></td>
                        <td style="white-space: nowrap"><?php
                            if ($log->userName) {
                                echo $log->userName;
                            } else {
                                echo ($log->account) ? $log->accountFirstName . ' ' . $log->accountLastName : 'No User';
                            }
                            ?>
                        </td>
                        <td><?php echo mapIP($log->ip); ?></td>
                        <td><?php echo ($log->proposal) ? $log->projectName : 'None'; ?></td>
                        <td><?php echo $log->details ?></td>
                    </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var pactable = $(".dataTables_phistory").dataTable({
            aoColumns:[
                {bVisible:false},
                {iDataSort: 0  },
                null,
                null,
                null,
                null
            ],
            "bJQueryUI":true,
            "bAutoWidth":false,
            "sPaginationType":"full_numbers",
            "aLengthMenu":[
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "sDom":'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
        });
        pactable.fnSort([
            [1, 'desc']
        ]);
    });
</script>
<?php $this->load->view('global/footer'); ?>
