//schedule function
function schedule(options) {
    var defaultStartDateString = moment().format('MM/DD/YYYY');
    var startMoment = moment().add(1, 'hour').startOf('hour');
    var startHour = startMoment.format('h');
    var defaultStartPeriod = startMoment.startOf('hour').format('A');
    var defaultStartTimeString = startHour + ':00';
    var finishMoment = startMoment.add(1, 'hour');
    var defaultFinishDateString = finishMoment.format('MM/DD/YYYY');
    var finishHour = finishMoment.startOf('hour').format('h');
    var defaultFinishPeriod = finishMoment.startOf('hour').format('A');
    var account = $("#currentAccountId").val();
    var settings = {
        title: 'Schedule new Reminder',
        name: 'Reminder',
        text: 'Reminder text',
        client: null,
        proposal: null,
        account: account,
        prospect: null,
        lead: null,
        startDate: defaultStartDateString,
        startTime: defaultStartTimeString,
        startTimeHr: startHour,
        startPeriod: defaultStartPeriod,
        endDate: defaultFinishDateString,
        endPeriod: defaultFinishPeriod,
        endTimeHr: finishHour,
        startTimeMin: '00',
        endTimeMin: '00',
        remindDate: '',
        location: '',
        start: '',
        end: '',
        redirect: null,
        id: null,
        linkedTo: null,
        linkedToName: null,
        duration: 3600,
        reminderDuration: 3600
    };
    settings = $.extend(settings, options);
    // swal('END SETTINGS:', JSON.stringify(settings));
    //check if it's an edit
    //init dialog
    $('#scheduler_dialog').dialog('option', 'title', settings.title);
    $("#schedule-name").val(settings.name);
    $("#schedule-text").val(settings.text);
    $("#schedule-client").val(settings.client);
    $("#schedule-proposal").val(settings.proposal);
    $("#schedule-prospect").val(settings.prospect);
    $("#schedule-account").val(settings.account);
    $("#schedule-lead").val(settings.lead);
    $("#schedule-type").val(settings.type);
    $("#schedule-startDate").val(settings.startDate);
    $("#schedule-location").val(settings.location);
    $("#schedule-startTimeHr").val(settings.startTimeHr);
    $("#schedule-startTimeMin").val(settings.startTimeMin);
    $("#schedule-endTimeHr").val(settings.endTimeHr);
    $("#schedule-endTimeMin").val(settings.endTimeMin);
    $("#schedule-startPeriod").val(settings.startPeriod);
    $("#schedule-endDate").val(settings.endDate);
    $("#schedule-endPeriod").val(settings.endPeriod);
    $("#schedule-remindDate").val(settings.remindDate);
    $("#schedule-duration").val(settings.duration);
    $("#schedule-reminderDuration").val(settings.reminderDuration);
    //$.uniform.update();

    //init time pickers
    /*$("#startTime").replaceWith('<input type="text" name="startTime" id="schedule-startTime">');
     $("#schedule-startTime").wickedpicker({
     now: settings.startTime24h,
     minutesInterval: 15
     });*/
    createSchedulerDatePicker('startTime', settings.startTime24h);
    $("#schedule-id").val("");
    $("#schedule-deleteUi").hide();
    if (settings.id !== null) {
        $("#schedule-id").val(settings.id);
    }
    if (settings.calendar) {
        $("#schedule-deleteUi").show();
        $("#schedule-event-delete, #schedule-event-complete, #schedule-event-uncomplete").data('id', settings.id);
    }
    if (settings.linkedTo !== null) {
        $("#schedule-linkedToRow").show();
        $("#schedule-linkedTo").html(settings.linkedTo);
        $("#schedule-linkedToName").html(settings.linkedToName);
    } else {
        $("#schedule-linkedToRow").hide();
    }
    /*
     if (settings.redirect !== null) {
     $("#schedule-redirectRoute").val(settings.redirect);
     }
     */

    // Complete/ Uncomplete
    if (settings.eventCompleteTime) {
        $("#schedule-event-complete").hide();
        $("#schedule-event-uncomplete").show();
    }
    else {
        $("#schedule-event-complete").show();
        $("#schedule-event-uncomplete").hide();
    }

    //open dialog
    $("#scheduler_dialog").dialog('open');
    //update form stuff
    //$.uniform.update();
}

function createSchedulerDatePicker(id, time) {
    /*
     $("#schedule-" + id).replaceWith('<input type="text" name="' + id + '" id="schedule-' + id + '">');
     $("#schedule-" + id).wickedpicker({
     now: time,
     minutesInterval: 5
     });
     */
}

function editScheduledEvent(id, additionalSettings) {
    if (typeof(additionalSettings) === 'undefined') {
        additionalSettings = {};
    }
    $.ajax({
        method: "POST",
        url: "/account/getEventData/" + id,
        dataType: 'JSON',
        success: function (data) {
            data.title = 'Editing Event';
            data = $.extend(data, additionalSettings);
            schedule(data);
        },
        error: function () {
            swal({
                title: "There was an error retrieving the event information. Please refresh and try again.",
                type: "warning"
            });
        }
    });
}

$(document).ready(function () {

    // Address Autocomplete
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    initAutocomplete();

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('schedule-location')),
            {});
    }



    //init dialog
    $("#scheduler_dialog").dialog({
        width: 700,
        modal: true,
        autoOpen: false,
        buttons: [
            {
                text: 'Save',
                click: function () {
                    if ((!$("#schedule-name").val() || !$("#schedule-text").val() || !$("#schedule-startDate").val() || !$("#schedule-startTime"))) {
                        swal({
                            title: "All fields are required!!",
                            type: "warning"
                        });
                    } else {
                        $("#scheduleEventForm").submit();
                    }
                },
                class: 'update-button'
            },
            {
                text: 'Cancel',
                click: function () {
                    $(this).dialog('close')
                }
            }
        ]
    });
    $(".schedule-event-delete, #schedule-event-delete").on('click', function () {
        var eventId = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the event after deletion!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }).then(function () {
            $.ajax({
                url: "/account/deleteEvent",
                type: "POST",
                data: {
                    id: eventId
                },
                success: function () {
                    document.location.reload();
                }
            });
        });
        return false;
    });
    $(".schedule-event-complete, #schedule-event-complete").on('click', function () {
        var eventId = ($(this).parents('tr.existingEvent').data('id'));
        swal({
            title: "Are you sure?",
            text: "Proceeding will mark the event as completed.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, complete it!",
            closeOnConfirm: false
        }).then(function () {
            $.ajax({
                url: "/account/completeEvent",
                type: "POST",
                data: {
                    id: eventId
                },
                success: function () {
                    document.location.reload();
                }
            });
        });
        return false;
    });
    $(".schedule-event-uncomplete, #schedule-event-uncomplete").on('click', function () {
        var eventId = ($(this).parents('tr.existingEvent').data('id'));
        swal({
            title: "Are you sure?",
            text: "Proceeding will mark the event as not completed.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: false
        }).then(function () {
            $.ajax({
                url: "/account/completeEvent",
                type: "POST",
                data: {
                    id: eventId,
                    revert: 1
                },
                success: function () {
                    document.location.reload();
                }
            });
        });
        return false;
    });
    //init inputs/etc
    $("#schedule-startDate, #schedule-endDate, #schedule-remindDate").datepicker({
        minDate: "TODAY"
    });

    //schedule client call code
    $('body').on('click', ".scheduleClientCall", function () {
        $('#newClientsPopup').hide();
        var client = $(this).data('client');
        var account = $(this).data('account');
        var contactName = $(this).data('contactname');
        var phone = $(this).data('phone');
        schedule({
            client: client,
            account: account,
            title: 'Schedule New Event',
            name: 'Call ' + contactName,
            text: 'Call contact ' + contactName + ' - ' + phone
        });
        return false;
    });
    //schedule prospect call code
    $('body').on('click', ".scheduleProspectCall", function () {
        $('#newProspectsPopup').hide();
        var prospect = $(this).data('prospect');
        var account = $(this).data('account');
        var prospectName = $(this).data('prospectname');
        var phone = $(this).data('phone');
        schedule({
            prospect: prospect,
            account: account,
            title: 'Schedule New Event',
            name: 'Call ' + prospectName,
            text: 'Call prospect ' + prospectName + ' - ' + phone
        });
        return false;
    });
    //schedule proposal event
    $('body').on('click', ".scheduleProposalEvent", function () {
        // Hide proposal Popup
        $("#newProposalsPopup").hide();
        var projectName = $(this).data('projectname');
        var account = $(this).data('account');
        var proposal = $(this).data('proposal');
        schedule({
            account: account,
            proposal: proposal,
            title: 'Schedule new Event',
            name: 'Reminder for Proposal ' + projectName,
            text: 'Reminder Text'
        });
        return false;
    });
    //schedule lead event
    $('body').on('click', ".scheduleLeadEvent", function () {
        $('#newLeadsPopup').hide();
        var projectName = $(this).data('projectname');
        var account = $(this).data('account');
        var lead = $(this).data('lead');
        schedule({
            account: account,
            lead: lead,
            title: 'Schedule new Event',
            name: 'Reminder for Lead ' + projectName,
            text: 'Reminder Text'
        });
        return false;
    });

    $("#addNewEvent").on('click', function () {
        var account = $(this).data('account');
        schedule({
            account: account,
            title: 'New Event',
            name: 'Event Name',
            text: 'Event Text'
        });
    });

    $(".schedule-event-edit").on('click', function () {
        var additionalSettings = {};
        var parent = $(this).parents('tr.existingEvent');
        var id = $(parent).data('id');

        if ($(parent).data('redirect')) {
            additionalSettings['redirect'] = $(parent).data('redirect');
        }
        editScheduledEvent(id, additionalSettings);
    });


    $("#setFinishTime").click(function () {

        var startDateString = $("#schedule-startDate").val();
        var startTimeString = $("#schedule-startTime").val();
        startTimeString = startTimeString.replace(' ', '');
        var momentString = startDateString + ' ' + startTimeString;
        var startMoment = moment(momentString, 'MM/DD/YYYY h:mm a');
        var endMoment = startMoment.add(1, 'hour');
        var endDateString = endMoment.format('MM/DD/YYYY');
        var endTimeString = endMoment.format('h:mm');
        var endPeriod = endMoment.format('A');


        return false;
    });

    $("#schedule-startDate, #schedule-startTimeHr, #schedule-startTimeMin, #schedule-startPeriod").change(function () {
        setFinishTime();
    });

    $('#schedule-startTimeHr, #schedule-endTimeHr').on('change', function () {
        var val = parseInt($(this).val());
        if (val > 12) {
            $(this).val(1);
        }
    });

    $('#schedule-startTimeMin, #schedule-endTimeMin').on('change', function () {
        var val = parseInt($(this).val());
        if (val < 10) {
            $(this).val('0' + val);
        }
        else if (val > 59) {
            $(this).val('59');
        }
    });

    function setFinishTime() {
        var startDateString = $("#schedule-startDate").val();
        var startHour = $("#schedule-startTimeHr").val();
        var startMinutes = $("#schedule-startTimeMin").val();
        var startTimePeriod = $("#schedule-startPeriod").val();
        var startTimeString = startHour + ':' + startMinutes + ' ' + startTimePeriod;
        var momentString = startDateString + ' ' + startTimeString + ' ' + startTimePeriod;
        var startMoment = moment(momentString, 'MM/DD/YYYY h:mm a');
        var endMoment = startMoment.add(1, 'hour');
        var endDateString = endMoment.format('MM/DD/YYYY');
        var endTimeHr = endMoment.format('h');
        var endTimeMin = endMoment.format('mm');
        var endPeriod = endMoment.format('A');

        $("#schedule-endDate").val(endDateString);
        $("#schedule-endTimeHr").val(endTimeHr);
        $("#schedule-endTimeMin").val(endTimeMin);
        $("#schedule-endPeriod").val(endPeriod);

        $.uniform.update();
    }

    function checkFinishAfterStart() {
        var startDateString = $("#schedule-startDate").val();
        var startTimeString = $("#schedule-startTime").val();
        var startTimePeriod = $("#schedule-startPeriod").val();
        var startMomentString = startDateString + ' ' + startTimeString + ' ' + startTimePeriod;
        var startMoment = moment(startMomentString, 'MM/DD/YYYY h:mm A');

        var endDateString = $("#schedule-endDate").val();
        var endTimeString = $("#schedule-endTime").val();
        var endTimePeriod = $("#schedule-endPeriod").val();
        var endMomentString = endDateString + ' ' + endTimeString + ' ' + endTimePeriod;
        var endMoment = moment(endMomentString, 'MM/DD/YYYY h:mm a');

        return startMoment.isBefore(endMoment);
    }


});