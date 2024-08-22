<div class="content-box left half" style="width: 42%">
    <div id="build-proposal" class="box-header centered" style="font-size: 15px; background: #BBB;">
        <?php if (help_box(25) && 0) { ?>
            <div class="help right tiptip" title="Help"><?php help_box(25, true) ?></div>
        <?php } ?>
        Add New Service To Proposal
    </div>
    <div class="box-content padded clearfix">
        <div class="clearfix">
            <div id="selectServiceCategory" class="selectOptions shadowed rounded">
                <?php
                foreach ($services as $service) {

                    if ((!$service->getParent()) && (!in_array($service->getServiceId(), $disabledServices))) {
                        ?>
                        <a href="#"
                           rel="<?php echo $service->getServiceId(); ?>"><?php echo $service->getServiceName(); ?></a>
                        <?php
                    }
                }
                ?>
            </div>
            <div id="selectService" class="selectOptions shadowed rounded">
                <a href="#" rel="0">Select a category</a>
            </div>
            <a class="btn update-button" href="#" id="addServiceToProposal" style="margin: 15px 0 0 70px;">
                 Next <i class="fa fa-fw fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<div class="content-box right half" style="width: 54%">
    <div class="box-header centered" style="font-size: 15px; background: #000; color: #fff;">
        <?php if (help_box(26)) { ?>
            <div class="help right tiptip" title="Help"><?php help_box(26, true) ?></div>
        <?php } ?>
        Your Proposal
    </div>
    <div class="box-content padded">
        <div id="proposal_services">
            <p id="noServices">No Services Added!</p>
        <?php
        $optionalServiceCount = false;
        $noPriceCount = false;
        $unapprovedCount = false;
        if (count($proposal_services)) {
            foreach ($proposal_services as $service) {
                if ($service->isOptional()) {
                    $optionalServiceCount = true;
                }
                if ($service->isNoPrice()) {
                    $noPriceCount = true;
                }
                if (!$service->isApproved()) {
                    $unapprovedCount = true;
                }
                $hide_class = ($service->getIsHideInProposal()) ? 'hide_in_proposal' : ''; 
                
                ?>
                <div class="service clearfix <?=$hide_class;?>" id="service_<?php echo $service->getServiceId() ?>">
                    <span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>
                    <span class="service
                                    <?php echo $service->isOptional() ? ' optional' : ''; ?>
                                    <?php echo $service->isNoPrice() ? 'noPrice' : ''; ?>
                                    <?php echo !$service->isApproved() ? 'unapproved' : ''; ?>
                    ">
                    <span class="noPriceTag"><strong>[NP] </strong></span>
                    <span class="optionalTag"><strong>[OS] </strong></span>
                    <span class="unapprovedTag"><strong>[A] </strong></span>
                    <span class="serviceName"><?php echo $service->getServiceName() ?></span></span>
                    
                    <span class="actions">

                        <?php
                        $hide_in_proposal = ($service->getIsHideInProposal()) ? ' ' : 'display:none';
                        ?>

                        <i class="fa fa-fw fa-eye-slash fa-sm tiptip hide_in_proposal" title="Hide In Proposal" style="color: #7b7a7a;<?=$hide_in_proposal;?>"></i>
                        <?php
                        $hide_map_area = ($service->getMapAreaData() != '') ? ' ' : 'display:none';
                        ?>
<a style="color: #7b7a7a;cursor:pointer;<?=$hide_map_area;?>" class="map_data_icon tiptip" title="<?=$service->getMapAreaData();?>" data-title="<?php echo $service->getMapAreaData() ?>"  data-id="<?php echo $service->getServiceId(); ?>"><i class="fa fa-fw fa-map-o fa-sm "  ></i></a>

                        <?php 
                         if($enableProposalImages){
                            $serviceImageCount = $service->getServicesImageCount();?>
                            <a href="#" style="color: #7b7a7a;" class="<?= $serviceImageCount ? 'serviceImagePreview' : ''; ?>"
                               data-service-id="<?php echo $service->getServiceId() ?>" >
                                <i class="fa fa-fw fa-image tiptip"
                                   title="<?= $serviceImageCount ? 'Click to See Images' : 'No Images'; ?>"></i>
                                <span class="serviceImageCount_<?php echo $service->getServiceId() ?>"
                                      style="color: <?=($serviceImageCount>0)?'':'red';?>"><?= $serviceImageCount;?>
                                </span>
                            </a>
                        <?php
                         }
                                    //calculators codes 27 for sealcoat
                        /*
                                    $sealcoat_calculators = array(27); //27
                                    if (in_array($service->getInitialService(), $sealcoat_calculators)) {
                                        ?>
                                        <a class="btn-calculator tiptip" title="Seal Coating Calculator"
                                           href="<?php echo site_url('account/calculators/sealcoating/' . $service->getServiceId()) ?>">
                                            &nbsp;</a>
                                        <?php
                                    }
                        */
                                    ?>

                        <?php if (in_array($service->getServiceId(), $estimatedProposalServices)) : ?>
                            <i class="fa fa-fw fa-check-circle-o fa-lg tiptip" title="Estimate Complete" style="color: #7b7a7a;"></i>
                        <?php elseif (in_array($service->getServiceId(), $estimatesInProgress)): ?>
                            <i class="fa fa-fw fa-calculator fa-lg tiptip" title="Estimate In Progress" style="color: #949393;"></i>
                        <?php else: ?>
                            <i class="fa fa-fw fa-lg"></i>
                        <?php endif;
                       ?>


                        
                        <a class="btn-edit tiptip" title="Edit Service"
                           rel="<?php echo $service->getServiceId() ?>" href="#"
                           data-id="<?php echo $service->getServiceId(); ?>">Edit</a>
                        <a class="btn-delete tiptip" title="Delete Service"
                           data-id="<?php echo $service->getServiceId(); ?>">Delete</a>
                                </span>
                </div>
                <?php
            }
        } ?>
        </div>
        <div style="min-height: 24px;">
            <?php if ($account->hasEstimatingPermission()) : ?>
                    <a class="btn right tiptip update-button estimate_btn" style="margin-top:2px;margin-bottom:2px;margin-right: -2px;" href="<?php echo site_url('proposals/estimate/' . $proposal->getProposalId()); ?>" title="Estimator" >
                        <i class="fa fa-fw fa-calculator"></i> Estimate
                    </a>
            <?php endif; ?>
            <p style="margin-top: 10px;" id="noPriceLegend"><strong>[NP]</strong> - No Price</p>
            <p style="margin-top: 10px;" id="optionalLegend"><strong>[OS]</strong> - Optional Service</p>
            <p style="margin-top: 10px;" id="approvalLegend"><strong>[A]</strong> - Requires Approval</p>
           
        </div>
    </div>
</div>