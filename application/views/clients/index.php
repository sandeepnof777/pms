<?php $this->load->view('global/header'); ?>
    <input type="hidden" id="delayUI" value="1">
    <div id="content" class="clearfix">
        <div class="widthfix">

            <?php $this->load->view('clients/filters'); ?>

            <div class="content-box" style="margin-top: 5px;">
                <input type="hidden" id="group" value=""/>
                <input type="hidden" id="search" value="<?php echo $search; ?>"/>

                <?php if ($search) { ?>
                    <p style="padding: 20px">Showing search results for <strong>'<?php echo $search ?>'</strong>. &nbsp;<a href="<?php echo site_url('clients'); ?>">View all contacts</a></p>
                <?php } ?>

                <div class="box-header">
                    <span style="float: left; color: #fff; margin-right: 10px;">Contacts</span>
                    <?php if (help_box(22)) { ?>
                        <div class="help right tiptip" title="Help"><?php help_box(22, true) ?></div>
                    <?php } ?>

                    <div id="clientsTableLoader" style="width: 150px; display: none; position: absolute; left: 421px; top: 8px;">
                        <img src="/static/loading-bars.svg">
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="box-content">
                    <?php
                    // Load the table
                    $this->load->view('templates/clients/table/table');
                    // Load relevant script
                    $this->load->view('templates/clients/table/group-js');
                    $this->load->view('templates/clients/table/add-contact-popup');
                ?>
                </div>
            </div>
        </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>