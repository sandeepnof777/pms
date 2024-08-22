<ol class="QB-desktop" id="desktopInstructions">
    <li>1. Click the button below to download the .qwc file</li>
    <li>2. Add this QWC file in your QuickBooks Web Connector</li>
    <li>3. Select 'Add Application' in Web Connector, then select this file</li>
    <li>4. Return to this page and follow the next step</li>
    <li><a href="<?= base_url(); ?>/quickbooks/config" id="downloadQwc" target="_blank"
           class="btn ui-button update-button ui-widget ui-state-default ui-corner-all">Download QWC File</a>
    </li>
</ol>

<div id="reloading" style="display: none;">
    <p style="text-align: center">Reloading Settings...</p>
</div>

<script type="text/javascript">

    var refresh = false;

    $("#downloadQwc").click(function() {
        refresh = true;

        $("#desktopInstructions").hide();
        $("#reloading").show();

        return true;
    })

    setInterval(function() {
        if (refresh) {
            window.location.reload();
        }
    }, 1000);

</script>