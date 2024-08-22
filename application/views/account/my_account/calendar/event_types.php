<?php
    $numTypes = count($event_types);
?>

<div class="padded">
    <form action="<?= site_url('account/event_types') ?>" method="post" id="add-event-type">
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <label for="">Name:</label>
                    <input type="text" name="typeData[name]" id="name" class="text">
                    <input type="hidden" name="addType" value="1">
                    <input type="hidden" name="typeData[company]" value="<?= $account->getCompany()->getCompanyId() ?>">
                    <input type="hidden" name="typeData[notification]" value="0">
                    <input type="submit" value="Add Event Type" class="btn update-button small" style="padding-top: 3px !important; padding-bottom: 3px !important;">
                </td>
            </tr>
        </table>
    </form>
</div>
<table class="boxed-table" width="100%" cellspacing="0" cellpadding="0" id="eventTypes">
    <thead>
    <tr>
        <th width="50" style="height: 33px;" class="center">Order</th>
        <td class="center">Name</td>
        <td class="center">Color</td>
        <td class="center">Text Color</td>
        <td class="center">Actions</td>
    </tr>
    </thead>
    <tbody class="event_types_sortable">
    <?php foreach ($event_types as $eventType): ?>
        <tr id="event_types_<?= $eventType->id; ?>">
            <td style="text-align: center">
                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;" title="Drag to sort"></span>
            </td>
            <td><?= (!$eventType->company) ? '<span class="event-type-default-badge">Default</span>' : ''; ?><span id="event_name_<?= $eventType->id ?>"><?= $eventType->name ?></span></td>
            <td><div class="centerContainer"><input data-id="<?= $eventType->id ?>" type='text' class="backgroundColor" data-update="backgroundColor" id="backgroundColor_<?= $eventType->id ?>" value="<?= ($eventType->backgroundColor) ?: '#FFFFFF' ?>" <?php if (!$eventType->company) { ?>data-disabled="true"<?php } ?> /></div></td>
            <td><div class="centerContainer"><input data-id="<?= $eventType->id ?>" type='text' class="color" data-update="color" id="color_<?= $eventType->id ?>" value="<?= ($eventType->color) ?: '#FFFFFF' ?>" <?php if (!$eventType->company) { ?>data-disabled="true"<?php } ?> /></div></td>
            <td>
                <?php if ($eventType->company): ?>
                <a href="#" class="btn btn-edit tiptip editEventName" title="Edit Event Type" data-id="<?= $eventType->id ?>">&nbsp;</a>
                <?php endif; ?>
                <?php if ($numTypes > 1): ?>
                <a href="#" class="btn btn-delete tiptip delete-event" title="Delete Event Type" data-id="<?= $eventType->id ?>">&nbsp;</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script>

    var eventTypes = {};
    <?php foreach ($event_types as $eventType): ?>
        eventTypes.type_<?php echo $eventType->id ?> = '<?php echo $eventType->name; ?>';
    <?php endforeach; ?>

    $(document).ready(function () {
        $("#add-event-type").on('submit', function () {
            if (!$("#name").val()) {
                swal('Error', 'You must supply a name for the event type!', 'warning');
                return false;
            }
        });
        $(".delete-event").on('click', function () {
            var deleteEventId = $(this).data('id');

            // Remove this one from the list
            var filteredEventTypes = JSON.parse(JSON.stringify(eventTypes));
            delete filteredEventTypes['type_' + deleteEventId];

            swal({
                title: "Are you sure?",
                html: "<p>This will delete the event type.</p><br /><p>Transfer events to:</p>",
                type: "warning",
                input: 'select',
                inputOptions: filteredEventTypes,
                inputValidator: function (value) {
                    return new Promise(function (resolve, reject) {
                        if (value) {
                            resolve()
                        } else {
                            reject('New Event Type Must be selected')
                        }
                    })
                },
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, do it!",
                closeOnConfirm: false
            }).then(function (result) {
                result = result.replace('type_', '');

                $.ajax({
                    url: "/account/delete_type/" + deleteEventId + '/' + result,
                    type: "POST",
                    success: function () {
                        document.location.reload();
                    }
                });
            });
        });
        $(".editEventName").on('click', function () {
            var id = $(this).data('id');
            var currentTitle = $("#event_name_" + id).text();
            swal({
                title: 'Edit Event Type Name',
                input: 'text',
                inputValue: currentTitle,
                showCancelButton: true,
                confirmButtonText: 'Save',
                inputValidator: function (value) {
                    return new Promise(function (resolve, reject) {
                        if (value) {
                            resolve()
                        } else {
                            reject('Name is required!')
                        }
                    })
                }
            }).then(function (result) {
                $.ajax({
                    url: "/account/update_type/" + id,
                    type: "POST",
                    data: {
                        name: result
                    },
                    success: function () {
                        $("#event_name_" + id).text(result);
                    }
                });
            })
        });
        $(".color, .backgroundColor").each(function() {
            var id = $(this).data('id');
            var disabled = false;
            var color = $(this).val();
            var updateField = $(this).data('update');
            if ($(this).data('disabled')) {
                disabled = true;
            }
            $(this).spectrum({
                color: color,
                disabled: disabled,
                change: function(color) {
                    data = {};
                    data[updateField] = color.toHexString();
                    $.ajax({
                        url: "/account/update_type/" + id,
                        type: "POST",
                        data: data
                    });
                }
            });
        });

        function updateRowColors() {
            var k = 0;
            $("#eventTypes tbody tr").each(function () {
                $(this).removeClass('even');
                k++;
                if (!(k % 2)) {
                    $(this).addClass('even');
                }
            });
        }

        updateRowColors();

        // Sortable events
        $('.event_types_sortable').sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = $(this).sortable("serialize");
                    $.ajax({
                        url: '<?php echo site_url('ajax/order_event_types') ?>',
                        type: "POST",
                        data: ordered_data,
                        dataType: "json",
                        success: function (data) {
//                            console.log(data);
                            updateRowColors();
                            if (data.error) {
                                alert(data.error);
                            } else {
//                                document.location.reload();
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                }
            }
        );

    });
</script>