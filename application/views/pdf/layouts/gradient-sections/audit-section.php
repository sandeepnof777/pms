<?php

    if ($proposal->getAuditKey()) {
?>      
<div style="page-break-after: always"></div>
        <div id="audit-section" style="page-break-inside: avoid;">
            <div class="item-content audit">
                <h2>Property Inspection / Audit</h2>

                <table>
                    <tr>
                        <td style="text-align: center">
                            <a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank" style="display: block">
                                <img id="auditIcon" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/audit-icon.png')); ?>" />
                            </a>
                            <p style="text-align: center; font-weight: bold; font-style: italic;">Click to See</p>
                        </td>
                        <td style="font-size: 16px;">
                            <p>We have performed a custom site inspection/audit of this site including maps, images and more</p>
                            <p><a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank">View your Custom Site Inspection/Audit Report</a></p>
                        </td>
                    </tr>
                </table>
                <div class="audit-footer"></div>
            </div>
        </div>
        
<?php    }?>

