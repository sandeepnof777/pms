<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box" id="manage-items">
            <div class="box-header">
                Manage Items <?php echo (isset($selectedItem)) ? ' - Editing item: ' . $selectedItem->getItemName() : ''; ?>
                <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
            </div>
            <div class="box-content padded">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <tr>
                        <td width="180" style="color: #000; text-align: center; font-size: 13px;" class="padded"><b>Select Item</b></td>
                        <td style="color: #000; text-align: center; font-size: 13px;" class="padded"><b>Item Text</b></td>
                        <td width="150" style="color: #000; text-align: center; font-size: 13px;" class="padded"><b>Item Fields</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td valign="top" id="items" style="text-align: center;">
                            <?php
                            foreach ($items as $item) {
                                ?>
                                <a href="<?php echo site_url('admin/manage_items/' . $item->getItemId()) ?>" rel="<?php echo $item->getItemId() ?>" style="font-size: 12px; width: 150px;" class="btn"><?php echo $item->getItemName() ?></a><br>
                                <?php
                            }
                            ?>
                        </td>
                        <td valign="top">
                            <?php if (!isset($selectedItem)) { ?>
                            <div id="select-item-div" style="padding: 100px; text-align: center;">Please select an item on the left to edit it.</div>
                            <?php
                        } else {
                            $fields = $selectedItem->getFields();
                            $fieldArray = array();
                            foreach ($fields as $field) {
                                $fieldArray[$field->getFieldLabel()] = $field->getFieldName();
                            }
                            ?>
                            <div id="itemBuilder">
                                <?php
                                $itemText = $selectedItem->getItemText();
                                $bits = explode('%%%', $itemText);
                                $k = 0;
                                foreach ($bits as $bit) {
                                    $k++;
                                    if (trim($bit)) {
                                        $block = explode('%%', $bit);
                                        if ($block[0] != 'static') {
                                            $condition_array = explode('|', $block[0]);
                                        }
                                        ?>
                                        <h3><a href="#">Text Block - <?php echo ($block[0] == 'static') ? 'Static' : 'Conditional';  ?></a></h3>
                                        <div class="padded textBlock" id="tb_<?php echo $k; ?>">
                                            <p class="clearfix">
                                                <label>Type</label>
                                                <select name="type">
                                                    <option value="static">Static</option>
                                                    <option value="conditional" <?php echo ($block[0] != 'static') ? 'selected="selected"' : ''; ?>>Conditional</option>
                                                </select>
                                            </p>
                                            <p class="clearfix condition" <?php  echo ($block[0] == 'static') ? 'style="display:none;"':''; ?>>
                                                <label>Condition Field</label>
                                                <?php echo form_dropdown(
                                                'condition', $fieldArray, @$condition_array[0]
                                            ) ?>
                                                <input type="text" name="condition_value" value="<?php echo @$condition_array[1] ?>">
                                            </p>
                                            <p class="clearfix">
                                                <label>Text</label>
                                                <textarea class="item-text" name="item-text" cols="50" rows="10"><?php echo @$block[1] ?></textarea>
                                            </p>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                            </div>
                            <a href="#" class="btn update-button" id="save">Save</a>
                            <?php
                        } ?>
                            <div id="edit-item-div" style="display: none;">
                                <textarea name="itemText" id="itemText" cols="30" rows="10" style="width:95%; height: 100px;"></textarea>
                                <input type="hidden" name="itemId" id="itemId">
                            </div>
                        </td>
                        <td valign="top" id="fields" style="text-align: center;"><?php
                            if (isset($selectedItem)) {
                                foreach ($fields as $field) {
                                    ?><strong><?php echo $field->getFieldName() ?></strong><input type="text" value="##<?php echo $field->getFieldLabel() ?>##"><br><?php
                                }
                            }
                            ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /*if ($("#typeSelect").val() == 'static') {
            $("#condition").hide();
        } else {
            $("#condition").show();
        }
        $("#typeSelect").change(function () {
            if ($("#typeSelect").val() == 'static') {
                $("#condition").hide();
            } else {
                $("#condition").show();
            }
        });*/
        $("#items a").click(function () {
            /*var itemId = $(this).attr('rel'); */
            var request = $.ajax({
                url:"<?php echo site_url('admin/getItemDetails') ?>/" + itemId,
                type:"POST",
                data:{},
                dataType:"json",
                success:function (data) {
                    if (data.success == 'true') {
                        $("#itemText").html(data.itemText);
                        $("#select-item-div").hide();
                        $("#edit-item-div").show();
                        $("#itemId").val(itemId);
                        $("#fields").html('');
                        fields = data.fields;
                        for (fieldLabel in fields) {
                            $("#fields").append('<strong>' + fields[fieldLabel] + '</strong><br><input type="text" value="##' + fieldLabel + '##">' + '<br>');
                        }
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            });
            return false;*/
        });
        $("#save").click(function () {
            $("#itemId").val('');
            $("#itemText").html('');
            $("#edit-item-div").hide();
            $("#select-item-div").show();
            $("#fields").html('');
        });
        $("#itemBuilder").accordion({
            collapsible:true,
            autoHeight:false,
            navigation:true
        }).sortable({
                    axis:"y",
                    handle:"h3"
                });
    });
</script>
<?php $this->load->view('global/footer'); ?>
