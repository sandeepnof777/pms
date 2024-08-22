<?php $this->load->view('global/header'); ?>
    <style>
        #uniform-templateSelect {
            width: 225px!important;
        }
        #uniform-templateSelect span {
            width: 200px!important;
        }
        .reload_table span{
            padding: 4px!important;
            line-height: 12px!important;
        }
        .materialize .row .col{
            padding: 0 .25rem!important;
        }
        #summary_popup #cke_email_content .cke_bottom{
            display:none
        }
        #summary_popup .swal2-confirm {
            float: right;
        }
        #summary_popup h2 {
            font-size: 24px!important;
        }
        #cke_email_content .cke_reset_all{
            display:none
        }
        .filter_info_icon:hover{color: #25AAE1!important;}
        .s2custom{
            width: 14.28%;
            margin-left: auto;
            left: auto;
            right: auto;
        }
        .mail_count_tab{
            float: left;
            font-size: 14px;
            color: #444444;
            font-weight: bold;
        }
        #campaignProposalsContainer .card.highlightedCard .mail_count_tab {
            color: #fff !important;
        }
        #campaignProposalsContainer .card-content strong i {
            width: 18px;
        }
        #campaignProposalsContainer .card-action {
            padding: 0 5px 3px 27px;
            
        }
        #showEmailContent{margin-right: 0px;}
        /* Style the close button (span) */

    
    input.error {
    border-color: #e47074 !important;
    background: #ffedad !important;
    box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
}
</style>
    <script type="text/javascript">
        var numMappedProposals;
    </script>

    <div id="content" class="clearfix">
        
       
        <div class="materialize expanded" id="campaignProposalsContainer">
            <div class="row">
                <div class="col s12">
                    <p class="campaignProposalsHeading">
                    
                        <a href="#" class="toggleProposalCampaignDetails"></a>
                        <span class="campaignProposalsCreated"><strong>Sent:</strong> <?php echo $resend->getCreated()->format('m/d/y g:ia') ?></span>
                        <a href="javascript:void(0);"  style="float:right;margin-right:10px;" class="blue-button reload_table tiptip btn" title="Reload Stats"><i class="fa fa-refresh" style="font-size:14px;"></i></a>
                        <?php if($resendStats['failed_count']>0){?>
                        <span class="failed_top_icon tiptipleft right" style="display: none;cursor:pointer;border-bottom: none;" title="<?=$resendStats['failed_count'];?> proposals failed to send. Click to view"><img style="margin-top: 3px;margin-right: 8px;"  src="/3rdparty/icons/warning-sign.png"></span>
                        <?php } ?>
                        <i class="fa fa-fw fa-envelope"></i> Proposal Campaign: <span style="color: #a09b9b;"><?php echo $resend->getResendName(); ?> </span>
                        
                        
                    </p>
                    
                </div>
            </div>
            <hr/>
            <div class="row" id="resend_reload_btn" style="margin-bottom: 5px;margin-top: 8px;">
                <div class="col s12">
                   
                    <?php if(count($child_resends)>0){ 
                                 $resend_show = 'display:block!important;';
                            }else{
                                $resend_show = 'display:none!important;';
                            }

                    ?>



                    <span style="float:right" >
                        <select id="child_resend" style = "<?php echo $resend_show;?> padding: 2px;border: 1px solid;border-radius: 3px;height:auto;font: caption;" class="dont-uniform" >
                        <option value="<?=$resend->getId();?>" <?php if($this->uri->segment(3)==$resend->getId()){ echo 'selected="selected"'; }?> ><?=$resend->getResendName();?></option>
                    <?php 
                        foreach($child_resends as $child_resend){
                            if($this->uri->segment(3)==$child_resend->id){ $selected = 'selected="selected"'; }else{ $selected = '';}
                            echo '<option'.$selected.'  value="'.$child_resend->id.'">'.$child_resend->resend_name.'</option>';
                        }
                     ?>
                    </select></span>
                </div>
            </div>
            <div id="campaignProposalsContent">
                <div class="row">

                    <div class="col s2custom">
                        <div class="card statCard<?php if (!$campaignEmailFilter) { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope"></i> Sent: </strong><span class="total_sent"> <?php echo $resendStats['sent'] ?></span>
                            </div>
                            <div class="card-action" style="padding: 0 5px 3px 28px;">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId()) ?>" data-filter="" style="margin-right: 0px;">View All</a>
                            </div>
                        </div>
                    </div>

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'delivered') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope-square"></i> Delivered: </strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/delivered') ?>" data-filter="delivered">
                                    <span class="total_delivered mail_count_tab"> <?php echo $resendStats['delivered'] ?></span>
                                    <span class="total_delivered_percent" style="float:right"><?php echo $resendStats['delivered'] ? round(($resendStats['delivered'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                    
                                </a>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'opened') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope-open"></i> Opened:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/opened') ?>" data-filter="opened">
                                    <span class="total_opened mail_count_tab"> <?php echo $resendStats['opened'] ?></span>
                                    <span class="total_opened_percent" style="float:right"><?php echo $resendStats['opened'] ? round(($resendStats['opened'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'clicked') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope"></i> Clicked:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/clicked') ?>" data-filter="clicked">
                                <span class="total_clicked mail_count_tab" ><?php echo $resendStats['clicked'] ?></span>
                                <span class="total_clicked_percent" style="float:right"><?php echo $resendStats['clicked'] ? round(($resendStats['clicked'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                   
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'unopened') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope"></i> Unopened:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/unopened') ?>" data-filter="unopened">
                                    <span class="total_unopened mail_count_tab" ><?php echo $resendStats['unopened'] ?></span>
                                    <span class="total_unopened_percent" style="float:right"><?php echo $resendStats['unopened'] ? round(($resendStats['unopened'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'bounced') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-exclamation-triangle"></i> Bounced:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/bounced') ?>" data-filter="bounced">
                                    <span class="total_bounced mail_count_tab"> <?php echo $resendStats['bounced'] ?></span>
                                    <span class="total_bounced_percent" style="float:right"><?php echo $resendStats['bounced'] ? round(($resendStats['bounced'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col s2custom">
                        <div class="card">
                            <div class="card-content showEmailContent">
                                <a href="#" class="showEmailContent" id="viewEmailIcon">
                                    <strong><i class="fa fa-fw fa-pencil-square-o""></i> Summary</strong>
                                </a>
                            </div>
                            <div class="card-action">
                                <a href="#" class="showEmailContent" id="showEmailContent">View Email</a>
                            </div>
                        </div>
                    </div>

                </div>
            
                
            </div>

        </div>
        <?php if($this->uri->segment(4)!='failed'){ ?>
            <?php if($resendStats['failed_count']>0){?>
                    <p class="adminInfoMessageWarning check_failed_count_msg" ><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Proposals failed to send in this campaign. <a href="/proposals/resend/<?=$resend->getId();?>/failed">View Proposals</a><span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
                <?php }?>    
        <?php }else{?> 
            <p class="adminInfoMessageWarning  failed_count_msg" style="display: none;"><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Proposals failed to send in this campaign. <a href="#" class="reload_failed" data-filter="failed">View Proposals</a> <span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
            <p class="adminInfoMessageWarning view_proposals_msg "  ><i class="fa fa-fw fa-info-circle"></i> You are viewing the proposals that failed to send in the campaign. Click the buttons above to see the sent proposals.</p>
            <?php }?>    
        <div id="newFilter">
            <div class="clearfix">
            <?php $this->load->view('templates/proposals/filters/new-proposal-resend-filters');?>
            </div>
            <input type="hidden" id="pageAction" value="<?php echo $action; ?>"/>
            <input type="hidden" id="group" value="<?php echo $group; ?>"/>
            <input type="hidden" id="search" value="<?php echo $search; ?>"/>
            <input type="hidden" id="campaignEmailFilter" value="<?php echo $campaignEmailFilter; ?>"/>
            <input type="hidden" id="campaignEmailContent" value="<?php echo htmlentities($resend->getEmailContent()); ?>"/>
            <div class="filterOverlay"></div>
        </div>
        <div class="clearfix"></div>
        <div class="content-box">
            <div class="box-header">
            <div id="proposalsTableLoader" style="width: 150px; float: left; display: none; margin-left: 413px;">
                    <img src="/static/loading-bars.svg" />
                </div>
                <?php if (help_box(4)) { ?>
                    <div class="help right tiptip" title="Help"><?php help_box(4, true) ?></div>
                    <?php
                } ?>
                <!--            <a class="box-action tiptip blue" title="View Proposals in Queue" href="#">Proposal Queue</a>-->

                <!-- <a class="box-action tiptip" href="<?php echo site_url('clients') ?>" title="Add New Proposal"
                   id="addProposalLink">
                    <i class="fa fa-fw fa-plus"></i> Add Proposal
                </a> -->

                <!-- <a class="box-action tiptip" href="#" id="exportFilteredProposals" title="Export These proposals">
                    <i class="fa fa-fw fa-cloud-download"></i>
                </a> -->

                <!-- <a class="box-action tiptip" href="#" title="Map" id="proposalMapLink">
                    <i class="fa fa-fw fa-map"></i> Map
                </a> -->

                <a class="box-action tiptip" href="#" title="Proposals Table" id="proposalTableLink">
                    <i class="fa fa-fw fa-list"></i> Proposals
                </a>

                <a class="box-action tiptip mapControl" style="display: none;" href="#" title="Show All" id="mapAll">
                    <i class="fa fa-fw fa-map-marker"></i> Show All
                </a>

                <a class="box-action tiptip mapControl" style="display: none;" href="#" title="Go To My Position" id="mapPosition">
                    <i class="fa fa-fw fa-location-arrow"></i> Current Location
                </a>

                <a class="box-action tiptip mapControl" style="display: none;" href="#" title="Back" id="mapBack">
                    <i class="fa fa-fw fa-arrow-left"></i> Back
                </a>

                <div style="float:left; margin-right:10px" class="mapControl">
                    <input type="search" placeholder="Enter Zip Code" onkeypress="searchPostcode(event)" id="postcode_search" style="display: none; width: 125px">
                    <a class="box-action mapControl" id="mapTools">Tools</a>
                    <a class="box-action mapControl" id="zipSearchButton" title="Show markers in Zip Code"><i class="fa fa-fw fa-search"></i></a>
                    <a class="box-action" id="zipCancel" title="Clear Zip Search"><i class="fa fa-fw fa-close"></i></a>

                    <div id="mapToolsDropdown">
                        <a href="#" id="closeDrawingTools"><i class="fa fa-fw fa-close"></i> </a>
                        <div class="clearfix"></div>
                        <table>
                            <tr>
                                <td>
                                    <div id="drawingManager" class="" style="float:left"></div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="drawingManagerRadiusCount" class="" style="float:left; font-weight: normal; font-style: normal;"></div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="drawingManagerPolygonRemove" class="" style="float:left;"></div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                        <div id="map-canvas"></div>
                    </div>

                </div>

                <div class="clearfix"></div>
            </div>
            <div class="box-content" style="overflow-y: scroll; overflow-y: hidden;">
                <div id="proposalsTableContainer">
                    <?php $this->load->view('templates/proposals/table/table'); ?>
                </div>
                <div id="proposalsMapContainer" style="display: none; position: relative;">
                    <?php $this->load->view('templates/proposals/map/info'); ?>
                    <?php $this->load->view('templates/proposals/map/map'); ?>
                </div>
            </div>

        </div>

<div id="bounced-resend-proposals" title="Bounced Email Resend" style="display:none;">

<input type="hidden" id="bounced_campaign_id">
<div style="background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;border-radius:4px;width: 91%;line-height: 20px;">
        <p><strong>Bounced Resend Details</strong></p>
        <p>Initial Campaign: <span id="bounced_totalNum"></span> Emails were sent</p>
        <p id="bounced_count_msg"></p>
        <p><strong>Sending <span id="bounced_resendNum"></span> emails</strong></p>
    </div>
</div>
        <?php $this->load->view('templates/proposals/table/table-js'); ?>

        <script type="text/javascript">
            $(document).ready(function() {


                function reverseDatePreset(startDate,endDate) {
            var preset ='custom';
            if(startDate == moment().subtract(1, 'days').format('MM/DD/YYYY') && endDate == moment().subtract(1, 'days').format('MM/DD/YYYY')){
                preset = 'Yesterday';
            }else if(startDate == moment().subtract(6, 'days').format('MM/DD/YYYY') && endDate == moment().format('MM/DD/YYYY')){
                preset = 'Last 7 Days';
            }else if(startDate == moment().startOf('month').format('MM/DD/YYYY') && endDate == moment().format('MM/DD/YYYY')){
                preset = 'Month To Date';
            }else if(startDate == moment().subtract(1, 'month').startOf('month').format('MM/DD/YYYY') && endDate == moment().subtract(1, 'month').endOf('month').format('MM/DD/YYYY')){
                preset = 'Previous Month';
            }else if(startDate == moment().startOf('year').format('MM/DD/YYYY') && endDate == moment().format('MM/DD/YYYY')){
                preset = 'Year To Date';
            }else if(startDate == moment().subtract(1, 'year').startOf('year').format('MM/DD/YYYY') && endDate == moment().subtract(1, 'year').endOf('year').format('MM/DD/YYYY')){
                preset = 'Previous Year';
            }

            return preset;

        }

        function readableValue(num, digits) {
            const lookup = [
                { value: 1, symbol: "" },
                { value: 1e3, symbol: "k" },
                { value: 1e6, symbol: "M" },
                { value: 1e9, symbol: "G" },
                { value: 1e12, symbol: "T" },
                { value: 1e15, symbol: "P" },
                { value: 1e18, symbol: "E" }
            ];
            const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
            var item = lookup.slice().reverse().find(function(item) {
                return num >= item.value;
            });
            return (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol;
        }
        
                var resend_id = '<?=$resend->getId();?>';
                var failed_info = localStorage.getItem("failed_info_batch_hide_"+resend_id);
                if(failed_info){
                    $('.check_failed_count_msg').hide();
                    $('.failed_top_icon').show();
                }else{
                    $('.failed_top_icon').hide();
                }
                // Toggle the dropdown
                $(".toggleProposalCampaignDetails").click(function() {
                    $("#campaignProposalsContainer").toggleClass('expanded');
                    return false;
                });
console.log($("#campaignEmailFilter").val());
                if($("#campaignEmailFilter").val() =='bounced'){
                    $('#bouncedGroupResend').show();
                }else{
                    $('#bouncedGroupResend').hide();
                }
                
                // Toggle the card links when clink
                $(".statCard").click(function() {
                    // Handle highlighting
                    if(!$('.failed_top_icon').is(":visible")){
                        $('.failed_count_msg').show();
                    }
                    


                    $('.view_proposals_msg').hide();
                    $(".card").removeClass('highlightedCard');
                    $(this).addClass('highlightedCard');
                    if($(this).find('.card-action a').data('filter') =='bounced'){
                        $('#bouncedGroupResend').show();
                    }else{
                        $('#bouncedGroupResend').hide();
                    }
                    // Set the filter value
                    $("#campaignEmailFilter").val($(this).find('.card-action a').data('filter'));
                    //$("#campaignEmailsFilterCount").text($(this).find('.card-action a').data('filter') ? $(this).find('.card-action a').data('filter') : 'All');
                    // Reload the table
                    oTable.ajax.reload();

                    return false;
                });

                $(".reload_failed").click(function() {
                    // Handle highlighting
                    $('.failed_count_msg').hide();
                    $('.view_proposals_msg').show();
                    $(".card").removeClass('highlightedCard');
                    
                    // Set the filter value
                    $("#campaignEmailFilter").val('failed');
                    
                    // Reload the table
                    oTable.ajax.reload();

                    return false;
                });
                $(".close_failed_info_batch").click(function() {
                    if(hasLocalStorage){
                        localStorage.setItem("failed_info_batch_hide_"+resend_id, 1);
                    }
                    $('.check_failed_count_msg').hide();
                    $('.failed_count_msg').hide();
                    $('.failed_top_icon').show();
                });

                $(".failed_top_icon").click(function() {
                    if(hasLocalStorage){
                        localStorage.setItem("failed_info_batch_hide_"+resend_id,'');
                    }
                    if($("#campaignEmailFilter").val()=='failed'){
                        $('.check_failed_count_msg').hide();
                        $('.failed_count_msg').hide();
                        $('.view_proposals_msg').show();
                    }else{
                        $('.check_failed_count_msg').show();
                        $('.failed_count_msg').show();
                        $('.view_proposals_msg').hide();
                    }
                   
                    $('.failed_top_icon').hide();
                });
                

                // Dialog for email content
                $("#emailContentDialog").dialog({
                    modal: true,
                    autoOpen: false,
                    width: 900
                });

                $(".showEmailContent").click(function() {

                   // var email_content = "";
                    var email_content = $('#email-preview').html();
                    var subject = "<?=$resend->getSubject();?>";
                    var sent_time = "<?=$resend->getCreated()->format('m/d/y g:ia');?>";
                    var custom_sender = "<?=$resend->getCustomSender()?>";
                    var filters = '<?=$resend->getFilters()?>';
                    if(filters){
                        var proposal_filters = JSON.parse('<?=$resend->getFilters()?>');
                    }else{
                        var proposal_filters = false;
                    }
                    
                    var custom_sender_details = "Proposal Owner";
                    if(custom_sender=='1'){
                        var custom_sender_details = "<?=$resend->getCustomSenderName().' | '.$resend->getCustomSenderEmail();?>";
                    }

                    var filter_text = "";
                    var filter_count =0;



                    if(proposal_filters){

                        if(proposal_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+proposal_filters.pResendType+"</p><br/>";
                        }
                        
                        if(proposal_filters.pFilterStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";

                        }
                        if(proposal_filters.pFilterJobCostStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterJobCostStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterJobCostStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>JobCost Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        if(proposal_filters.pFilterEstimateStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterEstimateStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterEstimateStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Estimate Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";

                        }
                        if(proposal_filters.pFilterUser){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterUser.length;$i++){
                                temp_text +=proposal_filters.pFilterUser[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        
                        if(proposal_filters.pFilterEmailStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterEmailStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterEmailStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Email Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        if(proposal_filters.pFilterQueue){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterQueue.length;$i++){
                                temp_text +=proposal_filters.pFilterQueue[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Queue Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        if(proposal_filters.pFilterClientAccount){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterClientAccount.length;$i++){
                                temp_text +=proposal_filters.pFilterClientAccount[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Accounts:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        if(proposal_filters.pFilterBusinessType){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterBusinessType.length;$i++){
                                temp_text +=proposal_filters.pFilterBusinessType[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Business:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        var bidText='';
                        if(proposal_filters.pFilterMinBid!='' && proposal_filters.pFilterMinBid>0){
                            bidText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Bid:</strong>From $"+readableValue(proposal_filters.pFilterMinBid);
                        }
                        if(proposal_filters.pFilterMaxBid !='' && proposal_filters.pFilterMaxBid>0){
                            if(bidText !=''){
                                bidText +=' To $'+readableValue(proposal_filters.pFilterMaxBid)+'</p><br/>';
                            }else{
                                bidText +="<p style='padding-left:3px;'><strong style='text-align:left;'>Bid:</strong>Up To $"+readableValue(proposal_filters.pFilterMaxBid)+"</p><br/>";
                            }
                            
                        }else{
                            if(bidText !=''){
                                bidText +='</p><br/>';
                            }
                        }
                        filter_text +=bidText;

                        if(bidText !=''){
                                filter_count++;
                        }
                        
                    var createdText='';

                    if (proposal_filters.pCreatedFrom || proposal_filters.pCreatedTo) {
                        
                        var fromDateString;
                        var toDateString;
                        var createdRangeString;

                        if (proposal_filters.pCreatedFrom !='' && proposal_filters.pCreatedTo !='') {

                            fromDateString = proposal_filters.pCreatedFrom;
                            toDateString = proposal_filters.pCreatedTo;
                            console.log(fromDateString);
                            console.log(toDateString);
                            
                            createdRangeString = fromDateString + ' - ' + toDateString;
                            var presetString = reverseDatePreset(fromDateString,toDateString);
                            if(presetString !='custom'){
                                createdRangeString = presetString;
                            }

                        }
                        else if (proposal_filters.pCreatedFrom !='') {
                            fromDateString = proposal_filters.pCreatedFrom;
                            createdRangeString = 'After ' + fromDateString;
                        }
                        else {
                            toDateString = proposal_filters.pCreatedTo;
                            createdRangeString = 'Before ' + toDateString;
                        }

                        createdText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Created:</strong>" +createdRangeString +"</p><br/>";


                    }


                        filter_text +=createdText;
                        if(createdText !=''){
                                filter_count++;
                        }

                        var activityText ='';

                        if (proposal_filters.pActivityFrom || proposal_filters.pActivityTo) {
                        
                        var fromDateString;
                        var toDateString;
                        var activityRangeString;

                        if (proposal_filters.pActivityFrom !='' && proposal_filters.pActivityTo !='') {

                            fromDateString = proposal_filters.pActivityFrom;
                            toDateString = proposal_filters.pActivityTo;
                            activityRangeString = fromDateString + ' - ' + toDateString;
                            var presetString = reverseDatePreset(fromDateString,toDateString);
                            if(presetString !='custom'){
                                activityRangeString = presetString;
                            }

                        }
                        else if (proposal_filters.pActivityFrom !='') {
                            fromDateString = proposal_filters.pActivityFrom;
                            activityRangeString = 'After ' + fromDateString;
                        }
                        else {
                            toDateString = proposal_filters.pActivityTo;
                            activityRangeString = 'Before ' + toDateString;
                        }

                        activityText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Activity:</strong>" +activityRangeString +"</p><br/>";


                    }

                        filter_text +=activityText;
                        if(activityText !=''){
                                filter_count++;
                        }


                        var wonDateText ='';

                        if (proposal_filters.pWonFrom || proposal_filters.pWonTo) {
                        
                        var fromDateString;
                        var toDateString;
                        var activityRangeString;

                        if (proposal_filters.pWonFrom !='' && proposal_filters.pWonTo !='') {

                            fromDateString = proposal_filters.pWonFrom;
                            toDateString = proposal_filters.pWonTo;
                            activityRangeString = fromDateString + ' - ' + toDateString;
                            var presetString = reverseDatePreset(fromDateString,toDateString);
                            if(presetString !='custom'){
                                activityRangeString = presetString;
                            }

                        }
                        else if (proposal_filters.pWonFrom !='') {
                            fromDateString = proposal_filters.pWonFrom;
                            activityRangeString = 'After ' + fromDateString;
                        }
                        else {
                            toDateString = proposal_filters.pWonTo;
                            activityRangeString = 'Before ' + toDateString;
                        }

                        wonDateText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Won Date:</strong>" +activityRangeString +"</p><br/>";


                    }

                        filter_text +=wonDateText;
                        if(wonDateText !=''){
                                filter_count++;
                        }

                        if(proposal_filters.pResendInclude != proposal_filters.pResendExclude){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Email :</strong>";
                            if(proposal_filters.pResendInclude ==1){
                                filter_text += 'Email On';
                            }else{
                                filter_text += 'Email Off';
                            }
                            filter_text += "</p><br/>"
                        }

                        if(proposal_filters.pSigned != proposal_filters.pUnsigned){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Signature :</strong>";
                            if(proposal_filters.pSigned ==1){
                                filter_text += 'Signed';
                            }else{
                                filter_text += 'Unsigned';
                            }
                            filter_text += "</p><br/>"
                        }



                    }

                    if(filter_count==0){
                        var filter_text_details ='<p style="padding:7px;padding-top:6px;text-align:right">No Filter Applied</p>';
                    }else{
                        var filter_text_details ='<p style="padding:7px;padding-top:6px;text-align:right">'+ filter_count+' Filters Applied <a class="tiptipleft filter_info_icon" style="cursor:pointer;padding-left: 2px;margin-top: -1px;float: right;" title="'+filter_text+'"><i class="fa fa-question-circle"></i></a></p>'
                    }

                    swal({
                    title: "Campaign Summary",
                    html: '<table class="boxed-table pl-striped" style="font-size: 16px;" width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Subject:</label><p style="padding:7px;padding-top:6px;text-align:left">'+subject+'</p></td><td style="width:30%"><label  style="width: 65px;text-align: left;"> Sent:</label><p style="padding:7px;padding-top:6px;text-align:right">'+sent_time+'</p></td></tr>'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Sender:</label><p style="padding:7px;padding-top:6px;text-align:left">'+custom_sender_details+'</p></td><td style="text-align: left;width:30%"><label  style="width: 65px;text-align: left;"> Filters:</label>'+filter_text_details+'</td></tr>'+
                        
                            '<tr><td colspan="2"><textarea  rows="55" class="email_content" name="email_content">'+email_content+'</textarea></td>'+
                            '</tr></table></form>',
                   
                    showCancelButton: false,
                    confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                    width:800,
                    showCloseButton: true,
                    onOpen:  function() {
                            initTiptip(); 
                            //CKEDITOR.replace( 'email_content',{removePlugins: 'elementspath',readOnly:true,height:300} ); 
                            tinymce.init({selector: ".email_content",elementpath: false,menubar: false,relative_urls : false,remove_script_host : false,convert_urls : true,statusbar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true});
                            
                            $('.swal2-modal').attr('id','summary_popup')  
                        }
                }).then(function (result) {
                //$('#add_job_cost_item_form').submit();
                }).catch(swal.noop)

                   // $("#emailContentDialog").dialog('open');
                    return false;
                });
                initTiptip();
            });
            
            $(".reload_table").click(function () {
                $("#child_resend").trigger('change');
                $( this ).find('i').addClass( 'fa-spin' );

                var $el = $(this);
                setTimeout(function() { $el.find('i').removeClass( 'fa-spin' ); }, 1000);
            });        

            $("#child_resend").change(function () {
                $.ajax({
                    url: '/ajax/change_child_resend',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "child_resend_id": $(this).val(),
                    },

                    success: function (data) {
                        if (!data.error) {
                            oTable.ajax.reload(null, false);
                            $('.total_sent').text(' '+data.resendStats.sent);
                            $('.total_delivered').text(' '+data.resendStats.delivered);
                            $('.total_bounced').text(' '+data.resendStats.bounced);
                            $('.total_opened').text(' '+data.resendStats.opened);
                            $('.total_unopened').text(' '+data.resendStats.unopened);
                            $('.total_clicked').text(' '+data.resendStats.clicked);
                            $('#email-preview').html(data.email_content);
                           
                            var total_delivered_percent =  data.resendStats.delivered ? Math.round((data.resendStats.delivered / data.resendStats.sent) * 100) : '0'; 
                            var total_unopened_percent =  data.resendStats.unopened ? Math.round((data.resendStats.unopened / data.resendStats.sent) * 100) : '0';
                            var total_bounced_percent =  data.resendStats.bounced ? Math.round((data.resendStats.bounced / data.resendStats.sent) * 100) : '0'; 
                            var total_opened_percent =  data.resendStats.opened ? Math.round((data.resendStats.opened / data.resendStats.sent) * 100) : '0'; 
                            var total_clicked_percent =  data.resendStats.clicked ? Math.round((data.resendStats.clicked / data.resendStats.sent) * 100) : '0'; 
                            
                            $('.total_delivered_percent').text(total_delivered_percent+'%');
                            $('.total_bounced_percent').text(total_bounced_percent+'%');
                            $('.total_opened_percent').text(total_opened_percent+'%');
                            $('.total_unopened_percent').text(total_unopened_percent+'%');
                            $('.total_clicked_percent').text(total_clicked_percent+'%');
                            
                        } else {
                            swal("Error", "An error occurred Please try again");
                            return false;
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred Please try again");
                        console.log(errorThrown);
                    }
                })

            });


$(document).on('click', ".resend_upopened", function () {

        var resend_id = $(this).attr('data-val');
        $.ajax({
            url: '/ajax/get_resend_counts_details/',
            type: "POST",
            dataType: "json",
            data: {
                "resend_id": resend_id,
            },

            success: function (data) {
                if (data.success) {
                    if(data.total_resending>0){
                        $("#resend-proposals-new").dialog('open');
        
                    }else{
                        swal('','This Campaign has no Unopened Proposals!');
                        return false;
                    }
                   $('.new_resend_name').val(data.resend_name);
                   $('#messageSubject').val(data.subject);
                   $('#resendSelect').val(resend_id);
                   $('#totalNum').text(data.total_proposals);
                   $('#resendNum').text(data.total_resending);
                   if(data.total_not_sent>0){
                      $('.if_proposal_status_change').show();
                      $('#changeStatusNum').text(data.total_not_sent);
                   }else{
                    $('.if_proposal_status_change').hide();
                   }
                   
                    
      
      // $('.is_templateSelect_disable').css('display','block');
       if(data.email_cc==1){
            $( "#emailCC" ).prop( "checked", true );
            
            //$.uniform.update();
       }else{
            $( "#emailCC" ).prop( "checked", false );
           
            //$.uniform.update();
       }
       

       if(data.custom_sendor==1){
            $( "#emailCustom" ).prop( "checked", true );
            

            //$.uniform.update();
            
            $('#messageFromName').val(data.custom_sendor_name);
            $('#messageFromEmail').val(data.custom_sendor_email);
       }else{
            $( "#emailCustom" ).prop( "checked", false );
            
            //$.uniform.update();
            $('#messageFromName').val('');
            $('#messageFromEmail').val('');
       }
       $( "#emailCustom" ).trigger('change');
      
        
       $('#message').html(data.email_content);
       CKEDITOR.instances.message.setData(data.email_content);

                } else {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }


            },
            error: function (jqXhr, textStatus, errorThrown) {
                swal("Error", "An error occurred Please try again");
                console.log(errorThrown);
            }
        })


       

        return false;


});

        // Resend dialog
        $("#resend-proposals-new").dialog({
            width: 800,
            modal: true,
            open: function () {
                $("#emailCustom").attr('checked', false);
                $(".emailFromOption").hide();
                //$.uniform.update();
            },
            buttons: {
                "Resend": {
                    text: 'Send Email',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmResend',
                    click: function () {


                        if ($("#emailCustom").attr('checked')) {

                            if (!$("#messageFromName").val() || !$("#messageFromEmail").val()) {
                                alert('Please enter a from name and email address');
                                return false;
                            }
                        }

                        

                        // Make sure the undent is hidden
                        $("#unsentProposals").hide();
                        $("#unsentDetails").hide();
                        $("#alreadyProposals").hide();

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                
                                'emailCC': $("#emailCC").is(":checked"),
                                'subject': $("#messageSubject").val(),
                                'fromName': $("#messageFromName").val(),
                                'fromEmail': $("#messageFromEmail").val(),
                                'resendId': $("#resendSelect").val(),
                                'new_resend_name': $(".new_resend_name").val(),
                                'body': CKEDITOR.instances.message.getData()
                            },
                            url: "<?php echo site_url('ajax/groupResendUnopened2') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                var resendText = '';

                                if (data.success) {

                                    resendText = '<strong>' + data.count + '</strong> proposal emails were sent';
                                    $("#unsentProposals").hide();
                                    $("#unsentDetails").hide();
                                    $("#alreadyProposals").hide();

                                    if (data.unsent > 0) {
                                        var unsentText = data.unsent + ' proposal emails were not sent';
                                        $("#unsentProposals").text(unsentText).show();
                                        $("#unsentDetails").show()
                                    }
                                    if (data.already_sent > 0) {
                                        var already_sentText = '<strong>' + data.already_sent + '</strong> proposal emails were not sent as they have already been emailed in this campaign';
                                        $("#alreadyProposals").html(already_sentText).show();

                                    }
                                    if (data.bouncedUnsentCount > 0) {
                                        var bounced_sentText = '<strong>' + data.bouncedUnsentCount + '</strong> emails were not sent as they previously bounced and the contact email address has not changed';
                                        $("#bouncedProposals").html(bounced_sentText).show();

                                    }

                                }
                                else {
                                    resendText = 'An error occurred. Please try again';
                                }

                                $("#resendProposalsStatus").html(resendText);
                                $("#unsentProposals").html(unsentText);
                                $("#resend-proposals-status").dialog('open');
                                get_resend_lists();

                            });
                        $(this).dialog('close');
                        $("#resendProposalsStatus").html('Sending proposal mails...<img src="/static/loading.gif" />');
                        $("#resend-proposals-status").dialog('open');
                        //swal("Success", "Proposal Emails Resent");
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

         // Proposal Resend options
    
    $(document).on('change', "#emailCustom", function () {
        console.log($("#emailCustom").attr('checked'));
        if ($("#emailCustom").attr('checked')) {
            $(".emailFromOption").show();
        }
        else {
            $(".emailFromOption").hide();
            $(".emailFromOption input").val('');
        }
    });

function get_resend_lists(){

    $.ajax({
        url: '<?php echo site_url('ajax/get_child_resend_lists').'/'.$resend->getId() ?>',
        type: "GET",
        
        dataType: "json",
        success: function (data) {
            
            var html = '<option value="<?=$resend->getId();?>"><?=$resend->getResendName();?></option>';
            for($i=0;$i<data.length;$i++){
                html +='<option value="'+data[$i].id+'">'+data[$i].resend_name+'</option>'
            }
            console.log(html);
            $("#child_resend").html(html);
            $("#child_resend").show();
        }
    });

}


        
        
</script>

    </div>

    <div id="emailContentDialog" title="Preview Email" style="display:none;">
        <div id="email-preview" style="padding:10px">
            <?php echo $resend->getEmailContent(); ?>
        </div>
    </div>

<?php $this->load->view('templates/errors/datatables'); ?>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>