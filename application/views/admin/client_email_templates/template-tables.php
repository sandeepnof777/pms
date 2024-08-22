<div id="newFilter">
    <div class="clearfix">
        <?php
        foreach ($templateTypes as $templateType) {
            /* @var $templateType \models\ClientEmailTemplateType */
            ?>
            <div class="filter-box">
                <a href="#" class="typeLink trigger noarrow typeLink_<?php echo $templateType->getTypeId(); ?>" data-type-id="<?php echo $templateType->getTypeId(); ?>"><?php echo ($templateType->isHidden()) ? '[H] ':''; ?><?php echo $templateType->getTypeName(); ?></a>
            </div>
            <div class="filter-box" style="float: right !important;"><a class="clientTemplatesTypeContainer typeSection_<?php echo $templateType->getTypeId() ?> trigger noarrow blueButton"
                                                                        href="<?php echo site_url('admin/client_email_templates/add/type/' . $templateType->getTypeId()) ?>">Add <?php echo $templateType->getTypeName(); ?> Template</a></div>
        <?php } ?>
    </div>
</div>

<?php
foreach ($templateTypes as $templateType) {
    /* @var $templateType \models\ClientEmailTemplateType */
    ?>
    <div class="clientTemplatesTypeContainer typeSection_<?php echo $templateType->getTypeId() ?>">

        <!--<div class="newClientTemplate">
            <a href="<?php echo site_url('admin/client_email_templates/add/type/' . $templateType->getTypeId()) ?>">
                <button type="submit" class="btn ui-button update-button">Add New <?php echo $templateType->getTypeName(); ?> Template</button>
            </a>
        </div>-->

        <div class="clearfix"></div>


        <div class="content-box">
            <div class="box-header">
                <?php echo $templateType->getTypeName(); ?> Email Templates
            </div>
            <div class="box-content">
                <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <td width="20">#</td>
                        <td style="text-align: left;">Template</td>
                        <td style="text-align: left;">Description</td>
                        <td style="text-align: left;">Updated At</td>
                        <td style="text-align: left;" width="40">Actions</td>
                    </tr>
                    </thead>
                    <tbody class="templates-sortable" data-template-type-id="<?php echo $templateType->getTypeId(); ?>">
                    <?php

                    if (isset($templates[$templateType->getTypeId()])) {

                        $numTemplates = count($templates[$templateType->getTypeId()]);

                        foreach ($templates[$templateType->getTypeId()] as $template) {
                            ?>
                            <tr id="templates_<?php echo $template->getTemplateId(); ?>">
                                <td><span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;" title="Drag to sort"></span></td>
                                <td><?php echo $template->getTemplateName() ?></td>
                                <td><?php echo $template->getTemplateDescription() ?></td>
                                <td><?php echo ($template->getUpdateAt())?$template->getUpdateAt()->format('m/d/y g:ia'):'-' ?></td>
                                <td width="15%" style="text-align: center">
                                    <a class="tiptip btn-edit" title="Edit this template" href="<?php echo site_url('admin/client_email_templates/edit/' . $template->getTemplateId()) ?>">Edit</a>
                                    <a class="tiptip btn-duplicate-template" title="Duplicate this template" href="<?php echo site_url('admin/client_email_templates/duplicate/' . $template->getTemplateId()) ?>">Duplicate</a>
                                    <?php
                                    // Only show delete button if there's more than one
                                    if ($numTemplates > 1) {
                                        ?>
                                        <a class="btn deleteTemplate tiptip btn-delete"
                                           data-template-id="<?php echo $template->getTemplateId(); ?>"
                                           data-template-name="<?php echo $template->getTemplateName(); ?>"
                                           title="Delete this template"
                                           href="<?php echo site_url('admin/client_email_templates/delete/' . $template->getTemplateId()) ?>">Delete</a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr class="" style="text-align: center">
                            <td colspan="4">No Templates Found</td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>


<div id="confirm-delete" title="Confirmation" data-template-id="">
    <p>Are you sure you want to delete the email template '<strong><span id="deleteTemplateName"></span></strong>'?</p>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        //Type Selection code
        <?php 
         if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
         ?>
        var panelId = $('.typeLink:first').data('type-id');
        <?php } else {
        ?>
        var panelId = <?php echo $this->uri->segment(3); ?>;
        <?php
        }
        ?>
        showPanel(panelId);
        $('.typeLink_' + panelId).addClass('blue').addClass('filterButton').removeClass('trigger');


        // 'Tab' Behaviour
        $('.typeLink').click(function () {
            showPanel($(this).data('type-id'));
            $('.typeLink').removeClass('blue').removeClass('filterButton').addClass('trigger');
            $(this).addClass('blue').addClass('filterButton').removeClass('trigger');
        });

        function showPanel(panelId) {
            $('.clientTemplatesTypeContainer').hide();
            $('.typeSection_' + panelId).show();
        }


        // Delete dialog
        $('#confirm-delete').dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: {
                    text: 'Delete',
                    class: 'ui-btn update-button',
                    click: function () {
                        window.location.href = "<?php echo site_url('admin/client_email_templates/delete'); ?>/" + $('#confirm-delete').data('template-id');
                        $(this).dialog("close");
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        // Delete template action
        $(".deleteTemplate").click(function () {
            // Update the dialog attributes
            $('#confirm-delete').data('template-id', $(this).data('template-id'));
            $('#deleteTemplateName').html($(this).data('template-name'));

            $('#confirm-delete').dialog('open');
            return false;
        });

        // Sortable templates
        $('.templates-sortable').sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = $(this).sortable("serialize");
                    $.ajax({
                        url: '<?php echo site_url('admin/ajaxSortTemplates') ?>',
                        type: "POST",
                        data: ordered_data,
                        dataType: "json",
                        success: function (data) {
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