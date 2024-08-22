<div id="accordion_texts">
    <?php
    foreach ($texts_categories as $cat) {
        ?>
        <div id="text_category_<?php echo $cat->getCategoryId() ?>" class="textCategory">
            <h3 class="categoryHeading">
                <span class="includedTextCategory"></span>
                <a href="#"><?php echo $cat->getCategoryName() ?></a>
            </h3>

            <div>
                <p class="clearfix" style="padding: 3px 0;">
                            <span style="position: absolute; left: 10px;">Check: <a href="#" class="CTCheckAll" style="color: #189DE1;">All</a> | <a
                                        href="#" class="CTCheckNone" style="color: #189DE1;">None</a></span>
                    <label style="width: 200px; display: block; margin: 0 auto;">
                        <b>Include in proposal</b>
                        <input type="checkbox" <?php if (@$orderedcats[$cat->getCategoryId()]) {
                            echo 'checked="checked"';
                        } ?> class="categoryInclude" name="textcat-<?php echo $cat->getCategoryId() ?>"
                               id="textcat-<?php echo $cat->getCategoryId() ?>" data-category-id="<?php echo $cat->getCategoryId(); ?>">
                    </label>
                </p>
                <?php
                $k = 0;
                $texts_array = $proposal->getTexts();
                foreach ($texts as $textId => $text) {
                    if ($text->getCategory() == $cat->getCategoryId()) {
                        $k++;
                        ?>
                        <p class="clearfix" style="padding: 3px 0;">
                            <label>
                                <input type="checkbox" <?php if (in_array($textId,
                                    $texts_array)) { ?> checked="checked"<?php } ?>
                                       name="checkbox_<?php echo $text->getTextId() ?>"
                                       id="<?php echo $textId ?>" class="customTextCheckbox">
                                <span class="editProposal-customtext"><?php echo $text->getText() ?></span>
                            </label>
                        </p>
                        <?php
                    }
                }
                if (!$k) {
                    ?>
                    <div class="centered padded">No texts found. You can edit them under <a
                            style="color: #25AAE1;" href="<?php echo site_url('account/custom_texts') ?>">My
                        Account > Proposal Details</a>.</div><?php
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>