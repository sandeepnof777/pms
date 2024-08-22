<?php $this->load->view('global/header'); ?>

    <div id="content" class="clearfix javascript_loaded">
        <div class="widthfix">
            <form method="post" id="syncForm" action="<?echo site_url('account/qbSync'); ?>">

                <div class="content-box collapse" id="qb-hiw">
                    <div class="box-header">
                        How it works
                        <span class="collapse-button"></span>
                    </div>

                    <div class="box-content" style="padding: 20px">
                        Video here demonstrating how to sync
                    </div>

                </div>


                <div class="content-box">

                    <div class="box-header">QuickBooks Sync</div>

                    <div class="box-content" style="padding: 20px;">


                        <table width="100%" id="syncTable">
                            <thead>
                                <tr>
                                    <th><?php echo site_name(); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th>QuickBooks</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                foreach($syncRows as $syncRow){

                                    $data['syncRow'] = $syncRow;

                                    $this->load->view('account/quickbooks/sync-row', $data);
                                }

                            ?>

                            </tbody>
                        </table>
                        <br />
                        <a href="#qbLoading" class="btn fancybox.inline" name="newSync" id="newSync">Sync</a>
                    </div>
                </div>


            </form>

        </div>
    </div>


    <div style="display: none" id="qbLoading">
        <p style="text-align: center; margin-bottom: 20px;">Communicating with QuickBooks</p>
        <p style="text-align: center"><img src="/static/loading_animation.gif" /></p>
    </div>

<script type="text/javascript">

    // Scroll back to top of page. No difference on first visit, but when redirected it was loading the previous page position
    // This means that the confimration is on screen and the user is back at the top of the page
    $(window).scrollTop(0);

    var oTable;

    $(document).ready(function(){

        // Datatable initialisation
        oTable = $('#syncTable').dataTable({
            "aaSorting": [],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 1, 2 ] }
            ],
            "bJQueryUI": true,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers"
        });
    });

    $('#newSync').fancybox({
        width: 300,
        height: 50,
        scrolling: 'no',
        beforeShow: function(){
            $('#qbLoading').show();
            sendQbSync();
        }
    });

    /*
    // Form elements can be lost with pagination, so this handles that
    $('form#syncForm').submit(function(){
        var sData = $('input', oTable.fnGetNodes()).serialize();

        $.post('<?php echo site_url('account/qbSync'); ?>', sData, function(data){
            document.location.reload();
        });

        return false;

    });
*/

    function sendQbSync(){
        var sData = $('input', oTable.fnGetNodes()).serialize();

        $.post('<?php echo site_url('account/qbSync'); ?>', sData, function(data){
            // document.location.href='<?php echo site_url('clients'); ?>';
            document.location.href='<?php echo site_url('account/quickbooks/merge'); ?>';
        });
    }

    // Input tips
    $('.syncTip').tipTip({
        activation: 'hover'
    });


</script>

<?php $this->load->view('global/footer'); ?>