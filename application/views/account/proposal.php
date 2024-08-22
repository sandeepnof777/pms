<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Edit Proposal</h1>
        <h2>&nbsp;</h2>
        <?php print_r($proposal) ?>
        <div class="clearfix">
            <h3 class="half left">Added on <?php echo date('m-d-Y', $proposal->addedAt + TIMEZONE_OFFSET) ?></h3>
            <h3 class="half right">By <?php echo $proposal->user->firstName . ' ' . $proposal->user->lastName . ' (' . $proposal->company->companyName . ')' ?></h3>
            <h3 class="half left">Address: <?php echo $proposal->address ?></h3>
            <h3 class="half right">Type: <?php echo $proposal->type ?></h3>
        </div>
        <div class="left clearfix" style="width: 180px;">
            <?php foreach ($services_categories as $service_category) { ?>
            <h3><?php $service_category->categoryName ?></h3>
            <?php } ?>
        </div>
        <div class="right clearfix" style="width: 800px;"></div>
    </div>
</div>
<!--#content-->