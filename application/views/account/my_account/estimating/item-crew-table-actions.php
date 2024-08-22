<?php if ($inTemplate) : ?>
    <a href="JavaScript:void(0);" class="deleteCrewItem btn red tiptip" title="Remove from Crew"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-minus"></i>
    </a>
<?php else : ?>
    <a href="JavaScript:void(0);" class="addItemToCrew btn green tiptip" title="Add to Crew"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-plus"></i>
    </a>
<?php endif; ?>
