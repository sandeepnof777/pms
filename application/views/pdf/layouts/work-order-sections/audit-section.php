
<div id="audit-section">

<?php
if ($proposal->getAuditKey())
{
    
    if($i!=1){ ?>
            <div style="page-break-after: always"></div>
    <?php }?>
    
    <!--Hide Header code start-->

    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200;">ProSiteAudit</h1>

    <br />
    <a href="<?php echo $proposal->getAuditReportUrl(); ?>" target="_blank">Click to view Audit Report</a>
<?php
}
?>
</div><!--audit-section-->