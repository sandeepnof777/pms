<div style="padding: 20px;">
    <form action="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>"
          method="post" id="addAuditForm">
        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><strong>Inspection</strong></td>
            </tr>
            <tr>
                <?php if (!$proposal->getAuditKey()) { ?>
                    <td><input type="text" class="text" name="auditLinkUrl" id="auditLinkUrl"
                               placeholder="Audit Link" style="width: 97%;"></td>
                    <td><input type="submit"  value="Link This Audit" class="btn small update-button" name="addAudit"></td>
                <?php } else { ?>
                    <td><a href="<?php echo $proposal->getAuditReportUrl(); ?>" target="_blank">Click Here To
                            View Inspection Report</a></td>
                    <td><input type="submit" value="Remove Audit" class="btn small" name="removeAudit"></td>
                <?php } ?>
            </tr>
        </table>
        <input type="hidden" name="proposal" value="<?php echo $proposal->getProposalId() ?>">
    </form>
</div>