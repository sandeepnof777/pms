</div>
<div id="footer" class="widthfix">
    <div class="widthfix clearfix" style="position:relative">
        <div id="footer-left" style="width: 25%;position: absolute;bottom: 0px;">Copyright &copy; 2012-<?php echo date('Y') ?> <?php echo SITE_NAME;?></div>
        <div id="footer-center" style="margin-left: 44%;"><a style="margin-top:0px" href="<?php echo base_url() ?>" id="logo"></a></div>
        <div id="footer-right" style="width: 25%;position: absolute;right:0px;bottom: 0px;"><a href="<?=base_url()?>home/terms_of_service">ToS</a> | <a href="<?=base_url()?>home/terms_of_use">Terms of Use</a> | <a href="<?=base_url()?>home/privacy_policy">Privacy Policy</a></div>
    </div>
</div>
<!--#footer-->
</div>
<div id="file_uploading" title="Please wait" style="display: none;">
    <p><img src="<?php echo site_url('static') ?>/loading_animation.gif" alt="Loading"></p>
    <p class="clearfix">Please wait while the file is uploading. When the upload is complete, you will be redirected to the next page.</p>
</div>
<!--#wrapper-->
<!--<div id="debug">
    Page loaded in <?php /*echo $this->benchmark->elapsed_time(); */?> seconds<br>
    Mem Usage: <?php /*echo $this->benchmark->memory_usage(); */?><br>
</div>-->
<?php
$this->load->view('global/footer-global');
?>
<div id="UniversalSearchDialog" title="Search " style="display: none;height:auto;min-height: 96px;padding-top:5px;">

        <p class="UniversalSearchClickLoader" style="width: 60%;"><img src="<?php echo site_url('/static/blue-loader.svg');?>" alt="Loading"></p>
        <p style="text-align: center;font-weight:bold;padding-bottom:5px;">Search on Company Name, Contact, Lead, Job Number & Project Name.</p>
        <p id="UniversalSearchBox">
          <select name="universalSearch" id="universalSearch" class="dont-uniform "  data-allow-clear="true" ><option></option></select>
          
        </p>
        
        <span class="UniversalSearchLoader " ></span>
        <a href="javascript:void(0)" class="show_hide_search_tips" style="float: left;width: 100%;margin-top: 17px;">Advanced Search Tips</a>
        <p class="UniversalSearchTips" style="float: left;width: 100%;margin-top: 10px;display:none">
            Search with <strong style="margin-left: 5px;">Proposal:</strong> to search only proposals<br/>
            Search with  <strong style="margin-left: 30px;">Lead:</strong> to search only leads<br/>
            Search with <strong style="margin-left: 11px;">Contact:</strong> to search only contacts<br/>
            Search with <strong style="margin-left: 4px;">Prospect:</strong> to search only Prospects<br/>
            Search with <strong style="margin-left: 8px;">Account:</strong> to search only Accounts<br/>
        </p>
</div>
<script>
  $("#UniversalSearchDialog").dialog({
          modal: true,
          autoOpen: false,
          width: 560,
          height:160,
          position: ['center',300] 
      });

        
$(document).on('click', ".UniversalSearchOpenBtn", function () {
    
    $("#UniversalSearchDialog").dialog('open');
    $("#universalSearch").select2('open');
   

    $('.UniversalSearchTips').hide();
    // setTimeout(function() {
    //             $('#universalSearch').select2('open');
                
    //         }, 400);
});

  $("#universalSearch").select2({
    ajax: {
    url: '<?php echo site_url('ajax/ajaxSelect2UniversalSearch') ?>',
    dataType: 'json',
    delay: 250,
    
    data: function (params) {
      return {
        startsWith: params.term, // search term
        
      };
    },
    processResults: function (data, params) {

      params.page = 1;
      
      //$('.UniversalSearchLoader').removeClass('ui-autocomplete-loading');
      $('.UniversalSearchClickLoader').css('visibility','hidden');
      
      return {
        results: data.items,
        
      };
      
    },
    error: function (jqXHR, status, error) {
        console.log(jqXHR);
        console.log(status);
        console.log(error);
        if(status !='abort'){
          if(jqXHR.status==500){
            $('.UniversalSearchClickLoader').css('visibility','hidden');
            swal('','You are Loged Out, Please Login Again!!')
          }else{
            $('.UniversalSearchClickLoader').css('visibility','hidden');
            swal('','Something went wrong, Please try again!!')
          }
          
        }
       
    },
    beforeSend:function(e){
      
      //$('.UniversalSearchLoader').addClass('ui-autocomplete-loading');
      $('.UniversalSearchClickLoader').css('visibility','visible');
    },
    cache: true
  },
  closeOnSelect: false,
  placeholder: 'Search for a repository',
  allowClear: true,
  dropdownCssClass: 'UniversalSearchBox',
  debug: true,
  minimumInputLength: 1,
  language: {
    inputTooShort: function () { return ''; },
    noResults: function(){
           return "Data Not Found";
       }
},
  templateResult: UniversalSearchformatRepo,
  templateSelection: UniversalSearchformatRepoSelection
});




$("#universalSearch").on("change", function () { console.log('data change') });

function UniversalSearchformatRepo (repo) {
  if (repo.loading) {
    return repo.label;
  }
 


    if(repo.text=='Proposals'){
    
      if(repo.children.length>0){
        var $container = $('<p class="toggle_search_results" >Proposals <a href="javascript:void(0)" ><i class="fa fa-chevron-circle-up"></i> <span >['+repo.result_count+']</span></a></p>');
      }
    }else if(repo.text=='Contacts')
    {
      if(repo.children.length>0){
        var $container = $('<p class="toggle_search_results">Contacts <a href="javascript:void(0)" ><i class="fa fa-chevron-circle-up"></i><span >['+repo.result_count+']</span></a></p>');
      }
    }else if(repo.text=='Leads')
    {
      if(repo.children.length>0){
        var $container =  $('<p class="toggle_search_results">Leads <a href="javascript:void(0)" ><i class="fa fa-chevron-circle-up"></i><span >['+repo.result_count+']</span></a></p>');
      } 
    }else if(repo.text=='Prospects')
    {
      if(repo.children.length>0){
        var $container =  $('<p class="toggle_search_results">Prospects <a href="javascript:void(0)" ><i class="fa fa-chevron-circle-up"></i><span >['+repo.result_count+']</span></a></p>');
      } 
    }else if(repo.text=='Accounts')
    {
      if(repo.children.length>0){
        var $container =  $('<p class="toggle_search_results">Accounts <a href="javascript:void(0)" ><i class="fa fa-chevron-circle-up"></i><span >['+repo.result_count+']</span></a></p>');
      } 
    }

if(repo.text!='Proposals' && repo.text!='Contacts' && repo.text!='Leads' && repo.text!='Propects'){
  if(repo.entity_type=='proposal'){
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            
            "<div class='select2-result-repository__meta'>" +
                "<table >"+
                "<tr><th style='text-align: right;'>Account:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-account-name'></td><th style='text-align: right;padding-left:15px'>Owner:</th><td style='text-align: left;padding-left:5px' class='select2-result-owner-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Project:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-entity-name'></td><th style='text-align: right;padding-left:15px'>Created:</th><td style='text-align: left;padding-left:5px' class='select2-result-created'></td></tr>"+
                "<tr><th style='text-align: right;'>Contact:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-client-name'></td><th style='text-align: right;padding-left:15px'>Job#:</th><td style='text-align: left;padding-left:5px' class='select2-result-job-number'></td></tr>"+
                "<tr><th style='text-align: right;'>Price:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-price'></td><th style='text-align: right;padding-left:15px'></th><th style='text-align: left;padding-left:5px'></th></tr>"+
                "</table>"+
                
            "</div>" +
            "</div>"
        );
        
        $container.find(".select2-result-account-name").text(repo.account_name);
        $container.find(".select2-result-client-name").text(repo.client_name);
        $container.find(".select2-result-entity-name").text(repo.entity_name);
        $container.find(".select2-result-created").text(repo.created_date);
        $container.find(".select2-result-job-number").text(repo.job_number);
        $container.find(".select2-result-owner-name").text(repo.owner_name);
          $container.find(".select2-result-price").text('$'+repo.proposal_price);
        
        
    }else 
    if(repo.entity_type == 'client')
    {
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            
            "<div class='select2-result-repository__meta'>" +
                "<table >"+
                "<tr><th style='text-align: right;'>Account:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-account-name'></td><th style='text-align: right;padding-left:15px'>Owner:</th><td style='text-align: left;padding-left:5px' class='select2-result-owner-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Contact:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-entity-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Email:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-email'></td></tr>"+
            "</div>" +
            "</div>"
        );
      
        $container.find(".select2-result-entity-name").text(repo.entity_name);
        $container.find(".select2-result-account-name").text(repo.account_name);
        $container.find(".select2-result-email").text(repo.email);
        $container.find(".select2-result-owner-name").text(repo.owner_name);
    }else if(repo.entity_type == 'lead')
    {
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            
            "<div class='select2-result-repository__meta'>" +
                "<table >"+
                "<tr><th style='text-align: right;'>Company:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-account-name'></td><th style='text-align: right;padding-left:15px'>Owner:</th><td style='text-align: left;padding-left:5px' class='select2-result-owner-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Project:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-project-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Contact:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-entity-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Status:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-lead-status'></td></tr>"+
            "</div>" +
            "</div>"
        );
      
        $container.find(".select2-result-entity-name").text(repo.entity_name);
        $container.find(".select2-result-account-name").text(repo.account_name);
        $container.find(".select2-result-project-name").text(repo.project_name);
        $container.find(".select2-result-owner-name").text(repo.owner_name);
        $container.find(".select2-result-lead-status").text(repo.lead_status);
    }else if(repo.entity_type == 'prospect')
    {
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            
            "<div class='select2-result-repository__meta'>" +
                "<table >"+
                "<tr><th style='text-align: right;'>Company:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-account-name'></td><th style='text-align: right;padding-left:15px'>Owner:</th><td style='text-align: left;padding-left:5px' class='select2-result-owner-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Contact:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-entity-name'></td></tr>"+
            "</div>" +
            "</div>"
        );
      
        $container.find(".select2-result-entity-name").text(repo.entity_name);
        $container.find(".select2-result-account-name").text(repo.account_name);
        $container.find(".select2-result-owner-name").text(repo.owner_name);
    }
    else if(repo.entity_type == 'account')
    {
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            
            "<div class='select2-result-repository__meta'>" +
                "<table >"+
                "<tr><th style='text-align: right;'>Company:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-entity-name'></td><th style='text-align: right;padding-left:15px'>Owner:</th><td style='text-align: left;padding-left:5px' class='select2-result-owner-name'></td></tr>"+
                "<tr><th style='text-align: right;'>Proposals:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-proposal-count'></td><th style='text-align: right;padding-left:15px'>Total Bid:</th><td style='text-align: left;padding-left:5px' class='select2-result-total-bid'></td></tr>"+
                "<tr><th style='text-align: right;'>Contacts:</th><td style='text-align: left;padding-left:5px;width:150px' class='select2-result-contact-count'></td></tr>"+
            "</div>" +
            "</div>"
        );
      
        $container.find(".select2-result-entity-name").text(repo.entity_name);
        $container.find(".select2-result-owner-name").text(repo.owner_name);
        $container.find(".select2-result-proposal-count").text(repo.proposal_count);
        $container.find(".select2-result-total-bid").text('$'+repo.total_bid);
        $container.find(".select2-result-contact-count").text(repo.contact_count);
    }
        
}

  return $container;
}



function UniversalSearchformatRepoSelection (repo) {
  return false ;
}
$("#select2-universalSearch-container .select2-selection__placeholder").text('Search ')

$('#universalSearch').on("select2:selecting", function(e,data) { 

    var entity_type = e.params.args.data.entity_type;
    var entity_id = e.params.args.data.entity_id;
    
   // what you would like to happen
   $('#universalSearch').val('');
   if(entity_type == 'proposal'){
    window.location.href = SITE_URL+"proposals/edit/"+entity_id;
   }else if(entity_type == 'client'){
    window.location.href = SITE_URL+"clients/clientPreviewEditCheck/"+entity_id;
   }else if(entity_type == 'lead'){
    var lead_status = e.params.args.data.lead_status;
    if(lead_status !='Working'){
      swal('','Lead is not Active, You can`t Open');
      e.stopPropagation();
      return false;
    }else{
      window.location.href = SITE_URL+"leads/edit/"+entity_id;
    }
    
   }else if(entity_type == 'prospect'){
    window.location.href = SITE_URL+"prospects/edit/"+entity_id;
    }else if(entity_type == 'account'){
    window.location.href = SITE_URL+"accounts/info/"+entity_id;
    }
    //$('#UniversalSearchBox').hide();
    $('.UniversalSearchClickLoader').css('visibility','visible');
    
    event.preventDefault();
});

$(".UserProfileBtn").click(function () {
    $(".UserDetailsSection").toggle();
    
});
$('body').click( function(event) {
        var $trigger = $("#UserProfileBtn");

        if("UserProfileBtn" !== event.target.id && !$trigger.has(event.target).length){
          
                $(".UserDetailsSection").hide();

       }
       
   });

   $(document).on('click', ".toggle_search_results", function () {
     
      $(this).closest('.select2-results__option--group').find('.select2-results__options--nested').toggle();
      $(this).find('i').toggleClass("chevron_down");
      $(this).closest('strong').toggleClass("white_border");
  });
   
  $(document).on('keyup', ".UniversalSearchBox .select2-search__field", function () {
    
    if($(this).val()){
      //$('.UniversalSearchLoader').addClass('ui-autocomplete-loading');
      $('.UniversalSearchClickLoader').css('visibility','visible');
    }
    
});

  $(document).on('click', ".show_hide_search_tips", function () {
     $('#UniversalSearchDialog').css('height','auto');
     $('#UniversalSearchDialog').css('min-height','96px;');
     $('.UniversalSearchTips').toggle();
 });


 
//  $(".automatic-resend-li,.sales-targets-li,.disabled-tab").click(function (e) {
//         e.preventDefault();
//         swal({
//                 type: 'info',
//                 title: '<span style=font-size:24px;color:#545454>Sales Manager Feature Disabled</span>',
//                 html: '<p>Please contact support@pavementlayers.com for the process and costs with activating this amazing feature.</p>',
//                 showCloseButton: true,
//             })
//     });
  
</script>
  
<script>
$(".automatic-resend-li, .sales-targets-li, .modify-price-swal, .disabled-tab").click(function (e) {
    e.preventDefault();

    // Check if the clicked element has the class "sales-targets-li" and its text is "Modify Prices"
    if ($(this).hasClass("modify-price-swal")) {
        swal({
            type: 'info',
            title: '<span style="font-size:24px;color:#545454">Modify Price Feature Disabled</span>',
            html: '<p>Please contact <a href="mailto:support@pavementlayers.com">support@pavementlayers.com</a> for the process and costs with activating this amazing feature.</p>',
            showCloseButton: true,
        });
    }
    // Check if the clicked element has the class "campaigns"
    else if ($(this).hasClass("campaigns")) {
        swal({
            type: 'info',
            title: '<span style="font-size:24px;color:#545454">Campaign Feature Disabled</span>',
            html: '<p>Please contact <a href="mailto:support@pavementlayers.com">support@pavementlayers.com</a> for the process and costs with activating this amazing feature.</p>',
            showCloseButton: true,
        });
    } else {
        // Default message for other cases
        swal({
            type: 'info',
            title: '<span style="font-size:24px;color:#545454">Sales Manager Feature Disabled</span>',
            html: '<p>Please contact <a href="mailto:support@pavementlayers.com">support@pavementlayers.com</a> for the process and costs with activating this amazing feature.</p>',
            showCloseButton: true,
        });
    }
});
</script>

<!-- <?php echo date('H:i:s') ?> -->