<div style="padding: 20px;">

    <table id="modifyPricesHistoryTable" class="display">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>IP</th>
                <th>Adjustment %</th>
                <th>Statuses</th>
                <th>Proposals Updated</th>
                <th>Date Range</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($priceMods as $pm) { 
            $dateRange = '-';
            $additional_info = json_decode($pm->getAdditionalInfo());
            if(isset($additional_info->pModifyFrom) && isset($additional_info->pModifyTo)){
                $dateRange = date("m/d/Y",$additional_info->pModifyFrom).' To '.date("m/d/Y",$additional_info->pModifyTo);
            }
            ?>
        <?php /* @var \models\PriceModification $pm */ ?>
            <tr>
                <td><?php echo $pm->getRunDate()->format('m/d/Y g:i a'); ?></td>
                <td><?php echo $pm->getUserName(); ?></td>
                <td><?php echo mapIP($pm->getIpAddress()); ?></td>
                <td><?php echo ($pm->getModifier() >= 0) ? '+' : ''; ?><?php echo $pm->getModifier(); ?>%</td>
                <td><?php echo $pm->getStatuses(); ?></td>
                <td><?php echo $pm->getProposalsModified(); if(!$pm->getCompleted()){ echo '<img width="15" style="float:right" src="../static/blue-loading-spinner.gif">';}?></td>
                <td><?php echo $dateRange ?></td>
            </tr>

        <?php } ?>
        </tbody>
    </table>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        $("#modifyPricesHistoryTable").DataTable({
            "order": [[0, "desc"]],
            "bProcessing": true,
            "serverSide": false,
            "scrollCollapse": true,
            "aoColumns": [
                {'bVisible': true},
                {'bSearchable': true},
                {'bSearchable': true},
                {'bSearchable': true},
                {'bSearchable': true},
                {'bSearchable': true},
                {'bSearchable': false},
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "sPaginationType": "full_numbers",
            "sDom": 'HfltiprF',
            "aLengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ]
        });

    });

</script>