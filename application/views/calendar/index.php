<?php $this->load->view('global/header') ?>
<div id="content" class="clearfix">
    <div class="widthfix">


        <div class="nav-box clearfix">
            <div class="content-box">
                <div class="nav-header">
                    <h2>Calendar</h2>
                    <div id="events-filter" class="clearfix" style="padding-bottom: 10px;">
                        <select name="eventFilterType" id="calendarType">
                            <option value="0">All Types</option>
                            <?php foreach ($event_types as $type): ?>
                                <option value="<?= $type->id ?>" <?php echo ($this->session->userdata('calendarType') == $type->id) ? ' selected="selected"' : '' ?>><?= $type->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="eventFilterBy" id="calendarBy">
                            <option value="0" <?php echo ($this->session->userdata('calendarBy') == 'all') ? ' selected="selected"' : '' ?>>All</option>
                            <option value="completed" <?php echo ($this->session->userdata('calendarBy') == 'completed') ? ' selected="selected"' : '' ?>>Completed</option>
                            <option value="incomplete" <?php echo ($this->session->userdata('calendarBy') == 'incomplete') ? ' selected="selected"' : '' ?>>Incomplete</option>
                        </select>
                        <?php if ($account->isFullAccess()): ?>
                            <select name="eventFilterUser" id="calendarUser">
                                <option value="0">All Users</option>
                                <?php foreach ($filterAccounts as $filterAccount): ?>
                                    <option value="<?= $filterAccount->getAccountId(); ?>" <?php echo ($this->session->userdata('calendarUser') == $filterAccount->getAccountId()) ? ' selected="selected"' : '' ?>><?= $filterAccount->getFullName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                        <!--<a href="#" class="btn update-button" style="height: 25px; line-height: 25px; font-size: 12px; <?= ($this->session->userdata('calendarFilter')) ? '' : ' display: none;'; ?>">Reset</a>-->
                    </div>
                    <!--<div class="clearfix" style="padding-bottom: 10px;">
                        <label for="calendar-search" style="margin-right: 15px;">Search</label>
                        <input type="text" name="calendar-search" id="calendar-search" class="text" style="width: 220px;">
                    </div>-->
                </div>
                <?php /** @var $googleRepository Pms\Repositories\GoogleAuth */ if(!empty($googleRepository)){ ?>
                <div class="nav-content clearfix">
                    <div class="clearfix" style="padding: 20px;">
                        <?php if (0): ?>
                        <div>
                            <h3>Debug</h3>
                            <!-- <pre><?php print_r($googleRepository->getAccessToken()) ?></pre> -->
                            <p>Refresh Token: <?= $googleRepository->getRefreshToken() ?></p>
                            <p>
                                <?php if ($googleRepository->getAccessToken()): ?>
                                    <?php if (!$googleRepository->tokenExpired()): ?>
                                        Expires in: <?= $googleRepository->expiresIn() ?> seconds
                                    <?php else: ?>
                                        Expired
                                    <?php endif; ?>
                                <?php else: ?>
                                    No Token
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php endif;  }?>
                        <div class="clearfix" style="margin-bottom: 20px;">
                            <a href="#" class="btn update-button left" id="addNewEvent" data-account="<?= $account->getAccountId() ?>">Add New Event</a>
                            <?php
                            if ($googleRepository->authenticated()): ?>
                                <!--<a href="<?= site_url('cron/calendar_sync') ?>" class="right btn update-button">Sync With Google</a>-->
                                <a href="<?= site_url('account/disconnect_google_calendar') ?>" class="right btn update-button">Disconnect calendar</a>
                            <?php else: ?>
                                <a href="<?= site_url('account/google_auth') ?>" class="right btn update-button" id="sync">Connect to Google Calendar</a>
                            <?php endif; ?>
                        </div>
                        <div id="calendar">

                        </div>
                    </div>
                    <?php if (0) { ?>
                        <p>&nbsp;</p>
                        <h3>List (just for reference)</h3>
                        <p>&nbsp;</p>
                        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <td>Event Type</td>
                                <td>User</td>
                                <td>Name</td>
                                <td>Text</td>
                                <td>Start</td>
                                <td>End</td>
                                <td>Completed</td>
                                <td>Reminder</td>
                                <td>Reminder Sent</td>
                            </tr>
                            </thead>
                            <tbody>
                                <?php echo "<pre>";print_r($event_types); ?>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td style="<?= ((isset($event_types[$event->type]))) ? 'color: ' . $event_types[$event->type]->backgroundColor . ';' : '' ?>">
                                        <strong><?= (isset($event_types[$event->type])) ? $event_types[$event->type]->name : 'No type defined!' ?></strong>
                                    </td>
                                    <td><?= (isset($accounts[$event->account])) ? $accounts[$event->account]->firstName . ' ' . $accounts[$event->account]->lastName : 'No user!' ?></td>
                                    <td><?= $event->name ?></td>
                                    <td><?= $event->text ?></td>
                                    <td><?= date('m/d/Y H:i:s', $event->startTime) ?></td>
                                    <td><?= date('m/d/Y H:i:s', $event->endTime) ?></td>
                                    <td><?= ($event->eventCompleteTime) ? (date('m/d/Y H:i:s', $event->eventCompleteTime)) : 'Not Completed' ?></td>
                                    <td><?= ($event->reminderTime) ? (date('m/d/Y H:i:s', $event->reminderTime)) : 'No Reminder' ?></td>
                                    <td><?= ($event->reminderSentTime) ? (date('m/d/Y H:i:s', $event->reminderSentTime)) : 'Not sent' ?></td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#content-->
<script>
    $(document).ready(function () {
        //calendar code
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listWeek,agendaDay,agendaWeek,month'
            },
            theme: true,
            allDayDefault: false,
//            defaultView: '<?//= ($this->session->userdata('calendarView')) ?: 'listWeek' ?>//',
            defaultView: '<?= $this->uri->segment(2) ? $this->uri->segment(2) : 'listWeek' ?>',
            defaultDate: '<?= ($this->uri->segment(2)) ? $this->uri->segment(3) : date('Ymd') ?>',
            events: {
                url: '<?= site_url('account/getEvents') ?>',
                type: 'POST',
                dataType: 'JSON',
                error: function (e) {
                    console.log(e);
                    alert('there was an error while fetching events!');
                }
            },
            eventClick: function (calEvent, jsEvent, view) {
                editScheduledEvent(calEvent.id, {calendar: 1});
            },
            viewRender: function (view, element) {
                setCalendarSettings();
            }
        });


        $("#events-filter select").on('change', function () {
            var filterData = getFilterData();
            var calendarFilter = 0;
            var data = $.extend(filterData, {calendarFilter: calendarFilter});
            //set filters
            $.ajax({
                type: "POST",
                url: '<?= site_url('account/setCalendarFilter') ?>',
                data: data,
                success: function () {
                    $("#calendar").fullCalendar('refetchEvents');
                }
            });
        });

        $("#sync").on('click', function () {

            //return false;
        });
    });

    function getFilterData() {
        var data = {};
        $("#events-filter select").each(function () {
            data[$(this).attr('id')] = $(this).val();
        });
        return data;
    }

    function refreshCalendar() {

    }

    function setCalendarSettings() {
        var viewName = $('#calendar').fullCalendar('getView').name;
        $.ajax({
            type: "POST",
            url: '<?= site_url('account/setCalendarFilter') ?>',
            data: {calendarView: viewName}
        });
    }
</script>
<?php $this->load->view('global/footer') ?>
