<?php if ($inTemplate) : ?>
    <a href="#" class="deleteCrewItem btn red tiptip" title="Remove Item from Crew"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-minus"></i>
    </a>
<?php else : ?>
    <a href="#" class="addItemToCrew btn green tiptip" title="Add Item To Crew"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-plus"></i>
    </a>
<?php endif; ?>

<?php if ($item->unitType == \models\EstimationUnitType::TIME) : ?>
    <a href="#" class="btn tiptip setItemDefaults" title="Set Crew Item Defaults" data-eti="<?= $item->etiId ?>"
        data-default-qty="<?php echo $item->default_qty ?>" data-default-days="<?php echo $item->default_days; ?>"
        data-default-hpd="<?php echo $item->default_hpd; ?>" data-category="<?php echo $item->categoryName ?>"
        data-type="<?php echo $item->typeName; ?>" data-item-name="<?php echo $item->name; ?>">
        <i class="fa fa-fw fa-edit"></i>
    </a>
<?php endif; ?>
