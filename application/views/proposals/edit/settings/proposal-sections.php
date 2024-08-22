    <?php
        $info_visible = 'none';
        if($layoutOption =='gradient'){
            $section_layout_name = 'Custom';
        }else{
            $section_layout_name = $layoutOption;
            if($layoutOption =='standard'){
                $info_visible = 'block';
            }
        }
    ?>
    <p class="adminInfoMessage individual_proposal_section_message" style="display: <?=$info_visible;?>;"><i class="fa fa-fw fa-info-circle"></i>The following setting will not be applied for Standard Layout PDF/Print.</p>
    <table  class="boxed-table individual_proposal_section_table" width="100%"  cellspacing="0" >
            <thead>
            <tr>
                <th style="width: 80px;padding: 8px;">Order</th>
                <th><span class="section_layout_name" style="text-transform:capitalize;"><?=$section_layout_name;?> Layout</span> - Proposal Section</th>
                <th>Show</th>
            </tr>
            </thead>
            <tbody class="proposal-section-sortable">
            <?php
            foreach ($proposalCoolSections as $proposalCoolSection) {

                $hide_class = '';
                $unSortable = '';
                $disable = '';

                if($proposalCoolSection->section_code == 'audit-section' && !$account->getCompany()->hasPSA()){
                    continue;
                }


                $proposal_attachments = $this->em->createQuery('SELECT i FROM models\Proposal_attachments i  where i.proposalId=' . $proposal->getProposalId() . ' and i.proposal=1 order by i.ord')->getResult();
                $attachments = $proposal->getAttatchments();
                if ($proposalCoolSection->section_code == 'attachments'){
                    if (count($attachments) || count($proposal_attachments)) {
                        $hide_class = '';
                    }else{
                        $hide_class = 'display:none';
                    }
                }

                if ($proposalCoolSection->section_code == 'title-page'){
                    $unSortable = 'unsortable';
                    $disable = 'disabled';
                }
                if ($proposalCoolSection->section_code == 'service-provider' && $layoutOption =='standard') {
                    $hide_class = 'display:none';

                }
                
                
                if ($proposalCoolSection->section_code == 'images' && count($images)==0) {
                    $hide_class = 'display:none';

                }

                if ($proposalCoolSection->section_code == 'map_images' && count($mapImages)=='0') {
                    $hide_class = 'display:none';

                }
                if ($proposalCoolSection->section_code == 'video' && count($proposal_videos)==0) {
                    $hide_class = 'display:none';

                }
                ?>
                <tr class="even <?php if($proposalCoolSection->p_visible==0){ echo 'section_hidden ';}; ?> <?=  $unSortable;?> " data-section-code="<?=  $proposalCoolSection->section_code;?>" style="<?= $hide_class;?>" id="type_<?php echo $proposalCoolSection->individual_section_id; ?>">
                    <td style="text-align: center">
                        <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                            title="Drag to sort"></span>
                    </td>
                    <td > <i class="fa fa-fw <?php echo $proposalCoolSection->icon_code; ?>"></i> 
                        <?php echo $proposalCoolSection->section_name; ?> 
                    </td>
                    <td width="10" style="padding: 4px 20px;"><input style="margin: 0px auto;" <?=$disable;?> <?php if($proposalCoolSection->p_visible==1){ echo 'checked';}; ?> type="checkbox" class="section_check" data-parent-section-id="0" data-section-id="<?php if(isset($proposalCoolSection->individual_section_id)){ echo $proposalCoolSection->individual_section_id;}else{ echo 0;} ?>"></td>
                    
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>