<?php

if (count($specs)) {
    ?>
    
    <!--Hide Header code start-->
    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200;">Product Info</h1>
    <?php
    foreach ($specs as $item => $specz) {
        ?>
        <div class="spec">
            <h2><?php echo $item ?></h2>

            <div class="spec-content">
                <?php
                foreach ($specz as $spec) {
                    echo $spec;
                }
                ?>
            </div>
        </div>
    <?php
    }
}
//Custom texts
//$cats = $this->em->createQuery('SELECT c FROM models\Customtext_categories c  where (c.company=' . $proposal->getClient()->getCompany()->getCompanyId() . ' or c.company=0)')->getResult();
$cats = $this->customtexts->getCategories($proposal->getClient()->getCompany()->getCompanyId());
$categories = array();
$havetexts = false;
$proposal_categories = $proposal->getTextsCategories();
foreach ($cats as $cat) {
    if (@$proposal_categories[$cat->getCategoryId()]) {
        $categories[$cat->getCategoryId()] = array('name' => $cat->getCategoryName(), 'texts' => array());
    }
}
$texts = $this->customtexts->getTexts($proposal->getClient()->getCompany()->getCompanyId());
$proposal_texts = $proposal->getTexts();
foreach ($texts as $textId => $text) {
    if ((in_array($textId, $proposal_texts)) && (isset($categories[$text->getCategory()]))) {
        $havetexts = true;
        $categories[$text->getCategory()]['texts'][] = $text->getText();
    }
}
if ($havetexts) {
    ?>
    <div style="page-break-after: always"></div>
    <!--Hide Header code start-->
    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Additional Info: <?php echo $proposal->getProjectName()  ?></h1>

    <div id="additional-info-section">
    
    <!--<p>&nbsp;</p>-->
    <?php
    foreach ($proposal_categories as $catId => $on) {
        if ($on && isset($categories[$catId])) {
            $cat = $categories[$catId];
            if (count($cat['texts'])) {
                ?>
                <h2><?php echo $cat['name'] ?></h2>
                <ol>
                    <?php
                    foreach ($cat['texts'] as $text) {
                        ?>
                        <li><?php echo $text; ?></li><?php
                    }
                    ?>
                </ol>
            <?php
            }
        }
    }?>
    </div>
<?php
}
?>
