<?php $this->load->view('global/header'); ?>
    <script type="text/javascript">
        var numMappedProposals;
    </script>

    <div id="content" class="clearfix">
        <div id="newFilter">
            <div class="clearfix">
                <?php
                if ($action != 'search') {
                    $this->load->view('templates/estimates/new-proposal-filters');
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
            echo '<h3 class="centered">Viewing results for "' . $this->input->post('searchProposal') . '"
            . <a href="' . site_url('proposals') . '">View All Proposals</a></h3>';
        }

        if ($clientCompany) {
            echo '<h3 class="centered">Showing Proposals for ' . $clientCompany . ' . <a href="' . site_url('proposals') . '">View All Proposals</a></h3>';
        }
        ?>

        <div class="content-box">
            <div class="box-header">
                
                <div class="left " >Estimates</div>
                <!--            <a class="box-action tiptip blue" title="View Proposals in Queue" href="#">Proposal Queue</a>-->

                <!-- <a class="box-action tiptip" href="<?php echo site_url('clients') ?>" title="Add New Proposal"
                   id="addProposalLink">
                    <i class="fa fa-fw fa-plus"></i> Add Proposal
                </a>

                <a class="box-action tiptip" href="#" id="exportFilteredProposals" title="Export These proposals">
                    <i class="fa fa-fw fa-cloud-download"></i>
                </a>

                <a class="box-action tiptip" href="#" title="Map" id="proposalMapLink">
                    <i class="fa fa-fw fa-map"></i> Map
                </a>

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
                </a> -->


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
            <div class="box-content">
                <div id="proposalsTableContainer">
                    <?php $this->load->view('templates/estimates/table'); ?>
                </div>
                <div id="proposalsMapContainer" style="display: none; position: relative;">
                    <?php $this->load->view('templates/proposals/map/info'); ?>
                    <?php $this->load->view('templates/proposals/map/map'); ?>
                </div>
            </div>

        </div>

        <?php $this->load->view('templates/estimates/table-js'); ?>

    </div>
    </div>

<?php $this->load->view('templates/errors/datatables'); ?>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>