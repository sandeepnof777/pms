<div class="content-box collapse closed" id="dashboardEvents">

    <div class="box-header centered clearfix">Your Events</div>

    <div class="box-content padded">

        <a href="#" style="float: right;" class="btn update-button" id="addNewEvent" data-account="<?= $account->getAccountId() ?>">Add New Event</a>

        <div class="clearfix">
            <h3 class="padded left" style="margin: 0;">Upcoming Events</h3>
        </div>

        <?php $this->load->view('templates/events/table'); ?>

    </div>
    <div class="clearfix"></div>

</div>