<style>
    .stripping-table tr:nth-child(odd){background-color: #fafafa;}
    .stripping-table tr:nth-child(even){background-color: #efefef;}
    .after_input2 {
        padding: 6px;
        padding-left: 0px;
        display: inline-block;
    }
</style>
<form autocomplete="off" class="form-validated" accept-charset="utf-8" method="post"
      action="<?php echo site_url('account/saveEstimatingItem') ?>" id="add_item_form" >
    <input type="hidden" name="itemId" id="itemId" />


<div style="width: 380px; float: left">
    <div class="content-box" id="add-type">
        <div class="box-header">
            Item Info
        </div>
        <div class="box-content">

                <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table stripping-table">
                    <tbody>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>Item Name</label>
                                    <input type="text" value="" id="itemName" name="itemName" style="width: 180px;"
                                           class="text required" tabindex="2">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>Category</label>
                                    <select name="categoryId" id="categoryId" class="required">
                                        <option value="">-- Select Category</option>
                                        <?php
                                        foreach ($categories as $cat) {
                                            ?>
                                            <option value="<?php echo $cat->getId() ?>"><?php echo $cat->getName() ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>Type</label>
                                    <select name="typeId" id="typeId" class="required">
                                        <option value="">-- Select Type</option>
                                        <?php
                                        foreach ($types as $type) {
                                            ?>
                                            <option value="<?php echo $type->getId() ?>"
                                                    data-category="<?php echo $type->getCategoryId();  ?>">
                                                <?php echo $type->getName() ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </p>
                            </td>
                        </tr>
                        <tr class="unitRow">
                            <td>
                                <p class="clearfix left">
                                    <label>Unit</label>
                                    <select name="unitId" id="unitId" class="required" >
                                        <option value="">-- Select Unit</option>
                                        <?php foreach ($sortedUnits as $sortedUnit) { ?>

                                            <optgroup label="<?php echo $sortedUnit['unitType']->getName() ?>">
                                                <?php foreach ($sortedUnit['units'] as $unit) { ?>
                                                    <option data-val="<?php echo $unit->getSingleName(); ?>" value="<?php echo $unit->getId(); ?>"><?php echo $unit->getName(); ?> (<?php echo $unit->getAbbr(); ?>)</option>
                                                <?php } ?>
                                            </optgroup>
                                        <?php } ?>
                                    </select>
                                </p>
                            </td>
                        </tr>
                        <tr id="capacityRow">
                            <td>
                                <label>Capacity</label>
                                <input type="text" value="" id="itemCapacity" name="itemCapacity" style="width: 80px;"
                                       class="text required"> <span style="padding-top: 6px; display: inline-block;">Tons</span>
                            </td>
                        </tr>
                        <tr id="minimumHoursRow">
                            <td>
                                <label>Minimum Hours</label>
                                <input type="text" value="" id="minimumHours" name="minimum_hours" style="width: 80px;"
                                       class="text numberFormat"> <span style="padding-top: 6px; display: inline-block;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Vendor</label>
                                <input type="text" value="" id="itemVendor" name="itemVendor" style="width: 180px;"
                                       class="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>SKU</label>
                                <input type="text" value="" id="itemSku" name="itemSku" style="width: 180px;"
                                       class="text">
                                <input type="hidden" name="page" value="<?=$page;?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Notes</label>
                                <textarea value="" id="itemNotes" name="itemNotes" style="width: 180px;"
                                      rows="5" class="text">
                                </textarea >
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>


<div style="width: 380px; float: right;">

    <div class="content-box" id="add-type">
        <div class="box-header">
            Pricing
        </div>
        <div class="box-content">

                <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table stripping-table">
                    <tbody>
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Base Cost</label>
                                <input type="text" value="" id="itemBaseCost" name="itemBaseCost"
                                       class="text required currencyFormat" tabindex="2" style="width: 50px;"><span class="unit_type_text" style="position: relative;top: 6px;"></span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Overhead %</label>
                                <input type="text" value="" id="itemOverheadRate" name="itemOverheadRate"
                                       class="text required percentFormat" tabindex="2" style="width: 50px;">
                                <span class="itemOverheadPrice after_input2">$0.00</span>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Profit %</label>
                                <input type="text" value="" id="itemProfitRate" name="itemProfitRate"
                                       class="text required percentFormat" tabindex="2" style="width: 50px;">
                                <span class="itemProfitPrice after_input2">$0.00</span>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Tax <span  style="float:right;margin-left: 10px;"><input type="checkbox" id="taxable" name="taxable" class="" tabindex=""></span></label>

                                <input type="text" id="tax_rate" value="0" name="tax_rate" class="text percentFormat" tabindex=""
                                       style="width: 50px;">
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Total Unit Price</label>
                                <input type="text" id="unitPrice" name="unitPrice" class="text currencyFormat"
                                       style="width: 50px;" readonly><span class="unit_type_text" style="position: relative;top: 6px;"></span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <div class="clearfix"></div>
    <div id="updateStatusContent">

        <hr />

        <h4>Update Existing Estimates</h4>

        <p>If changing the price, existing estimates can be automatically updated. Choose which estimate statuses you
            would like to update.</p>
        <br />
        
        <p>Items with a custom price will not be updated.</p>
        <br />
        <p><a href="#" id="checkAllStatuses">All</a> / <a href="#" id="uncheckAllStatuses">None</a> </p>
        <br />

        <div style="position: relative">
            <?php foreach ($updateStatuses as $estimateStatus) : ?>
                <div class="updateStatusCheckContainer statusSelected">
                    <label>
                    <input type="checkbox" class="select statusCheck" name="updateStatus[]"
                           value="<?= $estimateStatus->getId(); ?>" checked="checked">
                    <span style="margin-top: 3px;"> <?= $estimateStatus->getName(); ?></span>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="clearfix" style="margin-bottom: 20px;"></div>
    <button class="btn blue-button" type="submit" style="float: right;">
        <i class="fa fa-fw fa-save"></i> Save Item
    </button>
</form>
