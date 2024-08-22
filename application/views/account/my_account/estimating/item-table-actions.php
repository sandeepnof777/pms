<?php if ($inTemplate) : ?>
    <a href="#" class="deleteTemplateItem btn red tiptip" title="Remove from Assembly"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-minus"></i>
    </a>
<?php else : ?>
    <a href="#" class="addItemToTemplate btn green tiptip" title="Add to Assembly"
       data-item-id="<?= $itemId ?>" >
        <i class="fa fa-fw fa-plus"></i>
    </a>
<?php endif; ?>
