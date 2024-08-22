<?php 

// foreach($resends as $resend){
//     echo $resend->getResendName();
// }
// die;

$this->load->view('global/header'); ?>
<style>
    input.error {
    border-color: #e47074 !important;
    background: #ffedad !important;
    box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
}
</style>
    <script type="text/javascript">
        var numMappedProposals;
    </script>

    <input type="hidden" id="delayUI" value="1">

    <div id="content" class="clearfix">
        
        <div id="newFilter" style="margin-bottom: 0px;">
            <div class="clearfix">
                <?php
                
                if ($action != 'search') {
                    $this->load->view('templates/proposals/filters/new-proposal-filters');
                    //$this->load->view('templates/proposals/filters/default-filters');
                } ?>
            </div>
            <input type="hidden" id="pageAction" value="<?php echo $action; ?>"/>
            <input type="hidden" id="group" value="<?php echo $group; ?>"/>
            <input type="hidden" id="search" value="<?php echo $search; ?>"/>

            <div class="filterOverlay"></div>
        </div>
        <div class="clearfix"></div>

        <?php
        if ($search) {
            echo '<h3 class="centered">Viewing results for "' . $search . '"
            . <a href="' . site_url('proposals') . '">View All Proposals</a></h3>';
        }

        if ($clientCompany) {
            echo '<h3 class="centered">Showing Proposals for ' . $clientCompany . ' . <a href="' . site_url('proposals') . '">View All Proposals</a></h3>';
        }
        ?>

        <div class="content-box" style="margin-top: 5px;">
            <div class="box-header">

                <div id="proposalsTableLoader" style="width: 150px; float: left; display: none; margin-left: 413px;">
                    <img src="/static/loading-bars.svg" />
                </div>

                <?php if (help_box(4)) { ?>
                    <div class="help tiptip" style="margin-left: 5px;float: right;" title="Help"><?php help_box(4, true) ?></div>
                    <?php
                } ?>
                <!--            <a class="box-action tiptip blue" title="View Proposals in Queue" href="#">Proposal Queue</a>-->

                <a class="box-action hide tiptip" style="visibility: hidden;" href="<?php echo site_url('clients') ?>" title="Add a new Proposal for an existing client"
                   id="addProposalLink">
                    <i class="fa fa-fw fa-plus"></i> Add Proposal Existing Contact
                </a>

                <!-- <a class="box-action tiptip" href="<?php echo site_url('clients/add') ?>" title="Add a new Contact for adding a Proposal"
                   id="addProposalLink2">
                    <i class="fa fa-fw fa-plus"></i> Add Proposal New Contact
                </a> -->

                <!-- <a class="box-action tiptip" href="#" id="exportFilteredProposals" title="Export These proposals">
                    <i class="fa fa-fw fa-cloud-download"></i>
                </a>

                <a class="box-action tiptip" href="#" title="Map" id="proposalMapLink">
                    <i class="fa fa-fw fa-map"></i> Map
                </a> -->

                <a class="box-action tiptip" href="#" title="Proposals Table" id="proposalTableLink">
                    <i class="fa fa-fw fa-list"></i> Proposals
                </a>

                <a class="box-action tiptip mapControl" style="display: none;" href="#" title="Show All" id="mapAll">
                    <i class="fa fa-fw fa-map-marker"></i> Show All
                </a>

                <a class="box-action tiptip mapControl" style="display: none;" href="#" title="Go To My Position" id="mapPosition">
                    <i class="fa fa-fw fa-location-arrow"></i> Current Location
                </a>

                <a class="box-action tiptip mapControl" style="display: none;" href="#" title="Back" id="mapBack">
                    <i class="fa fa-fw fa-arrow-left"></i> Back
                </a>


                <div style="float:left; margin-right:10px" class="mapControl">
                    <input type="search" placeholder="Enter Zip Code" onkeypress="searchPostcode(event)" id="postcode_search" style="display: none; width: 125px">
                    <a class="box-action mapControl" id="mapTools">Tools</a>
                    <a class="box-action mapControl" id="zipSearchButton" title="Show markers in Zip Code"><i class="fa fa-fw fa-search"></i></a>
                    <a class="box-action" id="zipCancel" title="Clear Zip Search"><i class="fa fa-fw fa-close"></i></a>

                    <div id="mapToolsDropdown">
                        <a href="#" id="closeDrawingTools"><i class="fa fa-fw fa-close"></i> </a>
                        <div class="clearfix"></div>
                        <table>
                            <tr>
                                <td>
                                    <div id="drawingManager" class="" style="float:left"></div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="drawingManagerRadiusCount" class="" style="float:left; font-weight: normal; font-style: normal;"></div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="drawingManagerPolygonRemove" class="" style="float:left;"></div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                        <div id="map-canvas"></div>
                    </div>

                </div>

                <div class="clearfix"></div>
            </div>
            <div class="box-content" style="overflow-y: scroll; overflow-y: hidden;">
                <div id="proposalsTableContainer">
                    <?php $this->load->view('templates/proposals/table/table'); ?>
                </div>
                <div id="proposalsMapContainer" style="display: none; position: relative;">
                    <?php $this->load->view('templates/proposals/map/info'); ?>
                    <?php $this->load->view('templates/proposals/map/map'); ?>
                </div>
            </div>

        </div>

        <?php $this->load->view('templates/proposals/table/table-js'); ?>

    </div>
    </div>

<?php $this->load->view('templates/errors/datatables'); ?>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>