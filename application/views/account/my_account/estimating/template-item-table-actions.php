<?php if ($inTemplate) : ?>
    <a href="#" class="deleteTemplateItem btn red tiptip" title="Remove Item from Assembly"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-minus"></i>
    </a>
<?php else : ?>
    <a href="#" class="addItemToTemplate btn green tiptip" title="Add Item To Assembly"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-plus"></i>
    </a>
<?php endif; ?>

<?php if ($item->unitType == \models\EstimationUnitType::TIME) : ?>
    <a href="#" class="btn tiptip setItemDefaults" title="Set Assembly Item Defaults" data-eti="<?= $item->etiId ?>"
        data-default-qty="<?php echo $item->default_qty ?>" data-default-days="<?php echo $item->default_days; ?>"
        data-default-hpd="<?php echo $item->default_hpd; ?>" data-category="<?php echo $item->categoryName ?>"
        data-type="<?php echo $item->typeName; ?>" data-item-name="<?php echo $item->name; ?>">
        <i class="fa fa-fw fa-clock-o"></i>
    </a>
<?php endif; ?>
