
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
    </style>
    <script type="text/javascript">
        var numMappedProposals;
    </script>
    <input type="hidden" id="delayUI" value="1">
    <div id="content" class="clearfix">
    <input type="hidden" id="campaignEmailFilter" value="<?php echo $campaignEmailFilter; ?>"/>
        <input type="hidden" id="campaignEmailContent" value="<?php echo htmlentities($resend->getEmailContent()); ?>"/>
        <div class="materialize expanded" id="campaignProposalsContainer">
            <div class="row">
                <div class="col s12">
                    <p class="campaignProposalsHeading">
                    
                        <a href="#" class="toggleProposalCampaignDetails"></a>
                        <span class="campaignProposalsCreated"><strong>Sent:</strong> <?php echo $resend->getCreated()->format('m/d/y g:ia') ?></span>
                        <a href="javascript:void(0);"  style="float:right;margin-right:10px;" class="blue-button reload_table tiptip btn" title="Reload Stats"><i class="fa fa-refresh" style="font-size:14px;"></i></a>
                        <?php if($resendStats['failed_count']>0){?>
                            <span class="failed_top_icon tiptipleft right" style="display: none;cursor:pointer;border-bottom: none;" title="<?=$resendStats['failed_count'];?> Client email failed to send. Click to view"><img style="margin-top: 3px;margin-right: 8px;"  src="/3rdparty/icons/warning-sign.png"></span>
                        <?php } ?>
                        <i class="fa fa-fw fa-envelope"></i> Client Campaign:<span style="color: #a09b9b;"> <?php echo $resend->getResendName(); ?></span>
                        
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
                        <option value="<?=$resend->getId();?>"><?=$resend->getResendName();?></option>
                    <?php 
                        foreach($child_resends as $child_resend){
                            echo '<option value="'.$child_resend->id.'">'.$child_resend->resend_name.'</option>';
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
                                <a href="<?php echo site_url('clients/resend/' . $resend->getId()) ?>" data-filter="">View All</a>
                            </div>
                        </div>
                    </div>

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'delivered') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope-square"></i> Delivered: </strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('clients/resend/' . $resend->getId() . '/delivered') ?>" data-filter="delivered">
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
                                <a href="<?php echo site_url('clients/resend/' . $resend->getId() . '/opened') ?>" data-filter="opened">
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
                                <a href="<?php echo site_url('clients/resend/' . $resend->getId() . '/clicked') ?>" data-filter="clicked">
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
                                <a href="<?php echo site_url('clients/resend/' . $resend->getId() . '/unopened') ?>" data-filter="unopened">
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
                                <a href="<?php echo site_url('clients/resend/' . $resend->getId() . '/bounced') ?>" data-filter="bounced">
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
                    <p class="adminInfoMessageWarning check_failed_count_msg" ><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Clients email failed to send in this campaign. <a href="/clients/resend/<?=$resend->getId();?>/failed">View Clients</a><span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
                <?php }?>    
        <?php }else{?> 
            <p class="adminInfoMessageWarning  failed_count_msg" style="display: none;"><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Clients failed to send in this campaign. <a href="#" class="reload_failed" data-filter="failed">View Clients</a> <span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
            <p class="adminInfoMessageWarning view_Clients_msg "  ><i class="fa fa-fw fa-info-circle"></i> You are viewing the Clients that failed to send in the campaign. Click the buttons above to see the sent clients.</p>
            <?php }?>  
        <div class="clearfix"></div>
        <div class="widthfix">

            <?php $this->load->view('clients/filters'); ?>

            <div class="content-box">
                <input type="hidden" id="group" value=""/>
                <input type="hidden" id="search" value="<?php echo $search; ?>"/>

                <?php if ($search) { ?>
                    <p style="padding: 20px">Showing search results for <strong>'<?php echo $search ?>'</strong>. &nbsp;<a href="<?php echo site_url('contacts'); ?>">View all contacts</a></p>
                <?php } ?>

                <div class="box-header">
                    <span style="float: left; color: #fff; margin-right: 10px;">Contacts</span>
                    <?php if (help_box(22)) { ?>
                        <div class="help right tiptip" title="Help"><?php help_box(22, true) ?></div>
                    <?php } ?>

                    <div id="clientsTableLoader" style="width: 150px; display: none; position: absolute; left: 421px; top: 8px;">
                        <img src="/static/loading-bars.svg">
                    </div>

                    <div class="clearfix"></div>
                </div>
            <div class="box-content" style="overflow-y: scroll; overflow-y: hidden;">
                <div id="proposalsTableContainer">
                    <?php $this->load->view('templates/clients/table/table'); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="emailContentDialog" title="Preview Email" style="display:none;">
        <div id="email-preview" style="padding:10px">
            <?php echo $resend->getEmailContent(); ?>
        </div>
    </div>
    <script type="text/javascript">
            $(document).ready(function() {
                var resend_id = '<?=$resend->getId();?>';
                var failed_info = localStorage.getItem("failed_client_info_batch_hide_"+resend_id);
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


                // Toggle the card links when clink
                $(".statCard").click(function() {
                    // Handle highlighting
                    if(!$('.failed_top_icon').is(":visible")){
                        $('.failed_count_msg').show();
                    }
                    
                    $('.view_Clients_msg ').hide();
                    $(".card").removeClass('highlightedCard');
                    $(this).addClass('highlightedCard');
                    // Set the filter value
                    $("#campaignEmailFilter").val($(this).find('.card-action a').data('filter'));
                    $("#campaignEmailsFilterCount").text($(this).find('.card-action a').data('filter') ? $(this).find('.card-action a').data('filter') : 'All');
                    // Reload the table
                    oTable.ajax.reload();

                    return false;
                });

                $(".reload_failed").click(function() {
                    // Handle highlighting
                    $('.failed_count_msg').hide();
                    $('.view_Clients_msg').show();
                    $(".card").removeClass('highlightedCard');
                    
                    // Set the filter value
                    $("#campaignEmailFilter").val('failed');
                    
                    // Reload the table
                    oTable.ajax.reload();

                    return false;
                });
                $(".close_failed_info_batch").click(function() {
                    if(hasLocalStorage){
                        localStorage.setItem("failed_client_info_batch_hide_"+resend_id, 1);
                    }
                    $('.check_failed_count_msg').hide();
                    $('.failed_count_msg').hide();
                    $('.failed_top_icon').show();
                });

                $(".failed_top_icon").click(function() {
                    if(hasLocalStorage){
                        localStorage.setItem("failed_client_info_batch_hide_"+resend_id,'');
                    }
                    if($("#campaignEmailFilter").val()=='failed'){
                        $('.check_failed_count_msg').hide();
                        $('.failed_count_msg').hide();
                        $('.view_Clients_msg').show();
                    }else{
                        $('.check_failed_count_msg').show();
                        $('.failed_count_msg').show();
                        $('.view_Clients_msg').hide();
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
                        var client_filters = JSON.parse('<?=$resend->getFilters()?>');
                    }else{
                        var client_filters = false;
                    }
                    
                    var custom_sender_details = "Client Owner";
                    if(custom_sender=='1'){
                        var custom_sender_details = "<?=$resend->getCustomSenderName().'| '.$resend->getCustomSenderEmail();?>";
                    }

                    
                    var filter_text = "";
                    var filter_count =0;
                    if(client_filters){

                        if(client_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+client_filters.pResendType+"</p><br/>";
                        }
                        
                        if(client_filters.cFilterUser){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<client_filters.cFilterUser.length;$i++){
                                temp_text +=client_filters.cFilterUser[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        
                        
                        
                        if(client_filters.cFilterClientAccount){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<client_filters.cFilterClientAccount.length;$i++){
                                temp_text +=client_filters.cFilterClientAccount[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Accounts:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        if(client_filters.cFilterBusinessType){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<client_filters.cFilterBusinessType.length;$i++){
                                temp_text +=client_filters.cFilterBusinessType[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Business:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        if(client_filters.cResendExclude){
                            filter_count++;
                            var temp_text ='';
                            if(client_filters.cResendExclude == 0){
                                temp_text += "Email On";
                            } else {
                                temp_text += "Email Off";
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>campaign:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        
                    }

                    if(filter_count==0){
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">No Filter Applied</p>';
                    }else{
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">'+ filter_count+' Filters Applied <a class="tiptipleft filter_info_icon" style="cursor:pointer;" title="'+filter_text+'"><i class="fa fa-question-circle"></i></a></p>'
                    }

                swal({
                title: "Campaign Summary",
                html: '<table class="boxed-table pl-striped" style="font-size: 16px;" width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Subject:</label><p style="padding:7px;text-align:left">'+subject+'</p></td><td style="width:30%"><label  style="width: 65px;text-align: left;">Sent:</label><p style="margin-top:7px;text-align:right">'+sent_time+'</p></td></tr>'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Sender:</label><p style="padding:7px;text-align:left">'+custom_sender_details+'</p></td><td style="text-align: left;width:30%"><label  style="width: 65px;text-align: left;">Filters:</label>'+filter_text_details+'</td></tr>'+
                        
                            '<tr><td colspan="2"><textarea  rows="15" class="email_content" name="email_content">'+email_content+'</textarea></td>'+
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
                            tinymce.init({selector: ".email_content",elementpath: false, relative_urls : false,remove_script_host : false,convert_urls : true,menubar: false,statusbar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true});
                            $('.swal2-modal').attr('id','summary_popup')  
                        }
                }).then(function (result) {
                //$('#add_job_cost_item_form').submit();
                }).catch(swal.noop)


                return false;
                });



            });
            
            $(".reload_table").click(function () {
                $("#child_resend").trigger('change');
                $( this ).find('i').addClass( 'fa-spin' );
                var $el = $(this);
                setTimeout(function() { $el.find('i').removeClass( 'fa-spin' ); }, 1000);
            });        

            $("#child_resend").change(function () {
                $.ajax({
                    url: '/ajax/change_client_child_resend',
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
                            $('#email-preview').html(data.email_content);
                           
                            var total_delivered_percent =  data.resendStats.delivered ? Math.round((data.resendStats.delivered / data.resendStats.sent) * 100) : '0'; 
                            var total_unopened_percent =  data.resendStats.unopened ? Math.round((data.resendStats.unopened / data.resendStats.sent) * 100) : '0';
                            var total_bounced_percent =  data.resendStats.bounced ? Math.round((data.resendStats.bounced / data.resendStats.sent) * 100) : '0'; 
                            var total_opened_percent =  data.resendStats.opened ? Math.round((data.resendStats.opened / data.resendStats.sent) * 100) : '0'; 
                            console.log(total_unopened_percent);
                            $('.total_delivered_percent').text(total_delivered_percent+'%');
                            $('.total_bounced_percent').text(total_bounced_percent+'%');
                            $('.total_opened_percent').text(total_opened_percent+'%');
                            $('.total_unopened_percent').text(total_unopened_percent+'%');
                            
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



         // Proposal Resend options



        </script>

    <!--#content-->
<?php 
$this->load->view('templates/clients/table/group-js');

$this->load->view('global/footer'); ?>