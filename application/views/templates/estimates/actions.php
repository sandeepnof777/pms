<div class="dropdownButton">
    <a class="dropdownToggle" href="#" style="font-weight: 700">GO</a>
    <div class="dropdownMenuContainer" style="width:260px;">
        <div class="closeDropdown">
            <a href="#" class="closeDropdownMenu">&times;</a>
        </div>
       
        <ul class="dropdownMenu">
            
            <li>
                <a href="<?php echo site_url('proposals/edit/' . $proposal->proposalId) ?>">
                    <img src="/3rdparty/icons/application_edit.png">Edit Proposal
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('proposals/edit/' . $proposal->proposalId . '/preview'); ?>">
                    <img src="/3rdparty/icons/application_go.png"> Preview Proposal
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('proposals/estimate/' . $proposal->proposalId); ?>">
                    <img src="/3rdparty/icons/calculator_edit.png"> Estimate Proposal
                </a>
            </li>
            <li>
                                <a href="JavaScript:void('0');" onclick="reset_estimation(<?=$proposal->proposalId;?>)" style="padding-left:10px;">
                                <i class="fa fa-fw fa-undo"></i> Reset Estimation
                                </a>
                            </li>
           
        </ul>
       
    </div>