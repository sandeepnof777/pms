<?php $this->load->view('global/header'); ?>

    <div id="content" class="clearfix javascript_loaded">
        <div class="widthfix">


            <div class="content-box collapse" id="qb-hiw">
                <div class="box-header">
                    How it works
                    <span class="collapse-button"></span>
                </div>

                <div class="box-content" style="padding: 20px">
                    Video here demonstrating how to sync
                </div>

            </div>



            <form method="post">

            <!--
            <div class="content-box collapse">

                <div class="box-header">Sync Options <span class="collapse-button"></span></div>

                <div class="box-content" style="padding: 20px">

                    <h4>Existing Match Priority</h4>
                    <p>For existing matches, please select which data source has priority.</p><br />
                    <input type="radio" name="existingMatchPriority" value='layers'> Layers
                    <input type="radio" name="existingMatchPriority" value='qb'> QuickBooks
                    <input type="radio" name="existingMatchPriority" value='0' checked="checked"> Do Not Sync

                    <h4>QuickBooks Clients</h4>

                    <p><input type="checkbox" name="unmatchedQbToL" checked="checked">If a QuickBooks customer doesn't have a match in <?php echo site_name(); ?>, create as a new client.</p>




                    <h4><?php echo site_name(); ?> Clients</h4>

                    <p><input type="checkbox" name="unmatchedLToQb" checked="checked">If a <?php echo site_name(); ?> client is not in QuickBooks, create as a new customer in QuickBooks</p><br />

                </div>

            </div>
            -->

            <div class="content-box">

                <div class="box-header">QuickBooks Sync</div>

                <div class="box-content" style="padding: 20px;">
                    <p><a href=="#" id="syncSelectAll">Select All</a> | <a href=="#" id="syncUnselectAll">Unselect All</a></p>

                    <?php
                    if(count($qbClients)){ ?>
                        <table width="100%" id="tblQbSync">
                            <thead>
                            <tr>
                                <th>Select</th>
                                <th>QuickBooks Customer</th>
                                <th>QuickBooks Company</th>
                                <th><?php echo site_name(); ?> Client</th>
                                <th><?php echo site_name(); ?> Company</th>
                            </tr>
                            </thead>
                            <?php
                            $data['i'] = 0;
                            // Iterate through QB clients
                            foreach($qbClients as $qbClient){
                                $data['i']++;
                                $data['matches'] = $qbClient['matches'];
                                $data['client'] = $qbClient['client'];
                                $data['customer'] = $qbClient['customer'];

                                $this->load->view('account/quickbooks/contact-card', $data);
                            }
                            ?>
                            <?php
                            // No iterate through Layers client
                            foreach($clientList as $client){
                                /* @var $client \models\Clients */

                                $data['client'] = $client;
                                $data['i']++;
                                $this->load->view('account/quickbooks/layers-clients', $data);

                            }
                            ?>
                        </table>
                    <?php
                    }
                    ?>

                    <input type="submit" class="btn btn-primary" name="sync" value="Sync with QuickBooks">

                </div>
            </div>


        </form>

        </div>
    </div>


<script type="text/javascript">

    $(document).ready(function(){

        $('#syncSelectAll').click(function(){
            $('.syncSelect').prop('checked', true);
            $('.syncSelect').each(function(){
                $(this).parent().addClass('checked');
            });
            return false;
        });

        $('#syncUnselectAll').click(function(){
            $('.syncSelect').prop('checked', false);
            $('.syncSelect').each(function(){
                $(this).parent().removeClass('checked');
            });
            return false;
        });

    });
</script>

<?php $this->load->view('global/footer'); ?>