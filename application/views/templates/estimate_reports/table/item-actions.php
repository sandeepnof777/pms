
<a href="#" class="editItem btn tiptip" title="Edit Item"
   data-item-id="<?php echo $data->itemId ?>"
   data-unit-id="<?php echo $data->unitId; ?>"
   data-category-id="<?php echo $data->categoryId ?>"
   data-type-id="<?php echo $data->typeId; ?>"
   data-item-name="<?php echo $data->itemName; ?>"
   data-item-vendor="<?php echo $data->itemVendor; ?>"
   data-item-sku="<?php echo $data->itemSku; ?>"
   data-item-base-price="<?php echo $data->itemBasePrice ?>"
   data-item-overhead-rate="<?php echo $data->itemOhRate ?>"
   data-item-overhead-price="<?php echo $data->itemOhPrice; ?>"
   data-item-profit-rate="<?php echo $data->itemPmRate; ?>"
   data-item-profit-price="<?php echo $data->itemPmPrice; ?>"
   data-item-taxable="<?php echo $data->itemTaxable; ?>"
   data-item-notes="<?php echo $data->itemNotes; ?>"
   data-item-unit-price="<?php echo $data->itemUnitPrice; ?>"
   data-item-tax-rate="<?php echo $data->itemTaxRate; ?>"
   data-item-capacity="<?php echo $data->itemCapacity; ?>">
    <i class="fa fa-fw fa-edit"></i>
</a>
<a href="javascript:void(0);" class="item_price_changes_show btn tiptip"  data-item-name="<?php echo $data->itemName; ?>" data-item-id="<?php echo $data->itemId ?>" title="Price History">
   
    <i class="fa fa-fw fa-history"></i>
</a>
<a href="javascript:void(0);" class="btn tiptip assignTemplate" title="Assign Template"
data-item-id="<?php echo $data->itemId ?>">
                        <i class="fa fa-list"></i>
                    </a>

