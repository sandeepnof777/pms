<div id="datatablesError" title="Error" style="text-align: center; display: none;">
    <h3>Oops, something went wrong</h3>

    <p>We're having a problem loading this page.</p><br />
    <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN;?>&subject=Support: Help with Table">contact support</a> if this keeps happening.</p>
</div>
<script type="text/javascript">

    $(document).ready(function() {

        // Datatables error Dialog
        $("#datatablesError").dialog({
            width: 500,
            modal: true,
            buttons: {
                Retry: function () {
                    window.location.reload();
                }
            },
            autoOpen: false
        });
    });
</script>
