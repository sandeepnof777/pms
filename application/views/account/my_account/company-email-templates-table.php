<?php
foreach ($templateTypes as $templateType) {
    $foundDisabled = false;
    ?>
    <div class="clientTemplatesTypeContainer" id="typeSection_<?php echo $templateType->getTypeId(); ?>">
        <h3>
            <a class="btn update-button" href="<?php echo site_url('account/company_email_templates/add/' . $templateType->getTypeId()) ?>" style="font-size: 12px; padding: 0px 2px;">Add <?php echo $templateType->getTypeName(); ?> Template</a>
        </h3>
        <p style="text-align: center; padding: 10px;">Note: First Template in the category will be the default pulled up when you are sending.</p>
        <table id="templatesTable_<?php echo $templateType->getTypeId() ?>" class="boxed-table templateTable" width="100%" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center; height: 33px;" width="50">Order</th>
                    <th style="text-align: left;">Template Name</th>
                    <th style="text-align: left;">Description</th>
                    <th style="text-align: left;">Updated At</th>
                    <th style="text-align: center;" width="122">Actions</th>
                </tr>
            </thead>
            <tbody class="templates-sortable" data-type-id="<?php echo $templateType->getTypeId(); ?>">
            <?php
            
            foreach ($templates[$templateType->getTypeId()] as $template) {
                
            /* @var $template \models\ClientEmailTemplate */
            if ($template->isDisabled($account->getCompany()->getCompanyId()) && !$foundDisabled) {
            $foundDisabled = true;
            ?>
            </tbody>
            <tbody class="disabled-templates" style="color: #B1ACAF;">
            <?php
            }
            ?>
            <tr id="templates_<?php echo $template->getTemplateId(); ?>">
                <td><?php if (!$foundDisabled) { ?><span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;" title="Drag to sort"></span><?php } ?></td>
                <td><?php echo $template->getTemplateName() ?></td>
                <td><?php echo $template->getTemplateDescription() ?></td>
                <td><?php echo ($template->getUpdateAt())?$template->getUpdateAt()->format('m/d/y g:ia'):'-' ?></td>
                <td style="text-align: left;">
                    <?php if ($template->getCompany()) { ?>
                        <a href="<?php echo site_url('account/company_email_templates/edit/' . $template->getTemplateId()) ?>" class="tiptip btn-edit" style="display: inline-block" title="Edit Template">&nbsp;</a>
                    <?php } else { ?>
                        <a href="#" class="tiptip noAction btn-locked-template" style="display: inline-block" title="This template is locked for editing" data-template-id="<?php echo $template->getTemplateId(); ?>">&nbsp;</a>
                    <?php } ?>
                    <a href="<?php echo site_url('account/company_email_templates/duplicate/' . $template->getTemplateId()) ?>" class="tiptip btn-duplicate-template" style="display: inline-block" title="Duplicate Template">&nbsp;</a>
                    <?php if ($template->getCompany()) { ?>
                        <a href="#" class="tiptip templateDelete btn-delete" style="display: inline-block" title="Delete Template" data-template-id="<?php echo $template->getTemplateId(); ?>">&nbsp;</a>
                    <?php
                    } else {

                        if($template->getDefaultTemplate()){
                            ?>
                            <a href="#" class="tiptip noAction btn-locked-template" style="display: inline-block" title="This template cannot be disabled" data-template-id="<?php echo $template->getTemplateId(); ?>">&nbsp;</a>
                        <?php
                        }
                        else if (!$template->isDisabled($account->getCompany()->getCompanyid())) {
                            ?>
                            <a href="<?php echo site_url('account/company_email_templates/disable/' . $template->getTemplateId()) ?>" class="tiptip btn-disabled templateDisable" data-template-id="<?php echo $template->getTemplateId(); ?>" style="display: inline-block" title="Disable Template">&nbsp;</a>
                        <?php } else { ?>
                            <a href="<?php echo site_url('account/company_email_templates/enable/' . $template->getTemplateId()) ?>" class="tiptip btn-enabled" data-template-id="<?php echo $template->getTemplateId(); ?>" style="display: inline-block" title="Enable Template">&nbsp;</a>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        function updateRowColors() {
            var k = 0;
            $("tbody.templates-sortable tr").each(function () {
                $(this).removeClass('even');
                k++;
                if (!(k % 2)) {
                    $(this).addClass('even');
                }
            });
        }
        updateRowColors();
        //disabling some buttons so they don't scroll the page to top
        $(".noAction").click(function () {
            return false;
        });
        // Deleting a template
        $(".templateDelete").click(function () {
            var templateId = $(this).data('template-id');
            $("#confirm-delete-template").data('template-id', templateId);
            $("#confirm-delete-template").dialog('open');
            return false;
        });
        // Dialog to confirm deletion
        $("#confirm-delete-template").dialog({
            width: 400,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete',
                    'class': 'btn ui-button update-button',
                    click: function () {
                        window.location.href = '<?php echo site_url('account/company_email_templates/delete'); ?>/' + $(this).data('template-id');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        // Disabling a template
        $(".templateDisable").click(function () {
            var templateId = $(this).data('template-id');
            $("#confirm-disable-template").data('template-id', templateId);
            $("#confirm-disable-template").dialog('open');
            return false;
        });
        // Dialog to confirm deletion
        $("#confirm-disable-template").dialog({
            width: 400,
            modal: true,
            buttons: {
                "Disable": {
                    text: 'Disable',
                    'class': 'btn ui-button update-button',
                    click: function () {
                        window.location.href = '<?php echo site_url('account/company_email_templates/disable'); ?>/' + $(this).data('template-id');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        // Sortable templates
        $('.templates-sortable').sortable({
                handle: '.handle',
                stop: function () {
                    updateRowColors();
                    var ordered_data = $(this).sortable("serialize");
                    ordered_data += '&templateType=' + $(this).data('type-id');
                    $.ajax({
                        url: '<?php echo site_url('account/ajaxSortTemplates') ?>',
                        type: "POST",
                        data: ordered_data,
                        dataType: "json",
                        success: function (data) {

                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                }
            }
        );
        <?php
         if (is_numeric($this->uri->segment(3))) {
        ?>
        var panelId = <?php echo $this->uri->segment(3); ?>;
        <?php
        } else {
        ?>
        var panelId = $('.typeLink:first').data('type-id');
        <?php
        }
         ?>
        showPanel(panelId);
//        $('.typeLink:first').addClass('active');
        // 'Tab' Behaviour
        $('.typeLink').click(function () {
            //console.log($(this).data('type-id'));
            showPanel($(this).data('type-id'));
//            $('.typeLink').removeClass('active');
//            $(this).addClass('active');
            return false;
        });
        function showPanel(panelId) {
            $('.clientTemplatesTypeContainer').hide();
            $('#typeSection_' + panelId).show();
            $(".typeLink").removeClass('active');
            $(".typeLink_"+panelId).addClass('active');
        }
    });
</script>

<div id="confirm-delete-template" title="Confirm" data-template-id="">
    <p>Are you sure you want to delete this email template?</p>
</div>

<div id="confirm-disable-template" title="Confirm" data-template-id="">
    <p>Are you sure you want to disable this email template?</p>
</div>