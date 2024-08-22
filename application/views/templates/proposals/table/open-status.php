<?php
    if ($proposal->lastOpenTime) {
?>
        <span class="badge green tiptipleft showProposalViews" data-type="proposal" data-entity-id="<?php echo $proposal->proposalId; ?>" data-project-name="<?=$proposal->projectName;?>"
              title="Last Viewed: 
              <!-- <?php //echo date('m/d/Y g:ia', realTime($proposal->lastOpenTime)); ?>  -->
              <?php echo  date('m/d/Y g:i A', $proposal->lastOpenTime + TIMEZONE_OFFSET); ?>
            </br></br> Click to see <?=$proposal->proposal_view_count;?> Proposal Views" style="cursor: pointer;">
              O</span>
<?php
    }
?>