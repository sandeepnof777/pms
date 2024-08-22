<?php
    $url = 'ajax/ajaxProposals';
    $resend_id = $this->uri->segment(3);
    if (isset($tableStatus)) {
        $url = 'ajax/ajaxProposalsStatus';
    }
    if (isset($filterResend)) {
        $url = 'ajax/ajaxProposalsResend';
    }
    if (isset($tableStats)) {
        $url = 'ajax/ajaxProposalsStats';
    }
    if (isset($tableAccStats)) {
        $url = 'ajax/ajaxProposalsAccStats';
    }
    if (isset($tableAutomaticResend)) {
        $url = 'ajax/ajaxProposalsAutomaticResend';
    }
    $showPsa = false;
    if (isset($account)) {
        if ($account->getCompany()->hasPSA()) {
            $showPsa = true;
        }
    }

    $history_flags = '';
    foreach($proposal_event_email_types as $event_email_type){
        $history_flags .= '<input type="checkbox" class="history_email_type" value="'.$event_email_type->getId().'"><div class="badge tiptiptop" style="float:left;background-color:'.$event_email_type->getColorCode().';width: fit-content;margin-right: 20px;" title="'.$event_email_type->getTypeName().'">'.$event_email_type->getTypeCode().'</div>';

    }
?>
<style>.select2-container {
width: 250px !important;
padding: 0;
}

</style>
<div id="link-date-change-confirm" title="Update Proposal Date">
        <p>This will update when the proposal Preview Expiry date</p>
        <br/>
        <input type="hidden" id="expiry_preview_id" >
        <input type="hidden" id="expiry_proposal_id" >
        <p>Select Date: <input type="text" id="linkdcDate"/></p>
    </div>

<div id="group-expiry-date-change-confirm" title="Update Proposal Date">
    <p>This will update when the proposal Preview Expiry date</p>
    <br/>
   
    <input type="hidden" id="group_expiry_proposal_id" >
    <p>Select Date: <input type="text" id="grouplinkdcDate"/></p>
</div>
<div id="proposalLinks" title="Proposal Links" style="display:none;">
        <h4><span class="proposal_link_project_name" style="color: #3f3f41;"></span>: Proposal Links</h4>
        <hr />
        <div class="materialize">
    <div class="m-btn groupAction tiptip groupActionsButton" title="Carry out actions on selected proposals"
             id="groupActionsButtonPreview" style="display: none;">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="materialize groupActionsContainer" style="width:298px">
                <div class="collection groupActionItems" style="width:298px; float:left">
                    <a href="#" id="groupSetExpriry" data-proposal-id="" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar"></i> Set Expiry 
                    </a>
                    <a href="#" id="groupRemoveExpiry" data-proposal-id="" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar"></i> Remove Expiry
                    </a>
                    <a href="#" class="groupPreviewEnableDisable collection-item iconLink" data-is-enable="1" data-proposal-id="" >
                        <i class="fa fa-fw fa-check-circle"></i> Enable
                    </a>
                    <a href="#" class="groupPreviewEnableDisable collection-item iconLink" data-is-enable="0" data-proposal-id="" >
                        <i class="fa fa-fw fa-ban fa-ban-dark"></i> Disable
                    </a>
                    
                    <a href="#" class="groupSignatureEnableDisable collection-item iconLink" data-is-enable="1" data-proposal-id="" >
                        <i class="fa fa-fw fa-check-circle"></i> Enable Signature
                    </a>
                    <a href="#" class="groupSignatureEnableDisable collection-item iconLink" data-is-enable="0" data-proposal-id="" >
                        <i class="fa fa-fw fa-ban fa-ban-dark"></i> Disable Signature
                    </a>

                </div>
            </div>
        </div>
    </div> 
<style>
#showProposalLinksTable_wrapper{
    margin-top: 40px!important;
}
#showProposalLinksTable_wrapper .dropdownToggle.open{
    background-color: #25AAE1!important;
}
#showProposalLinksTable{
padding-top: 12px;
}
.buttonInside {
    position: relative;
    margin-bottom: 10px;
    margin-right: 40px;
    float: left;
}
.send_proposal_to_field_div{
    position: relative;
    padding-left: 160px;
}
.buttonInside button{
  position:absolute;
  right: 10px;
  top: 0px;
  border:none;
  height:26px;
  width:35px;
  cursor: pointer;
  outline:none;
  text-align:center;
  font-weight:bold;
  padding:2px;
}
.send_proposal_to_field_td{
    width: 480px;
}
</style> 
        <table id="showProposalLinksTable" class="boxed-table" style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 20px;"><input type="checkbox" id="previewMasterCheck"></th>
                <th>Status</th>
                <th>Email</th>
                <th>Sent</th>
                <th>Expires</th>
                <th>Views</th>
                <th>Last Viewed</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div id="addProposalDialog" title="Proposal " >
    <p style="padding-top:25px"><label style="margin-left: 6%;">Search</label>
    <select name="SeachcontactName" id="SeachcontactName" class="dont-uniform"  ><option></option></select></p>
    <input type="hidden" id="add_proposal_contact_id_hidden">
    <a class="btn blue-button" id="add_proposal_select_btn" style="top: 31px;position: absolute;right: 20px;">Create Proposal</a>
</div>

<div id="proposal-sharing-dialog" title="Proposal Share">
    <input type="hidden" id="proposal_sharing_proposal_id" name="proposal_sharing_proposal_id">

    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table ">
        <thead>
        <tr>
            <td><strong>Proposal : <span class="proposal_sharing_project_name"></span></strong></td>
        </tr>
        </thead>
        <tr class="">
            <td>
                <p class="clearfix ">
                                    
                    <label style="width: 100px;">Select User <span>*</span></label>
                    <select name="SeachaccountName" id="SeachaccountName" class="dont-uniform "  ><option></option></select></p>
                    <input type="hidden" id="proposal_sharing_user_id" name="proposal_sharing_user_id">
                </p>
            </td>
        </tr>
    </table>

    


</div>

<script src='/static/js/inputmask.js'></script>

<script src="<?php echo site_url('static') ?>/js/signature/signature_pad.umd.js"></script>


<script type="text/javascript">


    
var site_url = '<?php echo site_url() ?>';
var oTable;
var popup_ui;
var proposal_filter;
var ev_proposal_id;
var notes_tiptip_proposal_id;
var price_breakdown_tiptip_proposal_id;
var proposal_name_tiptip_proposal_id;
var currentXhr;
var approval_msg;
var showProposalLinksDataTable;
var showSharedProposalUserTable;
var is_approval_user = <?= $approvalUser ? 'true' : 'false'; ?>;
var DateFormat={};!function(e){var I=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],O=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],v=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],w=["January","February","March","April","May","June","July","August","September","October","November","December"],a={Jan:"01",Feb:"02",Mar:"03",Apr:"04",May:"05",Jun:"06",Jul:"07",Aug:"08",Sep:"09",Oct:"10",Nov:"11",Dec:"12"},u=/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.?\d{0,3}[Z\-+]?(\d{2}:?\d{2})?/;DateFormat.format=function(){function o(e){return a[e]||e}function i(e){var a,r,t,n,s,o=e,i="";return-1!==o.indexOf(".")&&(o=(n=o.split("."))[0],i=n[n.length-1]),3<=(s=o.split(":")).length?(a=s[0],r=s[1],t=s[2].replace(/\s.+/,"").replace(/[a-z]/gi,""),{time:o=o.replace(/\s.+/,"").replace(/[a-z]/gi,""),hour:a,minute:r,second:t,millis:i}):{time:"",hour:"",minute:"",second:"",millis:""}}function D(e,a){for(var r=a-String(e).length,t=0;t<r;t++)e="0"+e;return e}return{parseDate:function(e){var a,r,t={date:null,year:null,month:null,dayOfMonth:null,dayOfWeek:null,time:null};if("number"==typeof e)return this.parseDate(new Date(e));if("function"==typeof e.getFullYear)t.year=String(e.getFullYear()),t.month=String(e.getMonth()+1),t.dayOfMonth=String(e.getDate()),t.time=i(e.toTimeString()+"."+e.getMilliseconds());else if(-1!=e.search(u))a=e.split(/[T\+-]/),t.year=a[0],t.month=a[1],t.dayOfMonth=a[2],t.time=i(a[3].split(".")[0]);else switch(6===(a=e.split(" ")).length&&isNaN(a[5])&&(a[a.length]="()"),a.length){case 6:t.year=a[5],t.month=o(a[1]),t.dayOfMonth=a[2],t.time=i(a[3]);break;case 2:r=a[0].split("-"),t.year=r[0],t.month=r[1],t.dayOfMonth=r[2],t.time=i(a[1]);break;case 7:case 9:case 10:t.year=a[3];var n=parseInt(a[1]),s=parseInt(a[2]);n&&!s?(t.month=o(a[2]),t.dayOfMonth=a[1]):(t.month=o(a[1]),t.dayOfMonth=a[2]),t.time=i(a[4]);break;case 1:r=a[0].split(""),t.year=r[0]+r[1]+r[2]+r[3],t.month=r[5]+r[6],t.dayOfMonth=r[8]+r[9],t.time=i(r[13]+r[14]+r[15]+r[16]+r[17]+r[18]+r[19]+r[20]);break;default:return null}return t.time?t.date=new Date(t.year,t.month-1,t.dayOfMonth,t.time.hour,t.time.minute,t.time.second,t.time.millis):t.date=new Date(t.year,t.month-1,t.dayOfMonth),t.dayOfWeek=String(t.date.getDay()),t},date:function(a,e){try{var r=this.parseDate(a);if(null===r)return a;for(var t,n=r.year,s=r.month,o=r.dayOfMonth,i=r.dayOfWeek,u=r.time,c="",h="",l="",m=!1,y=0;y<e.length;y++){var d=e.charAt(y),f=e.charAt(y+1);if(m)"'"==d?(h+=""===c?"'":c,c="",m=!1):c+=d;else switch(l="",c+=d){case"ddd":h+=(S=i,I[parseInt(S,10)]||S),c="";break;case"dd":if("d"===f)break;h+=D(o,2),c="";break;case"d":if("d"===f)break;h+=parseInt(o,10),c="";break;case"D":h+=o=1==o||21==o||31==o?parseInt(o,10)+"st":2==o||22==o?parseInt(o,10)+"nd":3==o||23==o?parseInt(o,10)+"rd":parseInt(o,10)+"th",c="";break;case"MMMM":h+=(M=s,void 0,g=parseInt(M,10)-1,w[g]||M),c="";break;case"MMM":if("M"===f)break;h+=(k=s,void 0,p=parseInt(k,10)-1,v[p]||k),c="";break;case"MM":if("M"===f)break;h+=D(s,2),c="";break;case"M":if("M"===f)break;h+=parseInt(s,10),c="";break;case"y":case"yyy":if("y"===f)break;h+=c,c="";break;case"yy":if("y"===f)break;h+=String(n).slice(-2),c="";break;case"yyyy":h+=n,c="";break;case"HH":h+=D(u.hour,2),c="";break;case"H":if("H"===f)break;h+=parseInt(u.hour,10),c="";break;case"hh":h+=D(t=0===parseInt(u.hour,10)?12:u.hour<13?u.hour:u.hour-12,2),c="";break;case"h":if("h"===f)break;t=0===parseInt(u.hour,10)?12:u.hour<13?u.hour:u.hour-12,h+=parseInt(t,10),c="";break;case"mm":h+=D(u.minute,2),c="";break;case"m":if("m"===f)break;h+=parseInt(u.minute,10),c="";break;case"ss":h+=D(u.second.substring(0,2),2),c="";break;case"s":if("s"===f)break;h+=parseInt(u.second,10),c="";break;case"S":case"SS":if("S"===f)break;h+=c,c="";break;case"SSS":h+=D(u.millis.substring(0,3),3),c="";break;case"a":h+=12<=u.hour?"PM":"AM",c="";break;case"p":h+=12<=u.hour?"pm":"am",c="";break;case"E":h+=(b=i,O[parseInt(b,10)]||b),c="";break;case"'":c="",m=!0;break;default:h+=d,c=""}}return h+=l}catch(e){return console&&console.log&&console.log(e),a}var b,k,p,M,g,S},prettyDate:function(e){var a,r,t,n,s;if("string"!=typeof e&&"number"!=typeof e||(a=new Date(e)),"object"==typeof e&&(a=new Date(e.toString())),r=((new Date).getTime()-a.getTime())/1e3,t=Math.abs(r),n=Math.floor(t/86400),!isNaN(n))return s=r<0?"from now":"ago",t<60?0<=r?"just now":"in a moment":t<120?"1 minute "+s:t<3600?Math.floor(t/60)+" minutes "+s:t<7200?"1 hour "+s:t<86400?Math.floor(t/3600)+" hours "+s:1===n?0<=r?"Yesterday":"Tomorrow":n<7?n+" days "+s:7===n?"1 week "+s:n<31?Math.ceil(n/7)+" weeks "+s:"more than 5 weeks "+s},toBrowserTimeZone:function(e,a){return this.date(new Date(e),a||"MM/dd/yyyy HH:mm:ss")}}}()}(),jQuery.format=DateFormat.format;
var ui;
var email_to_input_count = 1;
<?php
        if($this->uri->segment(2)=='resend' || $this->uri->segment(2)=='stats' || $this->uri->segment(2)=='account_stats' || $this->uri->segment(2)=='status'){?>
        popup_ui =true;
<?php }
?>
function cleanNumber(numberString) {
        var number = numberString.replace('$', '');
        number = number.replace(/,/g, '');
        number = number.replace("%", '');
        return number;
    }
$(".currency_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });

var showPsa = <?php echo var_export($showPsa) ?>;
var initialSearch = '<?php echo $search; ?>';

$(document).ready(function() {

    $("#signature-tabs").tabs();

    if(localStorage.getItem("proposals_win_column_show_1") == null && localStorage.getItem("proposals_win_column_show") != null){

        localStorage.setItem("proposals_win_column_show_1",localStorage.getItem("proposals_win_column_show"));
    }

    $("#addProposalDialog").dialog({
        modal: true,
        autoOpen: false,
        width: 560,
        height: 140,
        open: function(event, ui) {
            // Reset Dialog Position
            $(this).dialog('widget').position({ my: "center", at: "center", of: window });
        },
    });

    $('.businessType').select2({
                        placeholder: "Select one Business Type"
                    });

$.fn.dataTable.ext.errMode = 'none';
function initProposalTable(search){

    $('.dataTables-proposalsNew').show();
    oTable =  $('.dataTables-proposalsNew').on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
        $("#datatablesError").dialog('open');
    }).on('processing.dt', function (e, settings, processing) {
        if (processing) {
            $("#proposalsTableLoader").show();
        } else {
            $("#proposalsTableLoader").hide();
        }
   })
    .DataTable( {
        "processing": true,
        "serverSide": true,
        "searchDelay": 1500,
        "preDrawCallback": function( settings ) {

            if ($.fn.DataTable.isDataTable('.dataTables-proposalsNew')) {
                var dt = $('.dataTables-proposalsNew').DataTable();

                //Abort previous ajax request if it is still in process.
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        },
        "ajax": {
            url: "<?php echo site_url($url . '?') . 'action=' . $action . '&group=' . $group . "&client=" . $client."&resend_id=".$resend_id; ?>&t=" + Math.floor((Math.random() * 100000) + 1),
            data: function(d) {
                 d.campaignFilter = getFilterValue();
            }
        },
        "columnDefs": [
            // Checkbox
            {"targets": [ 0 ], "width":'20px', "searchable": false, "sortable": false },
            // Go Button
            {"targets": [ 1 ], "width":'50px', "searchable": false, "sortable": false},
            // Date
            {"targets": [ 2 ],"type": "date-formatted"},
            // Status
            {"targets": [ 3 ],"width":"100px","type": "html"},
            // Win Date #
            {"targets": [ 4 ],"visible": true},
            // Job #
            {"targets": [ 5 ],"visible": true},
            // Account
            {"targets": [ 6 ],"visible": true},
            // Project Name
            {"targets": [ 7 ],"visible": true},
            // Image Count
            {"targets": [ 8 ],"visible": true, 'class': 'dtCenter'},
            // Price
            {"targets": [ 9 ],"type": "html"},
            // Contact
            {"targets": [ 10 ],"type": "html"},
            // User / Owner
            {"targets": [ 11 ],"type": "html"},
            // Last Activity
            {"targets": [ 12 ],"type": "html"},
            // Mail Status
            {"targets": [ 13 ],"type": "html", "class": 'dtCenter'},
            // Delivery Status
            {"targets": [ 14 ],"width":'40px',"class": 'dtCenter'},
            // Open Status
            {"targets": [ 15 ],"width":'40px',"class": 'dtCenter'},
            // Audit Status
            {"targets": [ 16 ],"width":'40px',"class": 'dtCenter',"visible": false},
            // Estimate Status
            {"targets": [ 17 ],"width":'40px',"sortable": true, "searchable": false},
            // Gross Profit
            {"targets": [ 18 ],"type": "html", },
        ],
        "sorting": [
            [2, "desc"]
        ],
        
        "jQueryUI": true,
        "autoWidth": true,
        "stateSave": true,
        "scrollY": '70vh',
        "scrollCollapse": true,
        "scrollX": true,
        "paginationType": "full_numbers",
        "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
        "lengthMenu": [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000]
        ],
        "rowCallback": function( row, data ) {
                 //$('td:eq(0)', row).attr('style', 'border-left:4px solid #'+data[18]+'!important');
                $('td:eq(0)', row).attr('style', 'position:relative');
                if(data[19]){
                    $(row).addClass("sharedProposal"); 
                }
            },
        "drawCallback": function (settings) {
            if (!ui) {
                initUI(true);
                ui = true;
            }

            //initButtons();
            initTiptip();
            initStatusChange();
            tableSettings();
            updateNumSelected();
            check_highlighted_row();
            if (oTable) {

                $("#filterNumResults").text(oTable.page.info().recordsDisplay);
                numMappedProposals = oTable.page.info().recordsDisplay;

                // Only Update if map is visible
                //updateMap(true);

            }
            $("#groupSelectAllTop").html('<span id="numSelected">0</span> selected');
            $("#proposalMasterCheck").prop('checked', false);
            $("#filterLoading").hide();
            $("#filterResults").css('visibility', 'visible');

            adjustColumns();
            notes_tooltip();
            price_breakdown_tooltip();
            proposal_name_tooltip();
            if (initialSearch) {
                setTimeout(function() {
                    $("#proposalsTable_filter input").val(initialSearch);
                    $("#proposalsTable_filter input").trigger('keyup');
                    initialSearch = false;
                }, 50);

            }
            $.uniform.update();
        },
        language: {
            infoFiltered: ''
        }
    });


    oTable.column(16).visible(showPsa);
    oTable.column(18).visible(false);

    var column_show = localStorage.getItem("proposals_win_column_show_1");
    oTable.columns( [16,17] ).visible( false );
    if(column_show){

        var column_show = column_show.split(',');
        oTable.columns(column_show).visible( true );

        for($i=0;$i < column_show.length;$i++){
            $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
        }

    } else {
        // Defaults to show
        var column_show = [4,5,6,7,8,9,10,11,12,13,14,15,16];

        if (showPsa) {
            column_show.push(16);
        }

        oTable.columns( column_show ).visible( true );
        for($i=0;$i < column_show.length;$i++){
            $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
        }
    }
}

   // oTable.columns.adjust().draw();
    var clearPreset = true;

    // Table functions //
    <?php

    // Statuses for dropdown
    $jsonStatuses = [];

    foreach ($statuses as $status) {
        $jsonStatuses['_' . $status->getStatusId()] = $status->getText();
    }
    ?>

    function adjustColumns() {
        //oTable.columns.adjust();
    }

    // Status change
    function initStatusChange() {

        $('.change-proposal-status').each(function () {
            var id = $(this).attr('id');
            id = id.replace(/status_/g, '');
            var url = '<?php echo site_url('ajax/changeProposalStatus') ?>/' + id;
            var status = 'Click to Edit';
            $(this).editable(url, {
                //data: "{'Open':'Open','Won':'Won','Completed':'Completed','Lost':'Lost','Cancelled':'Cancelled','On Hold':'On Hold', 'Invoiced via QuickBooks':'Invoiced via QuickBooks'}",
                data: <?php echo json_encode($jsonStatuses); ?>,
                type: 'select',
                onblur: 'submit',
                callback : function(result, settings, submitdata) {

        oTable.ajax.reload(null,false )
        //datatable_appointments.ajax.reload( null, false )


    },
            });

        });
    }

    // Apply Filters by default


    var firstRun = true;
    applyFilter();
    console.log('This is where we run first filter');

    /**
     *  Now that the same datasource is in use, some settings need to be applied based on the page
     */
    function tableSettings() {
        // Populate the toolbar
        //$("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
    }

    // Group action selected numbers
    function updateNumSelected(){
        var num = $(".groupSelect:checked").length;
        var hide_count = 0;
        var show_count = 0;
        $(".groupSelect:checked").closest('tr').each(function(){
            if($(this).find('.proposalsTableDropdownToggle').attr('data-proposal-hidden')==1){
                hide_count = hide_count+1;
            }else{
                show_count = show_count+1;
            }
        })

        var include_count = 0;
        var exclude_count = 0;
        $(".groupSelect:checked").closest('tr').each(function(){
            if($(this).find('.proposalsTableDropdownToggle').attr('data-proposal-excluded')==1){
                exclude_count = exclude_count+1;
            }else{
                include_count = include_count+1;
            }
        })


        // Hide the options if 0 selected
        if (num < 1) {
            $("#groupActionIntro").show();
            $(".groupAction").hide();
            $(".groupActionsContainer").hide();
        }
        else {
            $("#groupActionIntro").hide();
            $(".groupAction").show();

            (show_count<1) ? $('#groupHideProposal').hide():$('#groupHideProposal').show();
            (hide_count<1) ? $('#groupShowProposal').hide():$('#groupShowProposal').show();

            (exclude_count<1) ? $('#groupIncludeResend').hide():$('#groupIncludeResend').show();
            (include_count<1) ? $('#groupExcludeResend').hide():$('#groupExcludeResend').show();
        }
        $("#numSelected").html(num);
    }



    // All / None user master check
$("#proposalMasterCheck").change(function () {
            var checked = $(this).is(":checked");
            $(".groupSelect").prop('checked', checked);
            updateNumSelected();
});

    // Update the counter after each change
    $(".groupSelect").live('change', function () {
        updateNumSelected();
    });

    $(document).on("keyup",".new_resend_name",function(e) {

         if($(this).val()){
             $(this).removeClass('error');
         }else{

            if($("#resendSelect").val() == 0){
                $(this).addClass('error');
            }
         }

     });

   function get_resend_lists(){

        $.ajax({
            url: '<?php echo site_url('ajax/get_resend_lists') ?>',
            type: "GET",

            dataType: "json",
            success: function (data) {
                var html = '<option value="">Select Resend Campaign</option><option value="0">New</option><option value="-1">No Campaign</option>';
                for($i=0;$i<data.length;$i++){
                    html +='<option value="'+data[$i].id+'">'+data[$i].resend_name+'</option>'
                }
                if(data.length){
                    $('.campaign_btn').show();
                }
                $("#resendSelect").html(html);
            }
        });

     }


    $("#resendSelect").live('change', function () {
        $(".new_resend_name").prop('disabled', false);
        $(".no_campaign").show();
       if($(this).val() <1){
            $('.new_resend_name_span').show();

            if($(this).val() ==0){
                $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>');
            }else{
                $(".new_resend_name").val('');
                $(".no_campaign").hide();
                //$(".new_resend_name").prop('disabled', true);
            }

            $('#messageFromName').prop('disabled', false);
            $('#messageFromEmail').prop('disabled', false);
            $('#messageSubject').prop('disabled', false);
            $('#templateSelect').prop('disabled', false);
            $('.is_templateSelect_disable').hide();
            $( "#emailCustom" ).prop( "checked", false );
            $( "#emailCC" ).prop( "checked", false );
            $( "#emailCustom" ).trigger('change');
            $( "#templateSelect" ).trigger('change');

            $('#emailCC').prop('disabled', false);
            $('#emailCustom').prop('disabled', false);

            //CKEDITOR.instances.message.setReadOnly(false);
            tinymce.activeEditor.mode.set("design");
            $.uniform.update();

       }else{
            $('.new_resend_name_span').hide();
            $('.new_resend_name').removeClass('error');
            $.ajax({
            url: '<?php echo site_url('ajax/get_resend_details') ?>',
            type: "POST",
            data: {
                "resend_id": $(this).val(),

            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    //refresh frame

                   $('#messageSubject').val(data.subject);
                   $('#messageSubject').prop('disabled', true);
                   $('#templateSelect').prop('disabled', true);
                   $('.is_templateSelect_disable').css('display','block');
                   if(data.email_cc==1){
                        $( "#emailCC" ).prop( "checked", true );
                        $('#emailCC').prop('disabled', true);
                        $.uniform.update();
                   }else{
                        $( "#emailCC" ).prop( "checked", false );
                        $('#emailCC').prop('disabled', true);
                        $.uniform.update();
                   }


                   if(data.custom_sendor==1){
                        $( "#emailCustom" ).prop( "checked", true );
                        $('#emailCustom').prop('disabled', true);

                        $.uniform.update();

                        $('#messageFromName').val(data.custom_sendor_name);
                        $('#messageFromEmail').val(data.custom_sendor_email);
                   }else{
                        $( "#emailCustom" ).prop( "checked", false );
                        $('#emailCustom').prop('disabled', true);
                        $.uniform.update();
                        $('#messageFromName').val('');
                        $('#messageFromEmail').val('');
                   }
                   $( "#emailCustom" ).trigger('change');

                   $('.new_resend_name').val(data.resend_name);
                   $(".new_resend_name").prop('disabled', true);
                    $('#messageFromName').prop('disabled', true);
                   $('#messageFromEmail').prop('disabled', true);
                   //CKEDITOR.instances.message.setData(data.email_content);
                   //CKEDITOR.instances.message.setReadOnly(true);
                   tinymce.activeEditor.setContent(data.email_content);
                   tinymce.activeEditor.mode.set("readonly");
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        });

       }
    });

    $("#estimatepreviewDialog").dialog({
 
            position: ['center', 'center'],
            modal: true,
            autoOpen: false,
            width: 960,
            resizable: true,
            dragStart: function( event, ui ) {$(this).parent().css('transform', 'translateX(0%)');$(this).parent().css('left', '0%');},
            resizeStart: function( event, ui ) {$(this).parent().css('transform', 'translateX(0%)');$(this).parent().css('left', '0%');},
            open: function(event, ui) {
                $(this).parent().css('position', 'fixed');
                $(this).parent().css('top', '30px');
                $(this).parent().css('right', '0');
                $(this).parent().css('left', '50%');
                $(this).parent().css('width', '960px');
                // $(this).parent().css('margin-right', 'auto');
                // $(this).parent().css('margin-left', 'auto');

                $(this).parent().css('transform', 'translateX(-50%)');
               $(this).parent().css('height', 'auto');
                $(this).parent().css('max-height', '95%');
                //$('<a href="#" style="margin-right:30px" class="right btn">F</a>').prependTo('.ui-dialog-titlebar');
            },


        });

        $("#check_test_full").live('click', function () {
            $( "#estimatepreviewDialog" ).dialog( "option", "width", '100%' );
            //$( "#estimatepreviewDialog" ).dialog( "option", "height", '100%' );
        });

        $("#workOrderDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 960,
            resizable: false,
            dragStart: function( event, ui ) {$(this).parent().css('transform', 'translateX(0%)');$(this).parent().css('left', '0%');},
            open: function(event, ui) {
                $(this).parent().css('position', 'fixed');
                $(this).parent().css('top', '30px');
                $(this).parent().css('left', '50%');
                $(this).parent().css('height', 'auto');
                $(this).parent().css('max-height', '95%');
                $(this).parent().css('transform', 'translateX(-50%)');
            }
        });
    /* Proposal Deletion */
    $("#confirm-delete-message").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function(){
                $.ajax({
                    url: '<?php echo site_url('ajax/deleteProposal') ?>/' + $("#client-delete").attr('rel'),
                    type: "GET",
                    data: {},
                    dataType: "json"
                })
                .done(function (data) {
                    // Remove the row if delete completed
                    if (data.deleteComplete) {
                        $("#delete_proposal_" + $("#client-delete").attr('rel')).parents('tr').fadeOut('slow');
                    }

                    if (data.deleteRequested) {
                        $("#delete_proposal_" + $("#client-delete").attr('rel')).parents('tr').find('.change-proposal-status').text(data.text);
                    }
                    if (data.isDemo) {
                        swal(
                            'Error',
                            'Demo Proposals not deleted'
                        );
                        //$("#delete_proposal_" + $("#client-delete").attr('rel')).parents('tr').find('.change-proposal-status').text('You Can Not Delete Demo Proposals');
                    }

                    if($('.reload_table').length){
                        $('#child_resend').trigger('change');
                    }else{
                        oTable.ajax.reload(null,false);
                    }

                })
                .fail(function () {
                    alert('There was a problem communicating with the server. Please try again');
                })
                .always(function () {
                    $("#confirm-delete-message").dialog('close');
                });
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".confirm-deletion").live('click', function () {
        $("#client-delete").attr('rel', $(this).attr('rel'));
        $("#confirm-delete-message").dialog('open');
        return false;
    });


                    // Change Business Type
                    $("#groupChangeBusinessType").click(function () {
                        $('.businessType').val('');
                        $('.businessType').trigger("change");
                        $("#change-business-type").dialog('open');
                        $("#changeBusinessTypeNum").html($(".groupSelect:checked").length);
                        return false;
                    });

                    // proposal Business Type Update
                    $("#change-business-type").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            Save: {
                                'class': 'btn ui-button update-button',
                                text: 'Save',
                                click: function () {

                                    $("#changeBusinessTypeStatus").html('Updating Business Type, please wait...  <img src="/static/loading.gif" />');
                                    $.ajax({
                                        type: "POST",
                                        async: true,
                                        cache: false,
                                        data: {'ids': getSelectedIds(), businessType: $('.businessType').val()},
                                        url: "<?php echo site_url('ajax/groupProposalsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    }).success(function (data) {
                                        $("#changeBusinessTypeStatus").html('Done!');

                                        $("#change-business-type").dialog('close');
                                        swal('','Business Type Updated');
                                        $("#changeBusinessTypeStatus").html('');
                                        $("#groupActions").hide();
                                    });
                                }
                            },
                            Cancel: function () {
                                $(this).dialog('close');
                            }
                        },
                        autoOpen: false
                    });

    /**
     * Notes stuff here
     */
    // $("#notes").dialog({
    //     modal: true,
    //     buttons: {
    //         Close: function () {
    //             $(this).dialog("close");
    //         }
    //     },
    //     autoOpen: false,
    //     width: 700
    // });

    /**
     * proposal-events stuff here
     */
    $("#proposal-events").dialog({
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        width: 900,
        height:673
    });

    $("#proposalSignatureDialog").dialog({
        modal: true,
        buttons: {
            Save: {
                'class': 'btn ui-button update-button signature_save_btn',
                text: 'Save',
                click: function () {
                    if(check_signature_validation()){
                        var dataURL = false;

                        var tabId = $("#signature-tabs .ui-tabs-panel:visible").attr("id");
                        var signature_type = $("#signature_type").val();

                        if(tabId =='tabs-1'){
                            if (signaturePad.isEmpty()) {
                                $('.signature_msg').show();
                            }else{

                                $('.signature_msg').hide();

                                var dataURL = signaturePad.toDataURL();
                                $('#signature_url').val(dataURL);

                            }

                        }else if(tabId =='tabs-2'){
                            
                            if (document.getElementById("signature_file_input").files.length == 0){
                                console.log('profie tab2')
                                $('.signature_msg').show();
                            }else{
                                console.log('profie tab3')
                                var dataURL = $('#signature_url').val();
                            }
                        }else if(tabId =='tabs-3'){
                            
                            var sign_option = $('.sign_radio:checked').val();
                            if(sign_option && $('#signature_type_input').val()){
                                var dataURL = $('#signature_url').val();
                            }else {
                                $('.signature_msg').show();
                            }
                        }
                        
                        if (dataURL) {

                            swal({
                                title: 'Saving..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                  
                            })
                            $('#save_signature_loader').css('display', 'inline-block');
                            
                            var proposal_id = $('#signature_proposal_id').val();
                            var signature_title = $('#signature_title').val();
                            var signature_firstname = $('#signature_firstname').val();
                            var signature_lastname = $('#signature_lastname').val();
                            var signature_company = $('#signature_company_name').val();
                            var signature_email = $('#signature_email').val();
                            var signature_comments = $('#signature_comments').val();

                            var signature_address = $('#signature_address').val();
                            var signature_city = $('#signature_city').val();
                            var signature_state = $('#signature_state').val();
                            var signature_zip = $('#signature_zip').val();
                            var signature_cell_phone = $('#signature_cell_phone').val();
                            var signature_office_phone = $('#signature_office_phone').val();


                            if(signature_type =='single'){
                                
                                $.ajax({
                                    url: site_url + 'ajax/proposal_table_signature',
                                    type: "POST",
                                    data: {
                                        "signature": dataURL,
                                        "proposal_id": proposal_id,
                                        "signature_title": signature_title,
                                        "signature_firstname": signature_firstname,
                                        "signature_lastname": signature_lastname,
                                        "signature_company": signature_company,
                                        "signature_email": signature_email,
                                        "signature_comments": signature_comments,
                                        "signature_address": signature_address,
                                        "signature_city": signature_city,
                                        "signature_state": signature_state,
                                        "signature_zip": signature_zip,
                                        "signature_cell_phone": signature_cell_phone,
                                        "signature_office_phone": signature_office_phone,
                                    
                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        if (data.success) {
                                            $("#proposalSignatureDialog").dialog('close');
                                            swal('','Signature Saved');
                                            oTable.ajax.reload(null,false );
                                            $("#groupActions").hide();
                                        
                                        } else {
                                            if (data.error) {
                                                alert("Error: " + data.error);
                                            } else {
                                                alert('An error has occurred. Please try again later!')
                                            }
                                        }
                                    }
                                });
                            }else{
                                
                                var proposal_ids = getSelectedIds();
                                $.ajax({
                                    url: site_url + 'ajax/group_proposal_table_signature',
                                    type: "POST",
                                    data: {
                                        "signature": dataURL,
                                        "proposal_ids": proposal_ids,
                                        "signature_title": signature_title,
                                        "signature_firstname": signature_firstname,
                                        "signature_lastname": signature_lastname,
                                        "signature_company": signature_company,
                                        "signature_email": signature_email,
                                        "signature_comments": signature_comments,
                                        "signature_address": signature_address,
                                        "signature_city": signature_city,
                                        "signature_state": signature_state,
                                        "signature_zip": signature_zip,
                                        "signature_cell_phone": signature_cell_phone,
                                        "signature_office_phone": signature_office_phone,
                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        if (data.success) {

                                            var msg = data.signed_proposals+' Signature Saved<br/>';
                                            if(data.reject_permission_proposals){
                                                var msg = msg+data.reject_permission_proposals+' Signature don`t have permission to sign <br/>';
                                            }
                                            if(data.reject_signed_proposals){
                                                var msg = msg+data.reject_signed_proposals+' Signature already signed <br/>';
                                            }
                                            swal('',msg);
                                            $("#proposalSignatureDialog").dialog('close');
                                            oTable.ajax.reload(null,false );
                                            $("#groupActions").hide();
                                            
                                        
                                        } else {
                                            if (data.error) {
                                                alert("Error: " + data.error);
                                            } else {
                                                alert('An error has occurred. Please try again later!')
                                            }
                                        }
                                    }
                                });
                                
                            }
                        }else{
                            $('.signature_msg').show();
                        }
                    }
                }
            },
            Close: function () {
                $(this).dialog("close");
            }
        },
        open: function( event, ui ) {
            


            var signature_type = $("#signature_type").val();
            if(signature_type =='single'){
                $('.signatureInfoMsg').hide();
                swal({
                    title: '',
                    html: 'Getting Signee Details..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 20000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
                var proposal_id = $('#signature_proposal_id').val();
                $.ajax({
                    url: site_url + 'ajax/get_company_signee_details',
                    type: "POST",
                    data: {
                        
                        "proposal_id": proposal_id,

                    },
                    dataType: "json",
                    success: function (data) {
                        swal.close()
                        if (data.success) {
                            $('#signature_title').val(data.title);
                            $('#signature_firstname').val(data.firstname);
                            $('#signature_lastname').val(data.lastname);
                            $('#signature_company_name').val(data.company_name);
                            $('#signature_email').val(data.email);

                            $('#signature_address').val(data.address);
                            $('#signature_city').val(data.city);
                            $('#signature_state').val(data.state);
                            $('#signature_zip').val(data.zip);
                            $('#signature_cell_phone').val(data.cell_phone);
                            $('#signature_office_phone').val(data.office_phone);
                            check_signature_validation();
                        } else {
                            if (data.error) {
                                alert("Error: " + data.error);
                            } else {
                                alert('An error has occurred. Please try again later!')
                            }
                        }
                    }
                });
            }else{

                if(<?= ($account->isAdministrator())? 1 : 0;?>){
                    $('.signature_admin_permission_msg').hide();
                }else{
                    $('.signature_admin_permission_msg').show();
                }
                $('.signatureInfoMsg').show();
                $('#signature_title').val('');
                $('#signature_firstname').val('<?= urlencode($account->getFirstName());?>');
                $('#signature_title').val('<?= urlencode($account->getTitle());?>');
                $('#signature_lastname').val('<?= urlencode($account->getLastName());?>');
                $('#signature_company_name').val('<?= urlencode($account->getCompany()->getCompanyName());?>');
                $('#signature_email').val('<?=$account->getEmail();?>');

                $('#signature_address').val('<?= urlencode($account->getAddress());?>');
                $('#signature_city').val('<?= urlencode($account->getCity());?>');
                $('#signature_state').val('<?= urlencode($account->getState());?>');
                $('#signature_zip').val('<?= urlencode($account->getZip());?>');
                $('#signature_cell_phone').val('<?= urlencode($account->getCellPhone());?>');
                $('#signature_office_phone').val('');


                check_signature_validation();
            }

        },
        autoOpen: false,
        width: 900,
        height:600
    });

    //customer check list dialog start
    $("#customerChecklistDialog").dialog({
         modal: true,
        buttons: {
            Save: {
                'class': 'btn ui-button update-button customer_checklist_save_btn',
                text: 'Save',
                click: function () {
                    if(check_customer_checklist_validation()){
                        var dataURL = true;
                        
                        if (dataURL) {

                            swal({
                                title: 'Saving..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 10000,
                                onOpen: () => {
                                    swal.showLoading();
                                }
                            })
                            $('#save_signature_loader').css('display', 'inline-block');
                            
                            var proposal_id =      $('#billing_proposal_id').val();
                            var billing_contact = $('#billing_contact').val();
                            var billing_address = $('#billing_address').val();
                            var billing_phone = $('#billing_phone').val();
                            var billing_email = $('#billing_email').val();
                            var property_owner_name = $('#property_owner_name').val();
                            var legal_address = $('#legal_address').val();
                            var customer_phone = $('#customer_phone').val();

                            var customer_email = $('#customer_email').val();
                            var onsite_contact = $('#onsite_contact').val();
                            var onsite_phone = $('#onsite_phone').val();
                            var onsite_email = $('#onsite_email').val();
                            var invoicing_portal = $('#invoicing_portal').val();
                            var special_instruction = $('#special_instruction').val(); 
                                $.ajax({
                                    url: site_url + 'ajax/customer_billing_information',
                                    type: "POST",
                                    data: {
                                        "proposal_id": proposal_id,
                                        "billing_contact": billing_contact,
                                        "billing_phone": billing_phone,
                                        "billing_address": billing_address,
                                        "billing_email": billing_email,
                                        "property_owner_name": property_owner_name,
                                        "legal_address": legal_address,
                                        "customer_phone": customer_phone,
                                        "customer_email": customer_email,
                                        "onsite_contact": onsite_contact,
                                        "onsite_phone": onsite_phone,
                                        "onsite_email": onsite_email,
                                        "invoicing_portal": invoicing_portal,
                                        "special_instruction": special_instruction,
                                     
                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        console.log("dddata",data);
                                        if (data.success) {
                                            console.log("data",data);
                                            $("#customerChecklistDialog").dialog('close');
                                            swal('','Customer Checklist Saved');
                                            console.log("data2",data);

                                          
                                        } else {
                                            if (data.error) {
                                                alert("Error: " + data.error);
                                            } else {
                                                alert('An error has occurred. Please try again later!')
                                            }
                                        }
                                    }
                                });
                           
                        }else{
                            $('.signature_msg').show();
                        }
                    }
                }
            },
            Close: function () {
                $(this).dialog("close");
            }
        },
        open: function( event, ui ) {
            if(true){
                $(".PrintChecklist").hide();

                $('.signatureInfoMsg').hide();
                swal({
                    title: '',
                    html: 'Getting Signee Details..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 20000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
                var proposal_id =  $('#billing_proposal_id').val();
                $.ajax({
                    url: site_url + 'ajax/get_proposal_checklist_details',
                    type: "POST",
                    data: {
                        "proposal_id": proposal_id,
                    },
                    dataType: "json",
                    success: function (data) {
                        swal.close()
                        if (data.success) {
                            console.log("datassuccess",data.succes);
                            $(".PrintChecklist").show();
                            $('#billing_contact').val(data.billing_contact);
                            $('#billing_address').val(data.billing_address);
                            $('#billing_phone').val(data.billing_phone);
                            $('#billing_email').val(data.billing_email);
                            $('#property_owner_name').val(data.property_owner_name);
                            $('#legal_address').val(data.legal_address);
                            $('#customer_phone').val(data.customer_phone);
                            $('#customer_email').val(data.customer_email);
                            $('#onsite_contact').val(data.onsite_contact);
                            $('#onsite_phone').val(data.onsite_phone);
                            $('#onsite_email').val(data.onsite_email);
                            $('#invoicing_portal').val(data.invoicing_portal);
                            $('#special_instruction').val(data.special_instruction);
                            check_customer_checklist_validation();
                        }  
                    }
                });
            } 

        },
        autoOpen: false,
        width: 900,
        height:600
    });

    //customer check list dialog close


    $(".preview-proposal-events").live('click', function () {
        ev_proposal_id = $(this).attr('rel')
        get_events();

        $("<style id='height_style'>.timeline::after {height: "+$('#timeline_box')[0].scrollHeight +"px; }</style>").insertBefore("#timeline_box");

            $("#proposal-events").dialog('open');

    });

    $("#eventFilterButton").click(function () {

        $("#newProposalEventColumnFilters").toggle();

    });

    $('#selectAll').click(function(){
        $("input[name='event_show']").prop('checked', true);
        $.uniform.update();
        get_events();
    })

    $('#selectNone').click(function(){
        $("input[name='event_show']").prop('checked', false);
        $.uniform.update();
        get_events();
    })

    $('.event_show').click(function(){

        get_events()



  });


function get_events(){

//$('.proposal_events').hide();
var event_types = [];
$.each($("input[name='event_show']:checked"), function(){
  event_types.push($(this).val());
    });

    $.ajax({
        type: "POST",
        url: "<?php echo site_url('ajax/getProposalEventsByType') ?>",
        data: {
                        proposal_id: ev_proposal_id,
                        types : event_types
                    },
        dataType: 'json'
    })
        .done(function (data) {
          var events_html = '';
          var month ='';
              var year = '';
          if(data.success){
            var data = data.events;

            if(data.length>0){
              for($i=0;$i<data.length;$i++){
                var c_month = $.format.date(data[$i].created_at, "MMMM");
                    var c_year = $.format.date(data[$i].created_at, "yyyy");
                    if(month==c_month && year==c_year){}else{
                      events_html +='<p style="font-size:14px;padding-left: 60px;font-weight: bold;"><i class="fa fa-fw fa-calendar"></i> '+c_month+' '+c_year+'</p>';
                      month = c_month;
                      year = c_year;
                    }
                var date = $.format.date(data[$i].created_at, "MMM dd, yyyy h:mmp");


                  if(data[$i].fullName){
                    var user_name = data[$i].fullName;
                  }else{
                    var user_name = data[$i].user_name;
                  }
                  events_html +='<div class="container right " >'+
                  '<div class="content" style="padding-left: 5px;">'+
                  '<span style="float: left;margin-top: 20px;min-height: 50px;padding-right: 5px;"><i class="fa fa-2x fa-fw '+data[$i].type_icon+'"></i></span>'+
                  '<p><span style="font-size:13px;font-weight:bold;">'+date+'</span><span style="font-size:13px;font-weight:bold;float:right"><i class="fa fa-fw fa-user"></i> '+user_name+'</span></p>'+
                  '<p style="    margin-top: 10px;">'+data[$i].event_text+'.</p></div></div>';

              }

              $('#timeline').html(events_html);
              $('#height_style').remove();
              $("<style id='height_style'>.timeline::after {height: "+$('#timeline_box')[0].scrollHeight +"px;}</style>").insertBefore("#timeline_box");
            }else{
              $('#timeline').html('<h4 style="text-align:center">No Events</h4>');
            }
          }else{
            $('#timeline').html('<h4 style="text-align:center">No Events</h4>');
          }
        })
        .fail(function (xhr) {
            swal(
                'Error',
                'There was an error : ' + xhr.responseText
            );
        });




};

    $("#notes-client").dialog({
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        width: 700
    });


    $(".btn-notes, .view-notes").live('click', function () {
        var id = $(this).attr('rel');
        var frameUrl = '<?php echo site_url('account/notes/proposal') ?>/' + id;
        $("#notesFrame").attr('src', frameUrl);
        $("#relationId").val(id);
        $('#notesFrame').load(function () {
           var notes_content =  $("#notes").html();
           notes_content = notes_content.toString()

           notes_content = notes_content.replace(new RegExp('{add-note}', 'g'), 'add-note');
           notes_content = notes_content.replace(new RegExp('{noteText}', 'g'), 'noteText');
           notes_content = notes_content.replace(new RegExp('notesFrame', 'g'), 'newNotesFrame');

            swal({
                    title: "",
                    html:  notes_content,
                        showCancelButton: false,
                        confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                        cancelButtonText: "Cancel",
                        dangerMode: false,
                        width:700,
                        showCloseButton: true,
                        onOpen:  function() {

                            $('.swal2-modal').attr('id','proposal_notes_popup');
                            setTimeout(function(){
                                $('#noteText').focus();
                            },200);
                        }
                    }).then(function (result) {
                    }).catch(swal.noop)
        });
        return false;
    });
    $(".client-notes").live('click', function () {
        var id = $(this).attr('rel');
        var frameUrl = '<?php echo site_url('account/notes/client') ?>/' + id;
        $("#notesFrame-client").attr('src', frameUrl);
        $("#relationId-client").val(id);
        $('#notesFrame-client').load(function () {
            $("#notes-client").dialog('open');
        });
        return false;
    });

    $(document).on('submit', "#add-note", function (e) {

        e.preventDefault();
        var request = $.ajax({
            url: '<?php echo site_url('ajax/addNote') ?>',
            type: "POST",
            data: {
                "noteText": $("#noteText").val(),
                "noteType": 'proposal',
                "relationId": $("#relationId").val()
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    //refresh frame
                    $("#noteText").val('');
                    $('#newNotesFrame').attr('src', $('#notesFrame').attr('src'));
                    $('.hasNoNotes[rel="' + $("#relationId").val() + '"]').hide();
                    $('.hasNotes[rel="' + $("#relationId").val() + '"]').show();
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        });

        return false;
    });


    $(".add-notes-popup-btn").live('click', function (e) {
        e.preventDefault();

        $('#add-note').submit();
        return false;
    });

    $("#add-note-client").submit(function () {
        var request = $.ajax({
            url: '<?php echo site_url('ajax/addNote') ?>',
            type: "POST",
            data: {
                "noteText": $("#noteText-client").val(),
                "noteType": 'client',
                "relationId": $("#relationId-client").val()
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    //refresh frame
                    $("#noteText-client").val('');
                    $('#notesFrame-client').attr('src', $('#notesFrame-client').attr('src'));
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        });
        return false;
    });

    function resetDuplicateDialog() {
        $("#duplicate-selected-client").hide().find('strong').html('');
        $("#duplicate-select-client").show().find('input').val('');
        $(":button:contains('Duplicate')").prop("disabled", true).addClass("ui-state-disabled");
    }

    function resetCopyDialog() {
        $("#copy-selected-client").hide().find('strong').html('');
        $("#copy-select-client").show().find('input').val('');
        $(":button:contains('Copy')").prop("disabled", true).addClass("ui-state-disabled");
    }

    $("#duplicate-proposal").dialog({
        width: 550,
        modal: true,
        open: function () {
            //reset stuff
            resetDuplicateDialog();
        },
        buttons: {
            Duplicate: function () {
                var duplicate_estimate = $('#duplicate_estimate').is(":checked") ? '1' : '0';

                document.location.href = '<?php echo site_url('proposals/duplicate_proposal') ?>/' + $("#duplicate-proposal-id").val() + '/' + $("#duplicate-client-id").val()+'/0/'+duplicate_estimate+'/0/0/'+$('#duplicate_business_type_selectbox').val();
                $(this).dialog("close");
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $("#copy-proposal").dialog({
        width: 550,
        modal: true,
        open: function () {
            //reset stuff
            resetDuplicateDialog();
        },
        buttons: {
            Copy: function () {
                var copy_estimate = $('#copy_estimate').is(":checked") ? '1' : '0';
                document.location.href = '<?php echo site_url('proposals/copy') ?>/' + $("#copy-proposal-id").val() + '/' + $("#copy-client-id").val()+'/'+copy_estimate+'/'+$('#copy_business_type_selectbox').val();;
                $(this).dialog("close");
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".duplicate-proposal").live('click', function () {

        $("#duplicate_estimate").prop("checked", false);
        $("#duplicate-proposal-id").val($(this).attr('rel'));
        $("#duplicate_business_type_selectbox").val('').trigger('change');
        $('#duplicate-client').val('').trigger('change');
        $("#duplicate-client-id").val('');
        if($(this).attr('data-has-estimate')==0){
            $('#duplicate_estimate_chackbox').hide();
        }else{
            $('#duplicate_estimate_chackbox').show();
        }
        $('#duplicate_business_type_selectbox').val($(this).attr('data-business-type'));

        if($(this).attr('data-business-type')==0){
            $('#duplicate_business_type_selectbox_tr').show();
        }else{
            $('#duplicate_business_type_selectbox_tr').hide();
        }
        if(!$('#uniform-duplicate_business_type_selectbox').length){
            $('#duplicate_business_type_selectbox').uniform();
        }

        $("#duplicate-proposal").dialog('open');
        setTimeout(function() {
                        $('#duplicate-client').select2('open');
                        $(".select2-selection__placeholder").text('Search Contact')
                    }, 400);
        return false;
    });
    $(".copy-proposal").live('click', function () {
         $("#copy_estimate").prop("checked", false);
        $("#copy_business_type_selectbox").val('').trigger('change');
        $('#copy-client').val('').trigger('change');
        $("#copy-client-id").val('');
        resetCopyDialog();
        //$("#copy-client").select2();
        if($(this).attr('data-has-estimate')==0){
            $('#copy_estimate_chackbox').hide();
        }else{
            $('#copy_estimate_chackbox').show();
        }
        $("#copy-proposal-id").val($(this).attr('rel'));
        $('#copy_business_type_selectbox').val($(this).attr('data-business-type'));
        
        //handle deleted business type condition start
        var data_businessType_value =  $(this).attr('data-business-type');
         var available_bt = [];
            $('#copy_business_type_selectbox option').each(function() {
                // Parse the value to an integer
                var value = parseInt($(this).val());
                // Check if the parsed value is not NaN and push it to the array
                if (!isNaN(value)) {
                    available_bt.push(value);
                }
            });
         // handle deleted business type condition close         

        if($(this).attr('data-business-type')==0 || $.inArray(data_businessType_value, available_bt) === -1){
            $('#copy_business_type_selectbox_tr').show();
        }else{
            $('#copy_business_type_selectbox_tr').hide();
        }
        if(!$('#uniform-copy_business_type_selectbox').length){
            $('#copy_business_type_selectbox').uniform();
        }
        $("#copy-proposal").dialog('open');

        setTimeout(function() {
                        $('#copy-client').select2('open');
                        $(".select2-selection__placeholder").text('Search Contact')
                    }, 400);
        return false;
    });


//Select2 start

$("#duplicate-client").select2({
  ajax: {
    url: '<?php echo site_url('ajax/ajaxSelect2SearchClients') ?>',
    dataType: 'json',
    delay: 250,

    data: function (params) {
      return {
        startsWith: params.term, // search term
        //firstName: $("#firstName").val(),
        lastName: $("#duplicate-client-last-name").val(),
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a repository',
  allowClear: true,
  debug: true,
  minimumInputLength: 1,
  templateResult: formatRepoDup,
  templateSelection: formatRepoSelectionDup
});

function formatRepoDup (repo) {
  if (repo.loading) {
    return repo.label;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +

      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Account:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Contact:</th><td class='select2-result-repository_contact'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Address:</th><td class='select2-result-repository_address'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Proposals:</th><td class='select2-result-repository_proposal'></td></tr>"+
      "</div>" +
    "</div>"
  );

  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_contact").text(repo.contact);
  $container.find(".select2-result-repository_address").html(repo.address);
  $container.find(".select2-result-repository_proposal").html(repo.proposals_count);

  return $container;
}

function formatRepoSelectionDup (repo) {
  return repo.label ;
}

$('#duplicate-client').on("select2:selecting", function(e) {
   // what you would like to happen
   var select_id = e.params.args.data.id;
   var select_label = e.params.args.data.label
   //$("#tiptip_holder").fadeOut('fast');
    $("#duplicate-client-id").val(select_id);
    $("#duplicate-selected-client").find('strong').html(select_label);

    validate_duplicate_proposal_popup();
    //$(":button:contains('Duplicate')").prop("disabled", false).removeClass("ui-state-disabled");

});

$("#duplicate_business_type_selectbox").on('change', function () {
    validate_duplicate_proposal_popup();
    });
function validate_duplicate_proposal_popup(){
    var client_id = $("#duplicate-client-id").val();
    var business_type = $("#duplicate_business_type_selectbox").val();
    if(client_id !='' && business_type !=''){
        $("#duplicate-selected-client").show();
        $("#duplicate-select-client").hide();
        $(":button:contains('Duplicate')").prop("disabled", false).removeClass("ui-state-disabled");
    }
}

//Select2 end


    $("#duplicate-client11").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?php echo site_url('ajax/ajaxSearchClients') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    maxRows: 12,
                    startsWith: request.term,
                    lastName: $("#duplicate-client-last-name").val()
                },
                success: function (data) {
                    response($.map(data, function (item) {
                            return {
                                label: item.label,
                                value: item.value
                            }
                        }
                    ));
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            $("#tiptip_holder").fadeOut('fast');
            $("#duplicate-client-id").val(ui.item.value);
            $("#duplicate-selected-client").show().find('strong').html(ui.item.label);
            $("#duplicate-select-client").hide();
            $(":button:contains('Duplicate')").prop("disabled", false).removeClass("ui-state-disabled");
            event.preventDefault();
        },
        open: function () {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });


//Select2 start

$("#copy-client").select2({
   ajax: {
    url: '<?php echo site_url('ajax/ajaxSelect2SearchClients') ?>',
    dataType: 'json',
    delay: 250,

    data: function (params) {
     
      return {
        startsWith: params.term, // search term
        //firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a repository',
  allowClear: true,
  debug: true,
  minimumInputLength: 1,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +

      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Account:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Contact:</th><td class='select2-result-repository_contact'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Address:</th><td class='select2-result-repository_address'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Proposals:</th><td class='select2-result-repository_proposal'></td></tr>"+

      "</div>" +
    "</div>"
  );

  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_contact").text(repo.contact);
  $container.find(".select2-result-repository_address").html(repo.address);
  $container.find(".select2-result-repository_proposal").html(repo.proposals_count);

  return $container;
}

function formatRepoSelection (repo) {
  return repo.label ;
}

$('#copy-client').on("select2:selecting", function(e) {
   // what you would like to happen
   var select_id = e.params.args.data.id;
   var select_label = e.params.args.data.label
   $("#tiptip_holder").fadeOut('fast');
    $("#copy-client-id").val(select_id);
    $("#copy-selected-client").find('strong').html(select_label);
    validate_copy_proposal_popup();
});

$("#copy_business_type_selectbox").on('change', function () {
    validate_copy_proposal_popup();
    });
function validate_copy_proposal_popup(){
    var client_id = $("#copy-client-id").val();
    var business_type = $("#copy_business_type_selectbox").val();
    if(client_id !='' && business_type !=''){

        $("#copy-selected-client").show();
        $("#copy-select-client").hide();
        $(":button:contains('Copy')").prop("disabled", false).removeClass("ui-state-disabled");
    }
}

//Select2 end

    $("#copy-client22").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?php echo site_url('ajax/ajaxSearchClients') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    maxRows: 12,
                    startsWith: request.term,
                    lastName: $("#copy-client-last-name").val()
                },
                success: function (data) {
                    response($.map(data, function (item) {
                            return {
                                label: item.label,
                                value: item.value
                            }
                        }
                    ));
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            $("#tiptip_holder").fadeOut('fast');
            $("#copy-client-id").val(ui.item.value);
            $("#copy-selected-client").show().find('strong').html(ui.item.label);
            $("#copy-select-client").hide();
           $(":button:contains('Copy')").prop("disabled", false).removeClass("ui-state-disabled");
            event.preventDefault();
        },
        open: function () {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
    $("#reset-duplicate-client-search").click(function () {
        resetDuplicateDialog();
    });
    $("#reset-copy-client-search").click(function () {
        resetCopyDialog();
    });


    //view client details functionality

    $("#dialog-message").dialog({
        width: 500,
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        beforeClose: function (event, ui) {
            $("#dialog-message span").html('');
        }
    });
    $('.viewClient').live('click', function () {
        var clientId = $(this).attr('rel');
        $.getJSON("<?php echo site_url('ajax/getClientData') ?>/" + clientId, function (data) {
            var items = [];
            $.each(data, function (key, val) {
                $("#field_" + key).html(val);
            });
        });
        $("#dialog-message").dialog("open");
    });

    /* Check that at least one proposal has been selected */
    function checkProposalsSelected() {
        var num = $(".groupSelect:checked").length;
        if (num > 0) {
            return true;
        }
        $("#no-proposals-selected").dialog('open');
        return false;
    }

    /* get a list of the selected IDs */
    function getSelectedIds() {
        var IDs = new Array();
        $(".groupSelect:checked").each(function () {
            IDs.push($(this).data('proposal-id'));
        });
        return IDs;
    }

    function getAllIds() {
        var IDs = new Array();
        $(".groupSelect").each(function () {
            if ($(this).data('proposal-id')) {
                IDs.push($(this).data('proposal-id'));
            }
        });
        return IDs;
    }

    $("#sendExcludedEmail").click(function () {
        var include_count =0;
        if($('#sendExcludedEmail').prop("checked")){
            $(".preconfirm-resend-btn").prop('disabled',false);
            $(".preconfirm-resend-btn").removeClass('ui-state-disabled');
            $("#resendIncludeNum").html($(".groupSelect:checked").length);
        }else{
            $(".groupSelect:checked").closest('tr').each(function(){
                if($(this).find('.proposalsTableDropdownToggle').attr('data-proposal-excluded')!=1)
                {
                    include_count += 1;
                }

            })
            $("#resendIncludeNum").html(include_count);
            if(include_count==0){
                $(".preconfirm-resend-btn").prop('disabled',true);
                $(".preconfirm-resend-btn").addClass('ui-state-disabled');
            }
        }
    });
    /*
     RESEND
     */

    $("#groupResend").click(function () {
        var proceed = checkProposalsSelected();

        if (proceed) {

            var proposals_selected = getSelectedIds();
            if(proposals_selected.length > 500){
                swal('','Please select maximum 500 Proposals');
                return false;
            }

            var exclude_count = 0;
            var include_count = 0;

            $(".groupSelect:checked").closest('tr').each(function(){
                if($(this).find('.proposalsTableDropdownToggle').attr('data-proposal-excluded')==1)
                {
                    exclude_count += 1;
                }
                else
                {
                    include_count += 1;
                }
            })
            $("#sendExcludedEmail").prop('checked', false);

            if(exclude_count>0){
                $(".preconfirm-resend-btn").prop('disabled',false);
                $(".preconfirm-resend-btn").removeClass('ui-state-disabled');
                $("#resendExcludeNum").html(exclude_count);
                $("#resendIncludeNum").html(include_count);
                $("#resendNum").html($(".groupSelect:checked").length);
                $("#preconfirm-resend-proposals").dialog('open');
                if(include_count==0){
                    $(".preconfirm-resend-btn").prop('disabled',true);
                    $(".preconfirm-resend-btn").addClass('ui-state-disabled');
                }
                
            }else{
                $("#resend-proposals").dialog('open');
                $('.new_resend_name_span').show();
                $(".no_campaign").show();
                $('#messageFromName').prop('disabled', false);
                $('#messageFromEmail').prop('disabled', false);
                $('#messageSubject').prop('disabled', false);
                $('#templateSelect').prop('disabled', false);
                $('.is_templateSelect_disable').hide();
                $('#emailCustom').prop('disabled', false);
                
                $("#resendSelect").val(0)
                $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>')

                $("#resendSelect").trigger('change')
                $("#emailCC").prop('checked', false);
                if (!popup_ui) {

                    $('#templateSelect').uniform();
                    $('#resendSelect').uniform();
                    $('#templateFields').uniform();
                    $('#emailCC').uniform();
                    $('#emailCustom').uniform();
                    popup_ui = true;
                }
                get_resend_lists();

            }
            $('.groupActionsContainer').hide();
        }





        return false;
    });

   // $(document).on('click', ".bouncedGroupResend", function () {
    $(".bouncedGroupResend").click(function () {
     var resend_id = $(this).attr('data-resend-id');
     var proposals_selected = getSelectedIds();
    $('#bounced_campaign_id').val(resend_id);
    bounced_campaign_id
    $.ajax({
                    url: '/ajax/get_resend_bounced_counts_details/',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "resend_id": resend_id,
                        
                    },

                    success: function (data) {
                        if (data.success) {
                            if(data.total_resending>0){
                                var proposals_selected = getSelectedIds();
                                
                                total_resending_msg = ' bounced';
                                    total_unopend_msg = ' email(s) were sent but not delivered';
                                $('#bounced_totalNum').text(data.total_proposals);
                                $('#bounced_count_msg').text('- '+data.total_bounced+total_unopend_msg);
                                $('#bounced_resendNum').text(proposals_selected.length+ total_resending_msg);
                                
                                $("#bounced-resend-proposals").dialog('open');
                            }else{
                                
                                    swal('','This Campaign has no Bounced Proposals!');
                                
                                
                                return false;
                            }
               
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
})


 // Resend bounced dialog
 $("#bounced-resend-proposals").dialog({
            width: 550,
            modal: true,
           
            buttons: {
                "Resend": {
                    text: 'Send Email',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmResend',
                    click: function () {

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                
                                'campaign_id': $("#bounced_campaign_id").val(),
                                'proposal_ids':getSelectedIds(),
                            },
                            url: "<?php echo site_url('ajax/groupResendBouncedProposals') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                var resendText = '';

                                if (data.success) {

                                    resendText = 'Your Emails are being sent';

                                }
                                else {
                                    resendText = 'An error occurred. Please try again';
                                }
                                $("#resendProposalsStatus").html(resendText);
                                $("#resend-proposals-status").dialog('open');

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
   

    // No proposals dialog
    $("#no-proposals-selected").dialog({
        width: 500,
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });


    // Proposal Resend options
    $("#emailCustom").change(function () {
        if ($("#emailCustom").attr('checked')) {
            $(".emailFromOption").show();
        }
        else {
            $(".emailFromOption").hide();
            $(".emailFromOption input").val('');
        }
    });

    // Resend dialog
    $("#resend-proposals").dialog({
        width: 950,
        modal: true,
        open: function () {
            tinymce.remove()
            $("#emailCustom").attr('checked', false);
            $(".emailFromOption").hide();

            tinymce.init({
                    selector: "textarea#message",
                    menubar: false,
                    relative_urls : false,
                    elementpath: false,
                    remove_script_host : false,
                    convert_urls : true,
                    browser_spellcheck : true,
                    contextmenu :false,
                    paste_as_text: true,
                    height:'320',
                    plugins: "link image code lists paste preview",
                    toolbar: tinyMceMenus.email,
                    forced_root_block_attrs: tinyMceMenus.root_attrs,
                    fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px",
                    content_css: '/static/css/tinymce-custom.css',
                    paste_as_text: true
            });

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

                    if($('#resendSelect').val()==0 && !$('.new_resend_name').val()){
                        alert('Please enter Resend Name');
                            return false;
                    }

                    if($("#messageSubject").val() ==''){
                        alert('Please enter Subject');
                            return false;
                    }

                    if(tinyMCE.activeEditor.getContent() ==''){
                        alert('Please enter Email Content');
                            return false;
                    }

                    // Make sure the undent is hidden
                    $("#unsentProposals").hide();
                    $("#unsentDetails").hide();
                    $("#alreadyProposals").hide();
                    $("#bouncedProposals").hide();
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'emailCC': $("#emailCC").is(":checked"),
                            'subject': $("#messageSubject").val(),
                            'fromName': $("#messageFromName").val(),
                            'fromEmail': $("#messageFromEmail").val(),
                            'resendId': $("#resendSelect").val(),
                            'new_resend_name': $(".new_resend_name").val(),
                            'body': tinyMCE.activeEditor.getContent(),
                            'proposal_filter':proposal_filter,
                            'exclude_override' : $('#sendExcludedEmail').prop("checked") ? 1 : 0 ,
                        },
                        url: "<?php echo site_url('ajax/groupResend') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            var resendText = '';

                            if (data.success) {

                                //resendText = '<strong>'+ data.count + '</strong> proposal emails were sent';
                                resendText = 'Your Emails are being sent';


                            }
                            else {
                                resendText = 'An error occurred. Please try again';
                            }

                            $("#resendProposalsStatus").html(resendText);
                            $("#resend-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#resendProposalsStatus").html('Sending proposal mails...<img src="/static/loading.gif" />');
                    $("#resend-proposals-status").dialog('open');
                }
            },
            Cancel: {
                text: 'Cancel',
                'class': 'btn ui-button left',

                click: function () {
                    $(this).dialog("close");
                }
            }
        },
        autoOpen: false
    });

    // Price Modify
    $("#price-modifier-dialog").dialog({
        width: 450,
        modal: true,
        autoOpen: false,
        buttons: {
            "Apply": {
                html: '<i class="fa fa-fw fa-refresh"></i> Apply',
                'class': 'btn ui-button update-button',
                'id': 'applyPriceModify',
                click: function () {
                    swal({
                        title: 'Updating..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 10000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    var modifier = $("#priceModifierValue").val();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'modifier': modifier
                        },
                        url: "<?php echo site_url('ajax/modifyPrices') ?>",
                        dataType: "JSON"
                    })
                    .success(function (data) {

                        $("#price-modifier-dialog").dialog('close');

                        if(!data.error) {
                            swal('',"We are updating your prices. This may take a minute or two. Please be patient and we'll let you know when this is complete");
                            oTable.ajax.reload(null,false);
                            updateNumSelected();
                        } else {
                            swal('An error occurred');
                        }

                        $(".groupActionsContainer").hide();
                    });

                }
            },
            "Cancel": {
                html: '<i class="fa fa-fw fa-close"></i> Cancel',
                'class': 'btn ui-button',
                'id': 'cancelModify',
                click: function () {
                    $(".groupActionsContainer").hide();
                    $(this).dialog('close');
                }
            }
        }
    });

    // Price Modify Click
    $("#groupPriceModify").click(function() {
        // Reset the modifier value
        $("#priceModifierValue").val('0.00');
        // Show the dialog
       $("#price-modifier-dialog").dialog('open');
    });

    // Resend text editor
    $(document).ready(function () {


        // var template_editor = CKEDITOR.replace('message', {
        //     toolbar: [
        //                     { name: 'styles', items: [ 'Font', 'FontSize' ] },
        //                     { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        //                     { name: 'editing', groups: ['spellcheck' ], items: ['jQuerySpellChecker'] },
        //                     { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','-', 'RemoveFormat' ] },
        //                     { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
        //                     { name: 'links', items: [ 'Link', 'Unlink' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
        //                     [ 'Cut', 'Copy', 'Paste', 'PasteText' ],			// Defines toolbar group without name.
        //                     '/',																					// Line break - next group will be placed in new line.
	    //                 ],
        //     height: 200
        // });
    });

    /*
     * Group Actions Auto Re-Send START
     * All code below
     */

    //
    $("#groupResendSettings").on('click', function () {
        //reset form
        $("#automatic_resend").val(0);
        $("#frequency").val('<?= round($proposal_resend_frequency / 86400) ?>');
        $("#template").val(<?= $automatic_reminders_template ?>);
        //pop modal
        $("#groupResendSettingsModal").dialog("open");
    });

    $("#groupResendSettingsModal").dialog({
        width: 700,
        modal: true,
        open: function () {
            $("#emailCustom").attr('checked', false);
            $(".emailFromOption").hide();
            $.uniform.update();
        },
        buttons: {
            "Save": {
                text: 'Save',
                'class': 'btn ui-button update-button',
                'id': 'confirmResend',
                click: function () {
                    var frequency = $("#frequency").val();
                    if (isNaN(frequency) || frequency < 1) {
                        frequency = 1;
                    }
                    var data = {
                        ids: getSelectedIds(),
                        enabled: $("#automatic_resend").val(),
                        frequency: frequency,
                        template: $("#template").val()
                    };
                    //alert('Post Data: ' + JSON.stringify(data));
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('proposals/saveResendSettingsGroup') ?>",
                        data: data,
                        success: function () {
                            swal('success', 'Proposals Auto Re-Send Settings Updated!');
                            $("#groupResendSettingsModal").dialog("close");
                        },
                        error: function () {
                            swal('warning', 'There was an error processing the request. Please try again later.');
                        }
                    });
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    /*Group Actions Auto Re-Send END*/

    // Template change handler
    $('#templateSelect').change(function () {

        var selectedTemplate = $('#templateSelect option:selected').data('template-id');
        loadTemplateContents(selectedTemplate);
    });

    // Load the selected content
    var defaultTemplate = $('#templateSelect option:selected').data('template-id');
    //loadTemplateContents(defaultTemplate);

    function loadTemplateContents(templateId) {

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {'templateId': templateId},
            url: "<?php echo site_url('account/ajaxGetClientTemplateRaw') ?>?" + Math.floor((Math.random() * 100000) + 1),
            dataType: "JSON"
        })
            .success(function (data) {

                $("#messageSubject").val(data.templateSubject);
                //CKEDITOR.instances.message.setData(data.templateBody);
                tinymce.activeEditor.setContent(data.templateBody);
                // var select_html = '<option value="0">- Select Field</option>';
                //  for($i=0;$i<data.typeFields.length;$i++) {
                //     select_html +='<option value=""></option>
            });

        $.uniform.update();
    }

    // Proposal Resend Update
    $("#resend-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

    // Proposal Resend pre Confirm
    $("#preconfirm-resend-proposals").dialog({
        width: 400,
        modal: true,
        buttons: {
            OK: {
                text: 'Continue',
                'class': 'btn ui-button update-button preconfirm-resend-btn',
                click: function () {
                    $(this).dialog("close");
                    $("#resend-proposals").dialog('open');
                    $('.new_resend_name_span').show();
                    $(".no_campaign").show();
                    $('#messageFromName').prop('disabled', false);
                    $('#messageFromEmail').prop('disabled', false);
                    $('#messageSubject').prop('disabled', false);
                    $('#templateSelect').prop('disabled', false);
                    $('.is_templateSelect_disable').hide();
                    $('#emailCustom').prop('disabled', false);
                    //CKEDITOR.instances.message.setReadOnly(false);
                    //$('#templateSelect').trigger('change');
                    $("#resendSelect").val(0)
                    $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>')

                    $("#resendSelect").trigger('change')
                    $("#emailCC").prop('checked', false);
                    if (!popup_ui) {

                        $('#templateSelect').uniform();
                        $('#resendSelect').uniform();
                        $('#templateFields').uniform();
                        $('#emailCC').uniform();
                        $('#emailCustom').uniform();
                        popup_ui = true;
                    }
                    get_resend_lists();
                }
            },
            
            Cancel: {
                    text: 'Cancel',
                    'class': 'btn ui-button left',

                    click: function () {
                        $(this).dialog("close");
                    }
                }
        },
        autoOpen: false
    });

    /*
     DELETE
     */


    $("#groupDelete").click(function () {

        var proceed = checkProposalsSelected();

        if (proceed) {
            $("#deleteNum").html($(".groupSelect:checked").length);
            $("#delete-proposals").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    // Resend dialog
    $("#delete-proposals").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Delete": {
                text: 'Delete Proposals',
                'class': 'btn ui-button update-button',
                'id': 'confirmDelete',
                click: function () {

                    var deleteDuplicates = ($("#deleteDuplicates").prop("checked")) ? 1 : 0;

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'deleteDuplicates': deleteDuplicates
                        },
                        url: "<?php echo site_url('ajax/groupDelete') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                if(data.is_demo){
                                    var resendText = data.count + ' proposals were deleted <br/>'+data.demo+' demo proposals not deleted';
                                }else{
                                    var resendText = data.count + ' proposals were deleted';
                                }

                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#deleteProposalsStatus").html(resendText);
                            $("#delete-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#deleteProposalsStatus").html('Deleting proposals...<img src="/static/loading.gif" />');
                    $("#delete-proposals-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        open: function () {
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {'ids': getSelectedIds()},
                url: "<?php echo site_url('ajax/containsDuplicates') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
                .success(function (data) {
                    if (data.duplicates > 0) {
                        $('#deleteDuplicatesOption').show();
                    }
                    else {
                        $('#deleteDuplicatesOption').hide();
                    }
                });
        }
    });

    // Proposal Status Update
    $("#delete-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                if($('.reload_table').length){
                    $('#child_resend').trigger('change');
                }else{
                    oTable.ajax.reload(null,false);
                }

            }
        },
        autoOpen: false
    });


    $("#groupChangeStatus").click(function () {

        // Hide the win date options
        $("#statusWin").hide();
        // Reset to open
        $("#changeStatus").val(1);
        $.uniform.update();

        var proceed = checkProposalsSelected();

        if (proceed) {

            var statusChangeNum = $(".groupSelect:checked").length;
            var unwonCount = $('.groupSelect[data-won="0"]:checked').length;
            var wonCount = $('.groupSelect[data-won="1"]:checked').length;

            $("#statusChangeNum").text(statusChangeNum);
            $("#statusUnwonCount").text(unwonCount);
            $("#statusWonCount").text(wonCount);
            $("#status-proposals").dialog('open');
            $("#changeStatus").trigger('change');
        }
        $('.groupActionsContainer').hide();
    });

    $("#changeStatus").change(function() {

        if ($(this).find('option:selected').data('sales')) {
            var unwonCount = $('.groupSelect[data-won="0"]:checked').length;

            if (unwonCount > 0) {
                $("#statusWin").show();
            }
            $("#statusUnwin").hide();
        }
        else {
            var wonCount = $('.groupSelect[data-won="1"]:checked').length;
            $("#statusWin").hide();
            if (wonCount > 0) {
                $("#statusUnwin").show();
            }

        }
    });

    // Status dialog
    $("#status-proposals").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Update": {
                text: 'Update Proposals',
                'class': 'btn ui-button update-button',
                'id': 'confirmStatus',
                click: function () {
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'status': $("#changeStatus").val(),
                            'statusWinDate' : $("#statusWinDate").val()
                        },
                        url: "<?php echo site_url('ajax/groupStatusChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"

                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#statusProposalsStatus").html(resendText);
                            $("#status-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#statusProposalsStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#status-proposals-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // Proposal Delete Update
    $("#status-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

    // Unduplicate
    $("#groupUnduplicate").click(function () {
        $("#status-unduplicate").dialog('open');
        $('.groupActionsContainer').hide();
    });

    $("#status-unduplicate").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {'ids': getSelectedIds()},
                        url: "<?php echo site_url('ajax/groupStandalone') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#standaloneStatus").html(resendText);
                            $("#standalone-status").dialog('open');

                        });

                    $(this).dialog('close');
                    $("#standaloneStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#standalone-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $("#standalone-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

    /* Status Date Change */

    $("#sdcDate").datepicker();

    $("#groupStatusChangeDate").click(function () {
        $("#status-date-change-confirm").dialog('open');
        $('.groupActionsContainer').hide();
    });


    $("#status-date-change-confirm").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var changeDate = $("#sdcDate").val();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'changeDate': changeDate
                        },
                        url: "<?php echo site_url('ajax/groupStatusDateChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#sdcStatus").html(resendText);
                            $("#sdc-status").dialog('open');

                        });

                    $(this).dialog('close');
                    $("#sdcStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#sdc-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $("#sdc-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

    $("#swdc-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

    $("#win-date-none-change").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Ok',
                'class': 'btn ui-button blue-button',
                click: function () {
                    $(this).dialog('close');

                }
            },

        },
        autoOpen: false
    });





    // Creation Date change
    $("#wdcDate").datepicker({'maxDate':0});

    $("#groupChangeWinDate").click(function () {
        var total_sales_status = 0;
        $('.win-date-check-msg').html('');
        $('.win-date-check-msg').hide();
        $(".groupSelect:checked").each(function () {
            if($(this).data('is-sales')){
                total_sales_status++
            }
        });
        var total_selected = $(".groupSelect:checked").length;
        var not_update_count = total_selected - total_sales_status;

        if(total_sales_status == 0){

            $("#win-date-none-change").dialog('open');
            $('.groupActionsContainer').hide();
            return false;
        }else if(not_update_count > 0){
            $('.win-date-check-msg').html('<i class="fa fa-fw fa-info-circle"></i> <strong>'+not_update_count+'</strong> Proposals selected do not have a "Won" status and will not be updated.')
            $('.win-date-check-msg').show();
        }


        $("#win-date-change-confirm").dialog('open');
        $('.groupActionsContainer').hide();
    });

    $("#win-date-change-confirm").dialog({
        width: 550,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var changeDate = $("#wdcDate").val();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'changeDate': changeDate
                        },
                        url: "<?php echo site_url('ajax/groupWinDateChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#swdcStatus").html(resendText);
                            $("#swdc-status").dialog('open');

                        });

                    $(this).dialog('close');
                    $("#swdcStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#swdc-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });



    // Creation Date change
    $("#dcDate").datepicker();

    $("#groupChangeDate").click(function () {
        $("#date-change-confirm").dialog('open');
        $('.groupActionsContainer').hide();
    });

    $("#date-change-confirm").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var changeDate = $("#dcDate").val();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'changeDate': changeDate
                        },
                        url: "<?php echo site_url('ajax/groupDateChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#sdcStatus").html(resendText);
                            $("#sdc-status").dialog('open');

                        });

                    $(this).dialog('close');
                    $("#sdcStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#sdc-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $("#dc-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

        // Creation Date change
        $("#linkdcDate").datepicker();


$(document).on("click", ".set_expiry", function (e) {
    $("#expiry_proposal_id").val($(this).attr('data-proposal-id'));
    $("#expiry_preview_id").val($(this).attr('data-preview-id'));
    $("#link-date-change-confirm").dialog('open');

});


$("#link-date-change-confirm").dialog({
    width: 500,
    modal: true,
    buttons: {
        OK: {
            'text': 'Continue',
            'class': 'btn ui-button update-button',
            click: function () {

                var expiryDate = $("#linkdcDate").val();
                var expiry_preview_id = $("#expiry_preview_id").val();

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'expiry_preview_id': expiry_preview_id,
                        'expiryDate': expiryDate
                    },
                    url: "<?php echo site_url('ajax/set_proposal_preview_expiry') ?>?" + Math.floor((Math.random() * 100000) + 1),
                    dataType: "JSON"
                })
                    .success(function (data) {

                        if (data.succes) {
                            swal('', 'Preview Expiry Set');
                            showProposalLinksDataTable.ajax.reload(null, false);
                        } else {
                            swal('', 'An error occurred. Please try again');

                        }

                        $("#link-date-change-confirm").dialog('close');
                    });

            }
        },
        Cancel: function () {
            $(this).dialog('close');
        }
    },
    autoOpen: false
});

    /* Reassigning */

    // Reassign dialog
    $("#reassign-proposals").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Update": {
                text: 'Reassign',
                'class': 'btn ui-button update-button',
                'id': 'confirmReassign',
                click: function () {
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {'ids': getSelectedIds(), 'userId': $("#reassignUser").val()},
                        url: "<?php echo site_url('ajax/groupProposalReassign') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"

                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#reassignProposalsStatus").html(resendText);
                            $("#reassign-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#reassignProposalsStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#reassign-proposals-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // Reassign Status Dialog
    $("#reassign-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

    // Handle the click
    $("#groupReassign").click(function () {
        $("#reassign-proposals").dialog('open');
        $('.groupActionsContainer').hide();
    });

    // ProposalActivity Dialog
    $("#proposalActivity").dialog({
        width: 800,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false,
        position: 'top',
        open: function(event, ui) {
            $(this).parent().css({'top': window.pageYOffset + 150});
        },
    });


    // Copy to contact - Dialog
    $("#copy-to-contact-dialog").dialog({
        width: 500,
        modal: true,
        buttons: [
            {
                text: 'Copy Proposals',
                id: "copyProposalToClientBtn",
                class: 'btn update-button',
                click: function() {
                    $("#copy-to-contact-dialog").dialog('close');
                    swal('', 'Copying Proposals...');

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            ids: getSelectedIds(),
                            statusId: $("#copyToContactStatus").val()
                        },
                        url: "<?php echo site_url('proposals/groupCopyToContact') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                    .success(function (data) {
                        swal.close();
                        swal('', 'Proposals Copied');
                        oTable.ajax.reload(null,false);
                    });
                    $(this).dialog('close');
                }
            },
            {
                text: 'Cancel',
                class: 'btn left',
                click: function() {
                    $(this).dialog('close');
                }
            }
        ],
        autoOpen: false
    });

    $("#proposalPreviewDialog").dialog({
        modal: true,
        autoOpen: false,
        open: function(event, ui) {
            // Reset Dialog Position
            if(isTouchDevice()){
                $(this).dialog('widget').position({ my: "top", at: "bottom", of: '#menu-accounts' });
            }else{
                $(this).dialog('widget').position({my: "center", at: "center", of: window});
            }
            
        },
    });



    // Copy to Contact - Click
    $("#groupCopySameClient").click(function () {
        $("#copy-to-contact-dialog").dialog('open');
        $("#copyChangeNum").text(getSelectedIds().length);
        $('.groupActionsContainer').hide();
    });

     // Copy to contact - dialog click
     $("#copyProposalToClientBtn").click(function() {

        var ids = getSelectedIds();
        var statusId = $("#copyToContactStatus").val();

        return false;
    });


    function getUndeliveredIds() {
        var IDs = new Array();
        $(".noDelivery").each(function () {
            IDs.push($(this).data('proposal_id'));
        });
        return IDs;
    }

    // Check delivery status
    /*
    setInterval(function () {

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {'ids': getUndeliveredIds()},
            url: "<?php echo site_url('ajax/deliveryStatus') ?>?" + Math.floor((Math.random() * 100000) + 1),
            dataType: "JSON"
        })
            .success(function (data) {
                $.each(data, function (index, value) {
                    $('#noDelivery_' + index).html('<span class="badge blue tiptipleft" title="Delivered: ' + value + '">D</span>')
                });
                initTiptip();
            });
    }, 15000);
    */


    function applyFilter() {

        if (clearPreset) {
            $(".proposalFilterPreset").addClass('grey');
        }
        else {
            clearPreset = true
        }

        $("#filterResults").css('visibility', 'hidden');
        $("#filterLoading").show();

        if (firstRun) {
            initProposalTable();
        }

        setTimeout(function () {
            $("#reset-filter").show();

            var statuses = [];
            var statusValues = [];
            if ($(".statusFilterCheck:checked").not('.prospectStatusFilterCheck').length != $(".statusFilterCheck").not('.prospectStatusFilterCheck').length) {
                statuses = $(".statusFilterCheck:checked").map(function () {
                    statusValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                 $('.filterColumnCheck[data-affected-class="statusFilterCheck"]').prop("checked",false);

            }else{

                $('.filterColumnCheck[data-affected-class="statusFilterCheck"]').prop("checked",true);

            }


                    if ($(".otherFilterCheck:checked").length != $(".otherFilterCheck").length) {
                      
                        $('.filterColumnCheck[data-affected-class="otherFilterCheck"]').prop("checked",false);

                    }else{

                        $('.filterColumnCheck[data-affected-class="otherFilterCheck"]').prop("checked",true);

                    }
            if (!statuses.length) {
                statuses = [];
            }

            // Proposal BusinessTypes
            var proposalBusinessTypes = [];
                    var proposalBusinessTypeValues = [];

                    if ($(".businessTypeFilterCheck:checked").length != $(".businessTypeFilterCheck").length) {
                        proposalBusinessTypes = $(".businessTypeFilterCheck:checked").map(function () {
                            proposalBusinessTypeValues.push($(this).attr('data-text-value'));
                            return $(this).val();
                        }).get();
                        $('.filterColumnCheck[data-affected-class="businessTypeFilterCheck"]').prop("checked",false);

                    }else{

                        $('.filterColumnCheck[data-affected-class="businessTypeFilterCheck"]').prop("checked",true);

                    }

                    if (!proposalBusinessTypes.length) {
                        proposalBusinessTypes = [];
                    }

            // Estimate Status
            var estimateStatuses = [];
            var estimateStatusValues = [];
            if ($(".estimateStatusFilterCheck:checked").length != $(".estimateStatusFilterCheck").length) {
                estimateStatuses = $(".estimateStatusFilterCheck:checked").map(function () {
                    estimateStatusValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!estimateStatuses.length) {
                estimateStatuses = [];
            }

            // Estimate Job Cost Status
            var jobCostStatuses = [];
            var jobCostStatusValues = [];
            if ($(".JobCostStatusFilterCheck:checked").length != $(".JobCostStatusFilterCheck").length) {
                jobCostStatuses = $(".JobCostStatusFilterCheck:checked").map(function () {
                    jobCostStatusValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!jobCostStatuses.length) {
                jobCostStatuses = [];
            }

            var users = [];
            var userValues = [];
            if ($(".userFilterCheck:checked").not('.branchFilterCheck').length != $(".userFilterCheck").not('.branchFilterCheck').length) {
                users = $(".userFilterCheck:checked").not('.branchFilterCheck').map(function () {
                    userValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!users.length) {
                users = [];
            }

            var branches = [];
            if ($(".branchFilterCheck:checked").length != $(".branchFilterCheck").length) {
                branches = $(".branchFilterCheck:checked").map(function () {
                    return $(this).data('branch-id');
                }).get();
            }

            var clientAccounts = [];
            var clientAccountValues = [];

            var clientAccounts = $(".clientAccountFilterCheck:checked").map(function () {
                clientAccountValues.push($(this).data('text-value'));
                return $(this).val();
            }).get();

            if (!clientAccounts.length) {
                clientAccounts = [];
            }

            var services = [];
            var serviceValues = [];
            if ($(".serviceFilterCheck:checked").length != $(".serviceFilterCheck").length) {
                services = $(".serviceFilterCheck:checked").map(function () {
                    serviceValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                $('.filterColumnCheck[data-affected-class="serviceFilterCheck"]').prop("checked",false);

            }else{

                $('.filterColumnCheck[data-affected-class="serviceFilterCheck"]').prop("checked",true);

            }
            if (!services.length) {
                services = [];
            }


            var queues = [];
            var queueValues = [];
            var emailStatuses = [];
            var emailStatusValues = [];
            var excludeCheck = [];
            var excludeCheckValues = [];
            var signedCheck = [];
            var signedCheckValues = [];
            var others_checked =false;

            if ($(".queueFilterCheck:checked").length != $(".queueFilterCheck").length) {
                queues = $(".queueFilterCheck:checked").map(function () {
                    queueValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                if (!queues.length) {
                    queues = [];
                }

                
                others_checked = true;


            }

            if ($(".emailFilterCheck:checked").length != $(".emailFilterCheck").length) {
                emailStatuses = $(".emailFilterCheck:checked").map(function () {
                    emailStatusValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                if (!emailStatuses.length) {
                    emailStatuses = [];
                }
                others_checked = true;
            }

            if ($(".excludeCheck:checked").length != $(".excludeCheck").length) {
                excludeCheck = $(".excludeCheck:checked").map(function () {
                    excludeCheckValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                if (!excludeCheck.length) {
                    excludeCheck = [];
                }
            }

            // resend exclude/include

            var resendInclude = $('#pResendInclude').prop("checked") ? 1 : 0 ;
            var resendExclude = $('#pResendExclude').prop("checked") ? 1 : 0 ;

            if ($(".signedCheck:checked").length != $(".signedCheck").length) {
                signedCheck = $(".signedCheck:checked").map(function () {
                    signedCheckValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                if (!signedCheck.length) {
                    signedCheck = [];
                }
                $('.filterColumnCheck[data-affected-class="signedCheck"]').prop("checked",false);
            }else{
                $('.filterColumnCheck[data-affected-class="signedCheck"]').prop("checked",true);
            }
            // Proposal Signed /unsigned

            var pSigned = $('#pSigned').prop("checked") ? 1 : 0 ;
            var pUnsigned = $('#pUnsigned').prop("checked") ? 1 : 0 ;

            var pCompanySigned = $('#pCompanySigned').prop("checked") ? 1 : 0 ;
            var pCompanyUnsigned = $('#pCompanyUnsigned').prop("checked") ? 1 : 0 ;
            // Bid Range
            var minBid = $("#pMinBid").val();
            var maxBid = $("#pMaxBid").val();

            // Created Range
            var createdFrom = $("#pCreatedFrom").val();
            var createdTo = $("#pCreatedTo").val();

            // Older Then Range
            var olderThen = $("#older_then_date").val();
            var newerThen = $("#newer_then_date").val();

            // Activity Range
            var activityFrom = $("#pActivityFrom").val();
            var activityTo = $("#pActivityTo").val();

            // Won Range
            var wonFrom = $("#pWonFrom").val();
            var wonTo = $("#pWonTo").val();


            var filterBadgeHtml = '';
            var createdHeaderText = ' [ All ]';
            var activityHeaderText = ' [ All ]';
            var wonHeaderText = ' [ All ]';
            var priceRangeHeaderText = ' [ All ]';
            var statusHeaderText = ' [ All ]';
            var estimateStatusHeaderText = ' [ All ]';
            var userHeaderText = ' [ All ]';
            var accountHeaderText = ' [ All ]';
            var serviceHeaderText = ' [ All ]';
            var businessTypeHeaderText = ' [ All ]';
            var otherHeaderText = ' [ All ]';
            var signatureHeaderText = ' [ All ]';
            var numFilters = 0;

            // Info boxes
            if($('#show_created_tab').is(":checked")){
            // Created Date Range
                if ($("#pCreatedFrom").val() || $("#pCreatedTo").val()) {
                    numFilters++;
                    var fromDateString;
                    var toDateString;
                    var createdRangeString;


                    if ($("#pCreatedFrom").val() && $("#pCreatedTo").val()) {

                        fromDateString = $("#pCreatedFrom").val();
                        toDateString = $("#pCreatedTo").val();
                        createdRangeString = fromDateString + ' - ' + toDateString;
                        var presetString = reverseDatePreset(fromDateString,toDateString);
                        if(presetString !='custom'){
                            createdRangeString = presetString;
                        }

                    }
                    else if ($("#pCreatedFrom").val()) {
                        fromDateString = $("#pCreatedFrom").val();
                        createdRangeString = 'After ' + fromDateString;
                    }
                    else {
                        toDateString = $("#pCreatedTo").val();
                        createdRangeString = 'Before ' + toDateString;
                    }

                    filterBadgeHtml += '<div class="filterBadge">' +
                        '<div class="filterBadgeTitle">Created: </div>' +
                        '<div class="filterBadgeContent">' +
                        createdRangeString +
                        '</div>' +
                        '<div class="filterBadgeRemove"><a href="#" id="removeCreatedFilter">&times;</a></div>' +
                        '</div>';

                    createdHeaderText = createdRangeString;
                    $('#createdFilterHeader').addClass('activeFilter');

                } else {
                    $('#createdFilterHeader').removeClass('activeFilter');
                }
        }else{

            if ($("#older_then_value").val() || $("#newer_then_value").val()) {
                    numFilters++;
                    var fromDateString;
                    var toDateString;
                    var createdRangeString;


                    if ($("#older_then_value").val() && $("#newer_then_value").val()) {

                        fromDateString = $("#newer_then_value").val();
                        toDateString = $("#older_then_value").val();
                        var older_then = $('#older_then_value').val();
                        var newer_then = $('#newer_then_value').val();
                        var older_then_type = $('#olderThenType').val();
                        var newer_then_type = $('#newerThenType').val();

                        createdRangeString = older_then +' '+older_then_type.replace('s','')+ 's - ' +  newer_then +' '+newer_then_type.replace('s','')+ 's old';

                    }
                    else if ($("#newer_then_value").val()) {
                        var newer_then = $('#newer_then_value').val();
                        var newer_then_type = $('#newerThenType').val();

                        createdRangeString = 'Less then ' + newer_then +' '+newer_then_type.replace('s','')+ 's old'
                    }
                    else {
                        var older_then = $('#older_then_value').val();
                        var older_then_type = $('#olderThenType').val();
                        createdRangeString = older_then +'+ '+older_then_type.replace('s','')+ 's old'

                    }

                    filterBadgeHtml += '<div class="filterBadge">' +
                        '<div class="filterBadgeTitle">Created: </div>' +
                        '<div class="filterBadgeContent">' +
                        createdRangeString +
                        '</div>' +
                        '<div class="filterBadgeRemove"><a href="#" id="removeCreatedFilter">&times;</a></div>' +
                        '</div>';

                    createdHeaderText = createdRangeString;
                    $('#createdFilterHeader').addClass('activeFilter');

                } else {
                    $('#createdFilterHeader').removeClass('activeFilter');
                }

        }
            $("#createdHeaderText").text(createdHeaderText);

            // Activity Date Range
            if ($("#pActivityFrom").val()) {
                numFilters++;

                var fromDateString = $("#pActivityFrom").val();
                var toDateString = $("#pActivityTo").val();
                var activityRangeString = fromDateString + ' - ' + toDateString;
                var presetString = reverseDatePreset(fromDateString,toDateString);
                    if(presetString !='custom'){
                        activityRangeString = presetString;
                    }
                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Activity: </div>' +
                    '<div class="filterBadgeContent">' +
                    activityRangeString +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeActivityFilter">&times;</a></div>' +
                    '</div>';

                activityHeaderText = activityRangeString;
                $('#activityFilterHeader').addClass('activeFilter');
            } else {
                $('#activityFilterHeader').removeClass('activeFilter');
            }
            $("#activityHeaderText").text(activityHeaderText);


            // Won Date Range
            if ($("#pWonFrom").val()) {
                numFilters++;

                var fromDateString = $("#pWonFrom").val();
                var toDateString = $("#pWonTo").val();
                var wonRangeString = fromDateString + ' - ' + toDateString;
                var presetString = reverseDatePreset(fromDateString,toDateString);
                    if(presetString !='custom'){
                        wonRangeString = presetString;
                    }
                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Sold: </div>' +
                    '<div class="filterBadgeContent">' +
                    wonRangeString +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeWonFilter">&times;</a></div>' +
                    '</div>';

                wonHeaderText = wonRangeString;
                $('#wonFilterHeader').addClass('activeFilter');
            } else {
                $('#wonFilterHeader').removeClass('activeFilter');
            }
            $("#wonHeaderText").text(wonHeaderText);


            // Price Range
            if((minBid > 0) || (maxBid > 0)){
                if (($("#pMinBid").val() != $("#pMinBid").data('original-value')) || ($("#pMaxBid").val() != $("#pMaxBid").data('original-value'))) {
                    numFilters++;

                    if (minBid && maxBid) {
                        priceRangeHeaderText = '$<span >'+intToString($("#pMinBid").val())+'</span> - $<span >'+intToString($("#pMaxBid").val())+'</span></p>';
                    } else {
                        if(minBid) {
                            priceRangeHeaderText = 'Min: $<span >'+intToString($("#pMinBid").val())+'</span>';
                        }

                        if (maxBid) {
                            priceRangeHeaderText = 'Max: $<span >'+intToString($("#pMaxBid").val())+'</span>';
                        }
                    }


                    filterBadgeHtml += '<div class="filterBadge">' +
                        '<div class="filterBadgeTitle">Price Range: </div>' +
                        '<div class="filterBadgeContent">'+priceRangeHeaderText+
                        '</div>' +
                        '<div class="filterBadgeRemove"><a href="#" id="removePriceFilter">&times;</a></div>' +
                        '</div>';


                    $('#priceRangeFilterHeader').addClass('activeFilter');
                } else {
                    $('#priceRangeFilterHeader').removeClass('activeFilter');
                }
            }else{ $('#priceRangeFilterHeader').removeClass('activeFilter');}
            $("#priceRangeHeaderText").html(priceRangeHeaderText);
// original status badge
            var pResendFromStatusId;
            var pResendNotesAdded;

            <?php
            if($this->uri->segment(2)=='resend'){
                if($this->session->userdata('pResendNotesAddedFilter')){?>
                    var pResendNotesAdded = <?=$this->session->userdata('pResendNotesAddedFilter');?>;
                    filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Note Added: </div>' +
                    '<div class="filterBadgeContent">After Campaign Sent' +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="javascript:void(0);" id="removeNoteAddedFilter">&times;</a></div>' +
                    '</div>';

                <?php }

            if($this->session->userdata('pResendFromStatusId')){

            ?>
            var pResendFromStatusId = <?=$this->session->userdata('pResendFromStatusId');?>;
            var pResendstatusBadgeText = $(".statusFilterCheck[value="+pResendFromStatusId+"]").attr('data-text-value');
            filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Original Status: </div>' +
                    '<div class="filterBadgeContent">' +
                    pResendstatusBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter11">&times;</a></div>' +
                    '</div>';
            <?php } }?>

            // Status
            if (statusValues.length) {
                numFilters++;
                $('#statusFilterHeader').addClass('activeFilter');

                var statusBadgeText = '[' + statusValues.length + ']';

                if (statusValues.length == $(".statusFilterCheck").length) {
                    statusBadgeText = 'All';
                }

                if (statusValues.length == 1) {
                    statusBadgeText = statusValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Status: </div>' +
                    '<div class="filterBadgeContent">' +
                    statusBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                    '</div>';

                statusHeaderText = '[' + statusValues.length + ']';

            }
            else {
                $('#statusFilterHeader').removeClass('activeFilter');
            }
            $("#statusHeaderText").text(statusHeaderText);


            // stimate Status
            if (estimateStatusValues.length) {
                numFilters++;
                $('#estimateStatusFilterHeader').addClass('activeFilter');

                var estimateStatusBadgeText = '[' + estimateStatusValues.length + ']';

                if (estimateStatusValues.length == $(".estimateStatusFilterCheck").length) {
                    estimateStatusBadgeText = 'All';
                }

                if (estimateStatusValues.length == 1) {
                    estimateStatusBadgeText = estimateStatusValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Estimate: </div>' +
                    '<div class="filterBadgeContent">' +
                    estimateStatusBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeEstimateStatusFilter">&times;</a></div>' +
                    '</div>';

                estimateStatusHeaderText = '[' + estimateStatusValues.length + ']';

            }
            else {
                $('#estimateStatusFilterHeader').removeClass('activeFilter');
            }
            $("#estimateStatusHeaderText").text(statusHeaderText);


            // job Cost Status
            if (jobCostStatusValues.length) {
                numFilters++;
                $('#estimateStatusFilterHeader').addClass('activeFilter');

                var jobCostStatusBadgeText = '[' + jobCostStatusValues.length + ']';

                if (jobCostStatusValues.length == $(".estimateStatusFilterCheck").length) {
                    jobCostStatusBadgeText = 'All';
                }

                if (jobCostStatusValues.length == 1) {
                    jobCostStatusBadgeText = jobCostStatusValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Job Cost: </div>' +
                    '<div class="filterBadgeContent">' +
                    jobCostStatusBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeJobCostStatusFilter">&times;</a></div>' +
                    '</div>';

                    jobCostStatusHeaderText = '[' + jobCostStatusValues.length + ']';

            }
            else {
                $('#estimateStatusFilterHeader').removeClass('activeFilter');
            }
            $("#estimateStatusHeaderText").text(statusHeaderText);

            // User
            if (userValues.length) {
                numFilters++;
                $('#userFilterHeader').addClass('activeFilter');

                var userBadgeText = '[' + userValues.length + ']';

                if (userValues.length == $(".userFilterCheck").not('.branchFilterCheck').length) {
                    userBadgeText = 'All';
                }

                if (userValues.length == 1) {
                    userBadgeText = userValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Users: </div>' +
                    '<div class="filterBadgeContent">' +
                    userBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeUserFilter">&times;</a></div>' +
                    '</div>';


                userHeaderText = '[' + userValues.length + ']';

            } else {
                $('#userFilterHeader').removeClass('activeFilter');
            }
            $("#userHeaderText").text(userHeaderText);

            // Account
            if (clientAccountValues.length) {
                numFilters++;
                $('#accountFilterHeader').addClass('activeFilter');

                var accountBadgeText = '[' + clientAccountValues.length + ']';

                if (clientAccountValues.length == 1) {
                    accountBadgeText = clientAccountValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Account: </div>' +
                    '<div class="filterBadgeContent">' +
                    accountBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeAccountFilter">&times;</a></div>' +
                    '</div>';

                accountHeaderText = '[' + clientAccountValues.length + ']';

            } else {
                $('#accountFilterHeader').removeClass('activeFilter');
            }
            $("#accountHeaderText").text(accountHeaderText);

            // Service
            if (serviceValues.length) {
                numFilters++;
                $('#serviceFilterHeader').addClass('activeFilter');

                var serviceBadgeText = '[' + serviceValues.length + ']';

                if (serviceValues.length == $(".serviceFilterCheck").length) {
                    serviceBadgeText = 'All';
                }

                if (serviceBadgeText.length == 1) {
                    serviceBadgeText = serviceValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Services: </div>' +
                    '<div class="filterBadgeContent">' +
                    serviceBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeServiceFilter">&times;</a></div>' +
                    '</div>';

                serviceHeaderText = '[' + serviceValues.length + ']';

            } else {
                $('#serviceFilterHeader').removeClass('activeFilter');
            }
            $("#serviceHeaderText").text(serviceHeaderText);

            // Queue
            if (queueValues.length) {
                numFilters++;

                var queueBadgeText = '[' + queueValues.length + ']';

                if (queueValues.length == $(".queueFilterCheck").length) {
                    queueBadgeText = 'All';
                }

                if (queueValues.length == 1) {
                    queueBadgeText = queueValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Queue: </div>' +
                    '<div class="filterBadgeContent">' +
                    queueBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeQueueFilter">&times;</a></div>' +
                    '</div>';
            }

            // Business Type
                            if (proposalBusinessTypes.length) {

                                numFilters++;
                                $('#businessTypeFilterHeader').addClass('activeFilter');

                                var businessTypeBadgeText = '[' + proposalBusinessTypes.length + ']';
                                businessTypeHeaderText = '[' + proposalBusinessTypes.length + ']';
                                 if ($(".businessTypeFilterCheck:checked").length == $(".businessTypeFilterCheck").length) {
                                     businessTypeBadgeText = 'All';
                                     businessTypeHeaderText = '[ All ]';
                                 }

                                if (proposalBusinessTypes.length == 1) {
                                   businessTypeBadgeText = proposalBusinessTypeValues[0];
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Business Type: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    businessTypeBadgeText +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeBusinessTypeFilter">&times;</a></div>' +
                                    '</div>';



                            } else {
                                $('#businessTypeFilterHeader').removeClass('activeFilter');
                            }
                            $("#businessTypeHeaderText").text(businessTypeHeaderText);
                            //end busines type


            // Email Status
            if (emailStatusValues.length) {
                numFilters++;

                var emailBadgeText = '[' + emailStatusValues.length + ']';

                if (emailStatusValues.length == $(".emailFilterCheck").length) {
                    emailBadgeText = 'All';
                }

                if (emailStatusValues.length == 1) {
                    emailBadgeText = emailStatusValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Email Status: </div>' +
                    '<div class="filterBadgeContent">' +
                    emailBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeEmailStatusFilter">&times;</a></div>' +
                    '</div>';
            }

            if(excludeCheck.length==1){
                numFilters++;
                if(resendExclude){
                    filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Email : </div>' +
                    '<div class="filterBadgeContent">Off' +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeExcludedFilter">&times;</a></div>' +
                    '</div>';
                }
                if(resendInclude){
                    filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Email : </div>' +
                    '<div class="filterBadgeContent">On' +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeExcludedFilter">&times;</a></div>' +
                    '</div>';
                }
            }

            if(signedCheck.length){
                numFilters++;
                if(!pSigned || !pUnsigned){
                    if(pSigned){
                        filterBadgeHtml += '<div class="filterBadge">' +
                        '<div class="filterBadgeTitle">Customer Signed : </div>' +
                        '<div class="filterBadgeContent">Yes' +
                        '</div>' +
                        '<div class="filterBadgeRemove"><a href="#" id="removeSignedFilter">&times;</a></div>' +
                        '</div>';
                    }
                    if(pUnsigned){
                        filterBadgeHtml += '<div class="filterBadge">' +
                        '<div class="filterBadgeTitle">Customer Signed : </div>' +
                        '<div class="filterBadgeContent">No' +
                        '</div>' +
                        '<div class="filterBadgeRemove"><a href="#" id="removeSignedFilter">&times;</a></div>' +
                        '</div>';
                    }
                }
                if(!pCompanySigned || !pCompanyUnsigned){
                    if(pCompanySigned){
                        filterBadgeHtml += '<div class="filterBadge">' +
                        '<div class="filterBadgeTitle">Company Signed : </div>' +
                        '<div class="filterBadgeContent">Yes' +
                        '</div>' +
                        '<div class="filterBadgeRemove"><a href="#" id="removeSignedFilter">&times;</a></div>' +
                        '</div>';
                    }
                    if(pCompanyUnsigned){
                        filterBadgeHtml += '<div class="filterBadge">' +
                        '<div class="filterBadgeTitle">Company Signed : </div>' +
                        '<div class="filterBadgeContent">No' +
                        '</div>' +
                        '<div class="filterBadgeRemove"><a href="#" id="removeSignedFilter">&times;</a></div>' +
                        '</div>';
                    }
                }
            }
            
            var numOtherValues = 0;
            //if(others_checked){
                 numOtherValues = (emailStatusValues.length + queueValues.length +excludeCheck.length);
            // }else{
            //     if(excludeCheck.length !=2){
            //          numOtherValues = ($(".emailFilterCheck").length + $(".queueFilterCheck").length + excludeCheck.length);
            //     }

            // }


            if (numOtherValues) {
                $('#otherFilterHeader').addClass('activeFilter');
                otherHeaderText = '[' + numOtherValues + ']';
            }
            else {
                $('#otherFilterHeader').removeClass('activeFilter');
            }
            $("#otherHeaderText").text(otherHeaderText);

            var numSignatureValues = signedCheck.length;

            if (numSignatureValues) {
                $('#signatureFilterHeader').addClass('activeFilter');
                signatureHeaderText = '[' + numSignatureValues + ']';
            }
            else {
                $('#signatureFilterHeader').removeClass('activeFilter');
            }
            $("#signatureHeaderText").text(signatureHeaderText);

            // Apply the HTML
            $("#filterBadges").html(filterBadgeHtml);

            if (numFilters < 1) {
                $("#newProposalFilterButton").removeClass('update-button');
                $("#newProposalFilterButton").addClass('grey');
                $('#newResetProposalFilterButton').hide();
                $('#newResetProposalFilterButton2').hide();
            }
            else {
                $("#newProposalFilterButton").addClass('update-button');
                $("#newProposalFilterButton").removeClass('grey');
                $('#newResetProposalFilterButton').show();
                $('#newResetProposalFilterButton2').show();
            }

            if (($("#pMinBid").val() != $("#pMinBid").data('original-value')) || ($("#pMaxBid").val() != $("#pMaxBid").data('original-value'))) {
                var temp_pFilterMinBid = minBid;
                var temp_pFilterMaxBid = maxBid;
            }else{
                var temp_pFilterMinBid = [];
                var temp_pFilterMaxBid = [];
            }
            var account_object_array = [];
            for($i=0;$i<clientAccounts.length;$i++){
                var queryStr = { "id" : clientAccounts[$i],"name": clientAccountValues[$i]};
                account_object_array.push(queryStr);
            }
            var user_object_array = [];
            for($i=0;$i<users.length;$i++){
                var queryStr = { "id" : users[$i],"name": userValues[$i]};
                user_object_array.push(queryStr);
            }
            var business_type_object_array = [];
            for($i=0;$i<proposalBusinessTypes.length;$i++){
                var queryStr = { "id" : proposalBusinessTypes[$i],"name": proposalBusinessTypeValues[$i]};
                business_type_object_array.push(queryStr);
            }
            var service_object_array = [];
            for($i=0;$i<services.length;$i++){
                var queryStr = { "id" : services[$i],"name": serviceValues[$i]};
                service_object_array.push(queryStr);
            }
            var email_status_object_array = [];
            for($i=0;$i<emailStatuses.length;$i++){
                var queryStr = { "id" : emailStatuses[$i],"name": emailStatusValues[$i]};
                email_status_object_array.push(queryStr);
            }
            var queues_object_array = [];
            for($i=0;$i<queues.length;$i++){
                var queryStr = { "id" : queues[$i],"name": queueValues[$i]};
                queues_object_array.push(queryStr);
            }
            var statuses_object_array = [];
            for($i=0;$i<statuses.length;$i++){
                var queryStr = { "id" : statuses[$i],"name": statusValues[$i]};
                statuses_object_array.push(queryStr);
            }

            proposal_filter = {
                    "pFilterStatus": statusValues,
                    "pFilterStatusObject": statuses_object_array,
                    "pFilterEstimateStatus": estimateStatusValues,
                    "pFilterJobCostStatus": jobCostStatusValues,
                    "pFilterUser": userValues,
                    "pFilterUserObject": user_object_array,
                    "pFilterBranch": branches,
                    "pFilterClientAccount": clientAccountValues,
                    "pFilterClientAccountObject": account_object_array,
                    "pFilterMinBid": temp_pFilterMinBid,
                    "pFilterMaxBid": temp_pFilterMaxBid,
                    "pFilterService": serviceValues,
                    "pFilterServiceObject": service_object_array,
                    "pFilterQueue": queueValues,
                    "pFilterQueueObject": queues_object_array,
                    "pFilterEmailStatus": emailStatusValues,
                    "pFilterEmailStatusObject": email_status_object_array,
                    "pCreatedFrom": createdFrom,
                    "pCreatedTo": createdTo,
                    "pOlderThen": olderThen,
                    "pNewerThen": newerThen,
                    "pActivityFrom": activityFrom,
                    "pActivityTo": activityTo,
                    "pFilterBusinessType": proposalBusinessTypeValues,
                    "pFilterBusinessTypeObject": business_type_object_array,
                    "pWonFrom": wonFrom,
                    "pWonTo": wonTo,
                    "pResendInclude": resendInclude,
                    "pResendExclude": resendExclude,
                    "pSigned": pSigned,
                    "pUnsigned": pUnsigned,
                    "pCompanySigned": pCompanySigned,
                    "pCompanyUnsigned": pCompanyUnsigned,
                };

            <?php
                if($this->uri->segment(2)=='resend'){

                    $filter_url = site_url('ajax/setProposalResendFilter').'/'.$this->uri->segment(3);
                }
                 else if($this->uri->segment(2)=='status'){
                     $filter_url = site_url('ajax/setProposalFilterStatus');
                 }else if($this->uri->segment(2)=='stats'){
                    $filter_url = site_url('ajax/setProposalFilterStats');
                }else if($this->uri->segment(2)=='account_stats'){
                    $filter_url = site_url('ajax/setProposalFilterAccountStats');
                }

                else{
                    $filter_url = site_url('ajax/setProposalFilter');
                }

            ?>

            if(firstRun) {
                firstRun = false;
            } else {

                $.ajax({
                    type: "POST",
                    url: '<?php echo $filter_url ?>',
                    data: {
                        pFilterStatus: statuses,
                        pFilterEstimateStatus: estimateStatuses,
                        pFilterJobCostStatus: jobCostStatuses,
                        pFilterUser: users,
                        pFilterBranch: branches,
                        pFilterClientAccount: clientAccounts,
                        pFilterMinBid: minBid,
                        pFilterMaxBid: maxBid,
                        pFilterService: services,
                        pFilterQueue: queues,
                        pFilterEmailStatus: emailStatuses,
                        pCreatedFrom: createdFrom,
                        pCreatedTo: createdTo,
                        pOlderThen: olderThen,
                        pNewerThen: newerThen,
                        pActivityFrom: activityFrom,
                        pActivityTo: activityTo,
                        pWonFrom: wonFrom,
                        pWonTo: wonTo,
                        pFilterBusinessType: proposalBusinessTypes,
                        pResendFromStatusId: pResendFromStatusId,
                        pResendNotesAdded: pResendNotesAdded,
                        pResendInclude: resendInclude,
                        pResendExclude: resendExclude,
                        pSigned: pSigned,
                        pUnsigned: pUnsigned,
                        pCompanySigned: pCompanySigned,
                        pCompanyUnsigned: pCompanyUnsigned,
                    },
                    dataType: 'JSON',
                    success: function (d) {
                        if ($("#proposalsMap").is(':visible')) {
                            getFilteredProposalIds();
                        }

                        if ($.fn.DataTable.isDataTable('#proposalsTable')) {
                            oTable.ajax.reload(null, false);
                        } else {
                            initProposalTable('<?php echo $search; ?>');
                        }


                    }
                });

            }
        }, 10);
    }

    function intToString (value) {
        var suffixes = ["", "k", "m", "b","t"];
        var suffixNum = Math.floor((""+value).length/3);
        if (suffixNum < 1) {
            return "" + value;
        } else {
            var shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000,suffixNum)) : value).toPrecision(2));
            if (shortValue % 1 != 0) {
                shortValue = shortValue.toFixed(1);
            }
            return shortValue+suffixes[suffixNum];
        }

    }
    $('.column_show_apply').click(function(){
      //  oTable.api().columns( [21] ).visible( false );
            // When we apply, makes sure these are hidden
        oTable.columns( [4,5,6,7,8,10,11,12,13,14,15,16,17,18 ] ).visible( false );
        var favorite = [];
        $.each($("input[name='column_show']:checked"), function(){
                favorite.push($(this).val());
            });

            oTable.columns( favorite ).visible( true );
            if(hasLocalStorage){
                localStorage.setItem("proposals_win_column_show_1", favorite);
            }

           oTable.ajax.reload(null,false);
           $("#newProposalColumnFilters").hide();

      })

    $("#newProposalFilterButton").click(function () {
        hideInfoSlider();
        $("#newProposalFilters").toggle();
        // Clear search so that filters aren't affected
        oTable.search('');
        // Hide group action menu
        $(".groupActionsContainer").hide();
    });

    // Handle filter searches - except client aaccounts which are handled differently
    $('.filterSearch').not('#accountSearch').on('input', function () {

        var searchVal = $(this).val();
        var parentCol = $(this).parents('.filterColumn');

        if (searchVal.length) {
            $(parentCol).find('.filterColumnRow').hide();
            $(parentCol).find(".filterColumnRow:iContains('" + searchVal + "')").show();
            $(parentCol).find(".filterSearchClear").show();
        } else {
            $(parentCol).find(".filterColumnRow").show();
            $(parentCol).find(".filterSearchClear").hide();
        }

    });

    $('#accountSearch').on('input', function () {
        var searchVal = $(this).val();

        if (!searchVal.length) {
            $(".searchRow").not('.searchSelectedRow').remove();
            return false;
        }

        $.ajax({
            url: '<?php echo site_url('ajax/searchClientAccounts') ?>',
            type: "post",
            data: {
                searchVal: searchVal
            },
            dataType: "json"
        })
            .success(function (data) {

                $(".searchRow").not('.searchSelectedRow').remove();

                var len = data.length;

                for (var i = 0; i < len; i++) {
                    var account = data[i];

                    $("#accountsFilterColumn").append('<div class="filterColumnRow searchRow">' +
                        '<input type="checkbox" value="' + account.value + '" class="filterCheck clientAccountFilterCheck" data-text-value="' + account.label + '" />' +
                        '<span class="accountName">' + account.label + '</span>' +
                        '</div>');
                }

                $('.clientAccountFilterCheck').not('.searchSelected').uniform();
            });

    });

    $(".filterSearchClear").click(function () {
        var searchInput = $(this).prev('.filterSearch');
        $(searchInput).val('');
        $(searchInput).trigger('input');
    });

    $(document).on('change', ".filterCheck", function () {

        if ($(this).hasClass('clientAccountFilterCheck') && $(this).hasClass('searchSelected')) {
            if (!$(this).is(':checked')) {
                $(this).parents('.filterColumnRow').remove();
                $('#accountSearch').trigger('input');
            }
        }
        else if ($(this).hasClass('clientAccountFilterCheck')) {
            var parent = $(this).parents('.filterColumnRow');
            parent.addClass('searchSelectedRow');
            $(this).addClass('searchSelected');
            parent.insertAfter('#accountRowAll');
        } else if ($(this).hasClass('prospectStatusFilterCheck')) {
            $('#statusFilterColumnCheck').prop('checked', false);
            $('.statusFilterCheck').not('.prospectStatusFilterCheck').prop('checked', false);
        }else if($(this).hasClass('statusFilterCheck') && $(this).val()==2){
            if ($(this).is(':checked')) {
                $('.wonStatusCheck').prop('checked', true);
            }
        }

        var numSearchSelected = $('.searchSelected').length;
        if (numSearchSelected < 1) {
            $('#allClientAccounts').prop('checked', true);

        }
        else {
            $('#allClientAccounts').prop('checked', false);
        }

        $.uniform.update();
        applyFilter();
    });

    function change_pMinBid() {


        if ($('.pMinBid').val() != '$' && $('.pMinBid').val() != '') {
            $('#pMinBid').val(cleanNumber($(".pMinBid").val()));
        } else {
            $('#pMinBid').val('');
            $('.pMinBid').val('');
        }

        applyFilter();
    }

function change_pMaxBid() {
    if ($('.pMaxBid').val() != '$' && $('.pMaxBid').val() != '') {
        $('#pMaxBid').val(cleanNumber($(".pMaxBid").val()));
    } else {
        $('#pMaxBid').val('');
        $('.pMaxBid').val('');
    }
    applyFilter();
}

var temptimer = null;
$('.pMinBid').keydown(function(){
       clearTimeout(temptimer);
       temptimer = setTimeout(change_pMinBid, 500)
});

$('.pMaxBid').keydown(function(){
       clearTimeout(temptimer);
       temptimer = setTimeout(change_pMaxBid, 500)
});
    var sliderMin = <?php echo $minBid; ?>;
    var sliderMax = <?php echo $maxBid ?: 0; ?>;
    var sliderMinVal = <?php echo $filterMinBid; ?>;
    var sliderMaxVal = <?php echo $filterMaxBid ?: 0; ?>;

    $("#priceSlider").slider({
        range: true,
        min: sliderMin,
        max: sliderMax,
        step: 10000,
        values: [sliderMinVal, sliderMaxVal],
        slide: function (event, ui) {
            var minBid = ui.values[0];
            var maxBid = ui.values[1];

            $("#pMinBid").val(minBid);
            $("#pMaxBid").val(maxBid);

            $("#minBid").text(shortenLargeNumber(minBid, 2));
            $("#maxBid").text(shortenLargeNumber(maxBid, 2));
        },
        stop: function (event, ui) {
            applyFilter();
        }

    });
    // Set default values
    // $("#pMinBid").val(sliderMinVal);
    // $("#pMaxBid").val(sliderMaxVal);

    $("#minBid").text(shortenLargeNumber(sliderMinVal, 2));
    $("#maxBid").text(shortenLargeNumber(sliderMaxVal, 2));

    // DatePicker
    $("#pCreatedFrom").datepicker();
    $("#pCreatedTo").datepicker();
    $("#pActivityFrom").datepicker();
    $("#pActivityTo").datepicker();
    $("#pWonFrom").datepicker();
    $("#pWonTo").datepicker();


    // Handle change
    $("#pCreatedFrom, #pCreatedTo").change(function () {
        $("#createdPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pActivityFrom, #pActivityTo").change(function () {
        $("#activityPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pWonFrom, #pWonTo").change(function () {
        $("#wonPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pCreatedFrom, #pCreatedTo").on('input', function () {
        $("#createdPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pActivityFrom, #pActivityTo").on('input', function () {
        $("#activityPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pWonFrom, #pWonTo").on('input', function () {
        $("#wonPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#createdPreset").change(function () {

        var selectVal = $(this).val();

        if (selectVal) {

            if (selectVal == 'custom') {
                $("#pCreatedFrom").focus();
            }
            else {
                var preset = datePreset(selectVal);
                $("#pCreatedFrom").val(preset.startDate);
                $("#pCreatedTo").val(preset.endDate);
                applyFilter();
            }
        }
    });

    $(".older_newer_then").keyup(function () {

        var older_then = $('#older_then_value').val();
        var newer_then = $('#newer_then_value').val();
        var older_then_type = $('#olderThenType').val();
        var newer_then_type = $('#newerThenType').val();
        $("#newer_then_date").val('');
        $("#older_then_date").val('');
        if(older_then != '' && older_then_type != '' && newer_then != '' && newer_then_type != ''){
            var startDate = get_newer_then_date(newer_then,newer_then_type);
            var endDate = get_older_then_date(older_then,older_then_type);
                 $("#newer_then_date").val(startDate);
                 $("#older_then_date").val(endDate);
                applyFilter();
        }else if(older_then != '' && older_then_type != ''){
            var endDate = get_older_then_date(older_then,older_then_type);

                 $("#older_then_date").val(endDate);
                applyFilter();
        }else if(newer_then != '' && newer_then_type != ''){
            var startDate = get_newer_then_date(newer_then,newer_then_type);
            $("#newer_then_date").val(startDate);
                applyFilter();
        }



    });

    $(".older_newer_then_type").change(function () {

        var older_then = $('#older_then_value').val();
        var newer_then = $('#newer_then_value').val();
        var older_then_type = $('#olderThenType').val();
        var newer_then_type = $('#newerThenType').val();
        $("#newer_then_date").val('');
        $("#older_then_date").val('');
        if(older_then != '' && older_then_type != '' && newer_then != '' && newer_then_type != ''){
            var startDate = get_newer_then_date(newer_then,newer_then_type);
            var endDate = get_older_then_date(older_then,older_then_type);
                 $("#newer_then_date").val(startDate);
                 $("#older_then_date").val(endDate);
                applyFilter();
        }else if(older_then != '' && older_then_type != ''){
            var endDate = get_older_then_date(older_then,older_then_type);

                 $("#older_then_date").val(endDate);
                applyFilter();
        }else if(newer_then != '' && newer_then_type != ''){
            var startDate = get_newer_then_date(newer_then,newer_then_type);
            $("#newer_then_date").val(startDate);
                applyFilter();
        }
    });

        function get_newer_then_date(newer_then,newer_then_type){

        startDate = moment().subtract(newer_then, newer_then_type);
        startDate = startDate.format('MM/DD/YYYY');

        return startDate;
    }

     function get_older_then_date(older_then,older_then_type){

        endDate = moment().subtract(older_then, older_then_type);
        endDate = endDate.format('MM/DD/YYYY');

        return endDate;
    }

    $("#activityPreset").change(function () {

        var selectVal = $(this).val();

        if (selectVal) {

            if (selectVal == 'custom') {
                $("#pActivityFrom").focus();
            }
            else {
                var preset = datePreset(selectVal);
                $("#pActivityFrom").val(preset.startDate);
                $("#pActivityTo").val(preset.endDate);
                applyFilter();
            }
        }
    });

    $("#wonPreset").change(function () {

        var selectVal = $(this).val();

        if (selectVal) {

            if (selectVal == 'custom') {
                $("#pWonFrom").focus();
            }
            else {
                var preset = datePreset(selectVal);
                $("#pWonFrom").val(preset.startDate);
                $("#pWonTo").val(preset.endDate);
                applyFilter();
            }
        }
    });


    $(".set_max_price").click(function () {

        $(".pMaxBid").val('');
        $("#pMaxBid").val('');
        $(".pMinBid").val('');
        $("#pMinBid").val('');
        $(".set_max_price").hide()
        applyFilter();
    })
    // New filter reset button
    $("#newResetProposalFilterButton2").click(function () {
        $("#newResetProposalFilterButton").trigger('click')
    });
    // New filter reset button
    $("#newResetProposalFilterButton").click(function () {

        // Hide the map overlay
        hideInfoSlider();

        // Reset All Checkboxes
        $(".filterCheck, .filterColumnCheck,.excludeCheck").prop('checked', true);

        // Reset the slider
        $("#priceSlider").slider("option", "values", [sliderMin, sliderMax]);
        // Update Slider Texts
    //    var sliderMin  = $("#pMinBid").attr('data-original-value');
    //    var sliderMax = $("#pMaxBid").attr('data-original-value');
        $(".pMinBid").val(0);
        $(".pMaxBid").val('');
        $("#pMinBid").val(0);
        $("#pMaxBid").val('');
        $("#minBid").text(shortenLargeNumber(0, 2));
        $("#maxBid").text(shortenLargeNumber('', 2));
        // Reset date ranges
        $("#pCreatedFrom").val("");
        $("#pCreatedTo").val("");
        $("#pActivityFrom").val("");
        $("#pActivityTo").val("");
        $("#pWonFrom").val("");
        $("#pWonTo").val("");
        $("#createdPreset").val("");
        $("#activityPreset").val("");

        $(".filterColumn, .filterColumnWide").addClass('filterCollapse');
        $('.searchSelectedRow').remove();
        $('#accountSearch').val('');
        $('#saves_filter_list').val('');
        $('#accountSearch').trigger('input');

        $.uniform.update();
        applyFilter();

        return false;
    });

    $(".filterCheck").click(function () {

        // If it's a branch click
        if ($(this).hasClass('branchFilterCheck')) {
            // So, we're clicking on a branch //
            // How many are there? //
            var numBranches = $(".branchFilterCheck").length;
            var numSelectedBranches = $(".branchFilterCheck:checked").length;
            var selectedBranches = [];

            // If all branches selects, check the all box and all users
            if (numSelectedBranches == numBranches) {
                $("#allUsersCheck").prop('checked', true);
                // Check all users
                $('.userFilterCheck').prop('checked', true);
            }
            else {
                $("#allUsersCheck").prop('checked', false);

                // Check the users of the selected branches
                selectedBranches = $(".branchFilterCheck:checked").map(function () {
                    return $(this).data('branch-id');
                }).get();

                $('.userFilterCheck').not('.branchFilterCheck').each(function () {
                    var branchId = $(this).data('branch-id');
                    if (selectedBranches.indexOf(branchId) < 0) {
                        $(this).prop('checked', false);
                    }
                    else {
                        $(this).prop('checked', true);
                    }
                });
            }
        }
        else if ($(this).hasClass('userFilterCheck')) {
            // This is a user checkbox that isn't a branch, it's being changed so removed the branch filter
            $('.branchFilterCheck').prop('checked', false);

            var selectedUserBranches = $(".userFilterCheck:checked").map(function () {
                return $(this).data('branch-id');
            }).get();

            var uniqueUserBranches = Array.from(new Set(selectedUserBranches));

            if (uniqueUserBranches.length > 1) {
                $('.branchFilterCheck').prop('checked', false);
            }
            else {
                // Do we need to check the branc box?
                var branchIds = selectedBranches = $(".branchFilterCheck").map(function () {
                    return $(this).data('branch-id');
                }).get();

                $.each(branchIds, function (index, value) {
                    // Count how many there are
                    var totalBranchUsers = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').length;
                    var numUnchecked = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').not(':checked').length;

                    if (totalBranchUsers > 0 && numUnchecked == 0) {
                        $('.branchFilterCheck[data-branch-id="' + value + '"]').prop('checked', true);
                    }
                });
            }

            var numUsers = $(".userFilterCheck").length;
            var numSelectedUsers = $(".userFilterCheck:checked").length;

            if (numUsers != numSelectedUsers) {
                $('#allUsersCheck').prop("checked",false);

            }else{

                $('#allUsersCheck').prop("checked",true);

            }

        }
        $.uniform.update();
    });

        $(document).on('click', '#addAtCursorEdit', function () {
            //CKEDITOR.instances.message.insertText($("#templateFields").val());
            tinymce.activeEditor.execCommand('mceInsertContent', false, $("#templateFields").val());
        });

        $(document).on('change', '.filterColumnCheck', function () {

            var showAll = false;
            var className = $(this).data('affected-class');

            if ($(this).attr('id') == 'allClientAccounts') {
                if ($(this).is(':checked')) {
                    $("#accountSearch").val('');
                    $("#accountSearch").trigger('input');
                    $('.searchSelectedRow').remove();
                }
            }

            if ($(this).is(':checked')) {
                showAll = true;
            }

            $('.' + className).prop('checked', showAll);

            statusFilterColumnCheck
            if ($(this).attr('id') == 'statusFilterColumnCheck') {
                if ($(this).is(':checked')) {
                    $(".prospectStatusFilterCheck").prop('checked', false);
                }
            }
            if (className == 'otherFilterCheck') {
                $('#pResendInclude').prop('checked', showAll);
                $('#pResendExclude').prop('checked', showAll);
            }

            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeStatusFilter', function () {
            $(".statusFilterCheck").prop('checked', true);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeNoteAddedFilter', function () {
            var temp_red_url ='<?php echo  site_url().'proposals/resend/'.$resend_id;?>';

            window.location.href = temp_red_url;
        });


        $(document).on('click', '#removeEstimateStatusFilter', function () {
            $(".estimateStatusFilterCheck").prop('checked', true);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeJobCostStatusFilter', function () {
            $(".JobCostStatusFilterCheck").prop('checked', true);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeUserFilter', function () {
            $(".userFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });
        // Removing businessTypeFilterCheck filter
        $(document).on('click', '#removeBusinessTypeFilter', function () {
            $(".businessTypeFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });
        $(document).on('click', '#removeAccountFilter', function () {
            $(".clientAccountFilterCheck").prop('checked', false);
            $('.searchSelectedRow').remove();
            $('#allClientAccounts').prop('checked', true);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeServiceFilter', function () {
            $(".serviceFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeQueueFilter', function () {
            $(".queueFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeEmailStatusFilter', function () {
            $(".emailFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });
        $(document).on('click', '#removeExcludedFilter', function () {
            $(".excludeCheck").prop('checked', true);
            $.uniform.update();
            applyFilter();
        });
        $(document).on('click', '#removeSignedFilter', function () {
            $(".signedCheck").prop('checked', true);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removePriceFilter', function () {

            $(".pMinBid").val('');
            $(".pMaxBid").val('');
            $("#pMinBid").val('');
            $("#pMaxBid").val('');

            applyFilter();
        });

        $(document).on('click', '#removeCreatedFilter', function () {
            $("#pCreatedFrom").val("");
            $("#pCreatedTo").val("");
            $("#createdPreset").val("");
            applyFilter();
        });

        $(document).on('click', '#removeActivityFilter', function () {
            $("#pActivityFrom").val("");
            $("#pActivityTo").val("");
        $("#activityPreset").val("");
            applyFilter();
        });


        $(document).on('click', '#removeWonFilter', function () {
            $("#pWonFrom").val("");
            $("#pWonTo").val("");
            applyFilter();
        });

        $("#resetCreatedDate").click(function () {
            $("#pCreatedFrom").val('');
            $("#pCreatedTo").val('');
            $("#createdPreset").val('');
            $.uniform.update();
            applyFilter();
        });

        $("#resetActivityDate").click(function () {
            $("#pActivityFrom").val('');
            $("#pActivityTo").val('');
            $("#ActivityPreset").val('');
            $.uniform.update();
            applyFilter();
        });

        $("#resetWonDate").click(function () {
            $("#pWonFrom").val('');
            $("#pWonTo").val('');
            $("#wonPreset").val('');
            $.uniform.update();
            applyFilter();
        });

        // Filter Presets
    $(".proposalFilterPreset").click(function() {

        clearPreset = false;

        $(".proposalFilterPreset").addClass('grey');
        $(this).removeClass('grey');

        var datePreset = $(this).data('preset-range');
        var statusPreset = $(this).data('preset-status');

        var statuses =

        setTimeout(function() {

            // Date
            if (datePreset) {
                $("#createdPreset").val(datePreset);
                $.uniform.update();
            }

            // Status
            if (statusPreset) {
                $('.statusFilterCheck').prop('checked', false);
                $('.statusFilterCheck[value="' + statusPreset +'"]').prop('checked', true);
            }

            $.uniform.update();

            if (datePreset) {
                $("#createdPreset").change();
            }
            else {
                applyFilter();
            }
        }, 500);
    });


    $("#saves_filter_list").change(function() {

        clearPreset = false;
        //$("#newResetProposalFilterButton").trigger('click');
                // Hide the map overlay
        hideInfoSlider();

        // Reset All Checkboxes
        $(".filterCheck, .filterColumnCheck").prop('checked', true);

        // Reset the slider
        $("#priceSlider").slider("option", "values", [sliderMin, sliderMax]);
        // Update Slider Texts
    //    var sliderMin  = $("#pMinBid").attr('data-original-value');
    //    var sliderMax = $("#pMaxBid").attr('data-original-value');
        $(".pMinBid").val(0);
        $(".pMaxBid").val('');
        $("#pMinBid").val(0);
        $("#pMaxBid").val('');
        $("#minBid").text(shortenLargeNumber(0, 2));
        $("#maxBid").text(shortenLargeNumber('', 2));
        // Reset date ranges
        $("#pCreatedFrom").val("");
        $("#pCreatedTo").val("");
        $("#pActivityFrom").val("");
        $("#pActivityTo").val("");
        $("#pWonFrom").val("");
        $("#pWonTo").val("");
        $("#createdPreset").val("");
        $("#activityPreset").val("");

        $(".filterColumn, .filterColumnWide").addClass('filterCollapse');

        $('.searchSelectedRow').remove();
        $('#accountSearch').val('');
        $('#accountSearch').trigger('input');

        var datePreset = $("#saves_filter_list").find(':selected').data('preset-range');
        var statusPreset = $("#saves_filter_list").find(':selected').data('preset-status');
        var is_default = $("#saves_filter_list").find(':selected').data('default-filter');

        var statuses ='';

        setTimeout(function() {
            if(is_default){
            // Date
                if (datePreset) {
                    $("#createdPreset").val(datePreset);

                }

                // Status
                if (statusPreset) {
                    $('.statusFilterCheck').prop('checked', false);
                    $('.statusFilterCheck[value="' + statusPreset +'"]').prop('checked', true);
                }


                if (datePreset) {
                    $("#createdPreset").change();
                }
                else {
                    applyFilter();
                }
            }else{
                var filter = $("#saves_filter_list").find(':selected').data('filter');
                //var obj = jQuery.parseJSON(filter);
                var change_preset = false;
                $.each(filter, function(key,value) {
                    if(key=='pCreatedFrom' || key=='pCreatedTo' || key=='pActivityFrom' || key=='pActivityTo'|| key=='pWonFrom' || key=='pWonTo'){
                        if(value){
                            $('#'+key).val(value);
                            change_preset =true;
                        }

                    }else if(key=='pFilterMinBid'){

                        if(value){
                            $('#pMinBid').val(value);
                            $('.pMinBid').val(value);

                        }

                    }else if(key=='pFilterMaxBid'){
                        if(value){
                            $('#pMaxBid').val(value);
                            $('.pMaxBid').val(value);

                        }

                    }else if(key=='pFilterBusinessTypeObject'){
                        $('.businessTypeFilterCheck').prop('checked', false);
                        $('#allBusinessTypes').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.businessTypeFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }

                    }else if(key=='pFilterStatusObject'){
                        $('.statusFilterCheck').prop('checked', false);
                        $('#statusFilterColumnCheck').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.statusFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                    }else if(key=='pFilterBranch'){
                        if(value.length >2 ){
                            $('#allUsersCheck').prop('checked', true);
                        }else{
                            $('#allUsersCheck').prop('checked', false);
                            $('.pFilterBranch').prop('checked', false);
                            for($i=0;$i<value.length;$i++){
                                $('.branchFilterCheck[data-branch-id="' + value[$i] +'"]').prop('checked', true);
                            }
                        }

                    }else if(key=='pFilterUserObject'){
                        $('.userFilterCheck').prop('checked', false);
                        $('#allUsersCheck').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.userFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                    }else if(key=='pFilterQueueObject'){
                        $('.queueFilterCheck').prop('checked', false);
                        testArray = 'pFilterEmailStatusObject' in filter;
                        if(!testArray){
                            $('.emailFilterCheck').prop('checked', false);
                        }

                        $('.filterColumnCheck[data-affected-class="otherFilterCheck"]').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.queueFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                    }
                    else if(key=='pFilterEmailStatusObject'){
                        testArray = 'pFilterQueueObject' in filter;
                        if(!testArray){
                            $('.queueFilterCheck').prop('checked', false);
                        }
                        $('.filterColumnCheck[data-affected-class="otherFilterCheck"]').prop('checked', false);
                        $('.emailFilterCheck').prop('checked', false);

                        for($i=0;$i<value.length;$i++){
                            $('.emailFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                    }
                    else if(key=='pFilterServiceObject'){
                        $('.serviceFilterCheck').prop('checked', false);
                        $('.filterColumnCheck[data-affected-class="serviceFilterCheck"]').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.serviceFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                    }
                     else if(key=='pFilterClientAccountObject'){
                         for($i=0;$i<value.length;$i++){
                             var checkbox =     '<div class="filterColumnRow searchSelectedRow">'+
                                                '<input type="checkbox" class="filterCheck clientAccountFilterCheck searchSelected" checked="checked" value="'+value[$i].id+'" data-text-value="'+value[$i].name+'"/>'+
                                                '<span class="accountName">'+value[$i].name+'</span> </div>';
                                                $('#accountsFilterColumn').append(checkbox);
                        }

                     }else if(key=='pResendExclude'){
                       if(value == 1){
                            $("#pResendExclude").prop('checked',true);
                        }
                        else{
                            $("#pResendExclude").prop('checked',false);
                        }
                     }
                     else if(key=='pResendInclude'){
                        
                        if(value == 1){
                            $("#pResendInclude").prop('checked',true);
                        }
                        else{
                            $("#pResendInclude").prop('checked',false);
                        }
                     }else if(key=='pSigned'){
                       if(value == 1){
                            $("#pSigned").prop('checked',true);
                        }
                        else{
                            $("#pSigned").prop('checked',false);
                        }
                     }
                     else if(key=='pUnsigned'){
                        
                        if(value == 1){
                            $("#pUnsigned").prop('checked',true);
                        }
                        else{
                            $("#pUnsigned").prop('checked',false);
                        }
                     }else if(key=='pCompanySigned'){
                       if(value == 1){
                            $("#pCompanySigned").prop('checked',true);
                        }
                        else{
                            $("#pCompanySigned").prop('checked',false);
                        }
                     }
                     else if(key=='pCompanyUnsigned'){
                        
                        if(value == 1){
                            $("#pCompanyUnsigned").prop('checked',true);
                        }
                        else{
                            $("#pCompanyUnsigned").prop('checked',false);
                        }
                     }





                });

                if(change_preset) {

                    $("#createdPreset").change();
                    applyFilter();
                }
                else {

                    applyFilter();
                }
            }


        }, 500);
    });

        // Set default win date (today)
        var formattedToday = moment().format('MM/DD/YYYY');
        $("#statusWinDate").val(formattedToday);

        // Status win date datepicker
        $("#statusWinDate").datepicker();


        // Export dialog
        $("#exportProposals").dialog({
            modal: true,
            autoOpen: false,
            buttons: {
                "Export": {
                    text: 'Export',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmExport',
                    click: function () {

                        var exportName = $("#exportName").val();
                        exportName = exportName.replace(/[^a-zA-Z0-9_-\s]/g,'');

                        if (!exportName) {
                            swal('Error', ' Please enter a name for your export');
                        }
                        else {
                            $(this).dialog('close');
                            window.location.href = encodeURI('/proposals/export/' + exportName);
                        }

                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });

        // Map Loading Dialog
        $("#mapLoading").dialog({
            modal: true,
            autoOpen: false
        });

        // Group Export dialog
        $("#groupExportProposals").dialog({
            modal: true,
            autoOpen: false,
            buttons: {
                "Export": {
                    text: 'Export',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmExport',
                    click: function () {

                        

                        if (!exportName) {
                            swal('Error', ' Please enter a name for your export');
                        }
                        else {

                            $('#group_export_form').submit();
                            $(this).dialog('close');
                            
                        }

                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });

        // Export Menu Button
        $("#groupProposalExport").click(function() {
            // Clear the input
            $("#groupExportName").val('');
            // Store Selected ids in hidden field
            $('#groupExportProposalIds').val(getSelectedIds());
            // Open the dialog
           $("#groupExportProposals").dialog('open');
           $('.groupActionsContainer').hide();
        });

        // Export Menu Button
        $("#exportFilteredProposals").click(function() {
            // Clear the input
            $("#exportName").val('');
            // Open the dialog
           $("#exportProposals").dialog('open');
        });
        // Copy work order link
        $(document).on('click', ".send_mobile_job_costing_link", function () {
            var proposal_id = $(this).attr('data-id');
            swal({
                    title: "",
                    html: '<p ><strong>Job Cost: Send Mobile link</strong></p><p style="font-size: 14px;margin: 15px 0px;">Send a link to the mobile job costing page via email. Select a foreman or add a specific address.</p><form id="send_mobile_job_costing_link" action="<?php echo site_url('ajax/send_mobile_job_costing_link'); ?>" method="post">'+
                        '<input type="hidden" name="proposal_id" value="'+proposal_id+'">'+
                        '<table class="boxed-table pl-striped" width="100%" cellpadding="0" cellspacing="0">'+
                        '<tr><td><label style=" text-align: left">Select Foreman</label><select id="select_foreman" style="margin-top: 5px;padding: 3px;border-radius: 3px;" name="foremen_id"  class="foremen "><option value="" selected>-Select</option><?php foreach ($foremans as $foreman): ?><option value="<?php echo $foreman->getId() ?>"><?php echo $foreman->getName(); ?></option><?php endforeach;?><option value="0">Other</option></select></td></tr>'+
                            '<tr class="send_to_other" style="display:none;"><td><label for="" style="text-align: left;"> Send to Email</label><input type="text" name="email" class="text " placeholder="Enter Email " style="width: 180px;" value=""></td></tr>'+
                            '</tr></table></form>',

                    showCancelButton: true,
                    confirmButtonText: 'Send',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function (result) {
                    swal({
                        title: 'Sending..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })
                    //$('#send_mobile_job_costing_link').submit();
                    var form_data = $("#send_mobile_job_costing_link").serialize()
                    $.ajax({
                    url: '<?php echo site_url('ajax/send_mobile_job_costing_link') ?>',
                    type: "POST",
                    data: form_data,
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            //refresh frame
                           swal('Mobile Job Costing Link Sent')
                        } else {
                            if (data.error) {
                                alert("Error: " + data.error);
                            } else {
                                alert('An error has occurred. Please try again later!')
                            }
                        }
                    }
                });
                }).catch(swal.noop)
            $.uniform.update();
        });


        $(document).on('change', "#select_foreman", function () {
            if($(this).val()==0){
                $('.send_to_other').show();
            }else{
                $('.send_to_other').hide();
            }
        });
        // Copy work order link
        $(document).on('click', ".copyWorkOrderLink", function () {
            var linkInput = $(this).prev();

            swal({
                width: 600,
                html: 'Work Order Link<br />' +
                '<input type="text" style="width: 550px;" value="' + linkInput.val() + '" />'
            });
            $.uniform.update();
        });

        // Last Activity Popup
        $(document).on('click', ".lastActivityLink", function() {
            var proposalId = $(this).data('proposal-id');
            var projectName = $(this).data('project-name');

            $("#proposalActivityProjectName").text(projectName);
            var tableUrl = '/ajax/proposalHistory/' + proposalId;

            if (activityTable) {
                //activityTable.ajax.url(tableUrl).clear().load();
                activityTable.destroy();
                $('#proposalActivityTable').html('<thead><tr><th>Date Int</th><th>Date</th><th>User</th><th>IP Address</th><th>Details</th></tr></thead><tbody></tbody>');
            }
            //else {
                // Activity Datatable
                activityTable = $("#proposalActivityTable").DataTable({
                    "order": [[1, "desc"]],
                    "bProcessing": true,
                    "serverSide": true,
                    "scrollCollapse": true,
                    "scrollY": "300px",
                    "ajax": {
                        "url": tableUrl
                    },
                    "aoColumns": [
                        {'bVisible': false},
                        {'bSearchable': false, 'iDataSort': 0},
                        null,
                        {'bSortable': false},
                        {'bSortable': false}
                    ],
                    "bJQueryUI": true,
                    "bAutoWidth": true,
                    "sPaginationType": "full_numbers",
                    "sDom": 'HfltiprF',
                    "aLengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "fnDrawCallback": function() {
                        $("#proposalActivity").dialog('open');
                    }
                });
            //}
            return false;
        });

        $("#priceModifierValue").uniform();





    //$(document).on('click', '#groupShowProposal',  function() {
    $("#groupShowProposal").click(function () {
        var proposal_id = $(this).attr('data-proposal');

            swal({
                title: "Show Proposals?",
                text: "It will be visible to the customer until turned back off.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/groupShowProposalForExternal',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function( data){
                            swal(data.count+' Proposals Unhidden');
                            oTable.ajax.reload(null,false );
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal not hidden :)", "error");
                }
            });

    });


    $("#groupHideProposal").click(function () {

            swal({
                title: "Hide Proposals?",
                text: "It will be not visible to the customer until turned back on.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/groupHideProposalForExternal',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function( data){
                            swal(data.count+' Proposals Hidden');
                            oTable.ajax.reload(null,false );
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal not hidden :)", "error");
                }
            });

    });

        $("#groupProposalSignature").click(function () {

            $("#signature_proposal_id").val('');
            $("#signature_type").val('group');
            $('.signature_popup_title').html('<h4>Group Proposal Signature</h4>');
            check_signature_validation();
            reset_signature_form();
            $("#proposalSignatureDialog").dialog('open');

            resizeCanvas();

        return false;

        });
        

    $("#groupExcludeResend").click(function () {

            swal({
                title: "Proposals Email Off?",
                text: "Prevent proposals being sent in campaigns",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/groupExcludeResend',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function( data){
                            swal('', data.count+' Proposals Email Off');
                            oTable.ajax.reload(null,false );
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal was not Changed :)", "error");
                }
            });
    });

        $("#groupIncludeResend").click(function () {

            swal({
                title: "Proposals Email On?",
                text: "Proposal(s) can be included in email campaigns",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/groupIncludeResend',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function( data){
                            swal('', data.count+' Proposals Emails On');
                            oTable.ajax.reload(null,false );
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred. Please try again");
                        }
                    })
                } else {
                    swal("Cancelled", "Your Proposal was not changed :)", "error");
                }
            });

    });


        $("#groupEnableResend").click(function () {

            swal({
                title: "Enable Auto Resend?",
                text: "Proposals Auto resend enable",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/groupEnableResend',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function( data){
                            swal('', data.count+' Proposals Enable Auto Resend');
                            oTable.ajax.reload(null,false );
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal was not Changed :)", "error");
                }
            });
    });

     $("#groupDisableResend").click(function () {

            swal({
                title: "Disable Auto Resend?",
                text: "Proposals Auto resend disable",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/groupDisableResend',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function( data){
                            swal('', data.count+' Proposals Disable Auto Resend');
                            oTable.ajax.reload(null,false );
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal was not Changed :)", "error");
                }
            });
    });

        // Proposal Business Type Update
        $("#change-proposal-business-type").dialog({
            width: 500,
            modal: true,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button change_bt_popup_btn',
                    text: 'Save',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {proposal_id:$('#business_proposal_id').val(),businessTypes: $('.proposalBusinessType').val()},
                            url: "<?php echo site_url('ajax/proposalsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        }).success(function (data) {

                            $("#change-proposal-business-type").dialog('close');
                            swal('','Business Type Updated');

                        });
                    }
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            autoOpen: false
        });

        // Proposal User Permissions
        $("#proposal-user-permission").dialog({
            width: 850,
            modal: true,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button change_bt_popup_btn',
                    text: 'Save',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })

                        var permission_users = $('#proposal-user-permission').find('.account_users');
                        var users =[];
                        for($i=0;$i<permission_users.length;$i++){
                            //console.log('fff')
                            if($(permission_users[$i]).is(":checked")){
                                users.push($(permission_users[$i]).val());
                            }
                        }

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {proposal_id:$('#permission_proposal_id').val(),permission_users: users},
                            url: "<?php echo site_url('ajax/saveProposalUserPermission') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        }).success(function (data) {

                            //$("#change-proposal-business-type").dialog('close');
                            swal('','Proposal User Permissions Updated');
                            $("#proposal-user-permission").dialog('close');
                        });
                    }
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            autoOpen: false
        });


        // Proposal Sharing
        $("#proposal-sharing-dialog").dialog({
            width: 550,
            modal: true,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button change_bt_popup_btn',
                    text: 'Share',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        console.log($('#SeachaccountName').val());

                        // var permission_users = $('#proposal-sharing-dialog').find('.account_users');
                        // var users =[];
                        // for($i=0;$i<permission_users.length;$i++){
                        //     //console.log('fff')
                        //     if($(permission_users[$i]).is(":checked")){
                        //         users.push($(permission_users[$i]).val());
                        //     }
                        // }

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {proposal_id:$('#proposal_sharing_proposal_id').val(),share_user: $('#SeachaccountName').val()},
                            url: "<?php echo site_url('ajax/saveProposalSharing') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        }).success(function (data) {

                            //$("#change-proposal-business-type").dialog('close');
                            swal('','Proposal Shared');
                            $("#proposal-sharing-dialog").dialog('close');
                        });
                    }
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            autoOpen: false
        });
        
             // Proposal Views Dialog
        $("#sharedProposalUserDialog").dialog({
            width: 800,
            modal: true,
            buttons: {
                OK: function () {
                    $(this).dialog('close');
                }
            },
            autoOpen: false,
            position: 'top',
            open: function(event, ui) {
                $(this).parent().css({'top': window.pageYOffset + 150});
            },
        });

        $(document).on('click', ".manage_business_type", function () {
                var company_name = '<i class="fa fa-fw fa-file-text-o"></i> '+$(this).attr('data-projectname');
                var account_name = '<i class="fa fa-fw fa-building-o"></i> '+$(this).attr('data-proposal-account');
                var contact_name = '<i class="fa fa-fw fa-user-o"></i> '+$(this).attr('data-contact-name');
                $('.change-bt-proposal-name').html(company_name);
                $('.change-bt-account-name').html(account_name);
                $('.change-bt-contact-name').html(contact_name);
                proposal_id = $(this).attr('rel');
                $('.proposalBusinessType').val('');
                $('.proposalBusinessType').trigger("change");
                $('#business_proposal_id').val(proposal_id);
                $.ajax({
                        url: '<?php echo site_url('ajax/getProposalBusinessTyeps') ?>',
                        type:'post',
                        data:{proposal_id:proposal_id},
                        cache: false,
                        dataType: 'JSON',
                        success: function (response) {

                            if(response.success){
                                var selected_bt =[];
                                var bts = response.business_types;
                                if(response.business_types){
                                    $('.proposalBusinessType').val(response.business_types);
                                    $('.proposalBusinessType').trigger("change");
                                }

                            }
                            $("#change-proposal-business-type").dialog('open');
                            if(!$('#uniform-proposalBusinessType').length){
                                $('#proposalBusinessType').uniform();
                            }

                        }
                    });
                return false;

            });


            $(document).on('click', ".user_permission_btn", function () {
                // var company_name = '<i class="fa fa-fw fa-file-text-o"></i> '+$(this).attr('data-projectname');
                // var account_name = '<i class="fa fa-fw fa-building-o"></i> '+$(this).attr('data-proposal-account');
                // var contact_name = '<i class="fa fa-fw fa-user-o"></i> '+$(this).attr('data-contact-name');
                // $('.change-bt-proposal-name').html(company_name);
                // $('.change-bt-account-name').html(account_name);
                // $('.change-bt-contact-name').html(contact_name);
                var proposal_id = $(this).attr('data-proposal-id');
                var account_id = $(this).attr('data-account-id');
                var project_name = $(this).attr('data-project-name');
                // $('.proposalBusinessType').val('');
                // $('.proposalBusinessType').trigger("change");
                $('#permission_proposal_id').val(proposal_id);
                $('.permission_project_name').html(project_name);
                $('.account_users').prop('checked',false);
                $('.account_users').prop('disabled',false);
                $.ajax({
                        url: '<?php echo site_url('ajax/getProposalUserPermissionsWithUsers') ?>',
                        type:'post',
                        data:{proposal_id:proposal_id},
                        cache: false,
                        dataType: 'JSON',
                        success: function (response) {

                            if(response.success){

                                $("#proposal-user-permission").find('.padded').html(response.user_html);
                                
                                var users = response.user_permissions;
                                
                                for($i=0;$i < response.user_permissions.length;$i++){
                                    
                                    $('#account_users_'+response.user_permissions[$i]).prop('checked',true);
                                    $('#account_users_'+response.user_permissions[$i]).closest('.nice-label').addClass('user_permission_checked');
                                    
                                }
                                

                            }
                            $('#account_users_'+account_id).prop('checked',true);
                            $('#account_users_'+account_id).prop('disabled',true);
                            $('#account_users_'+account_id).closest('.nice-label').addClass('user_permission_checked');
                            $('#account_users_'+account_id).closest('.nice-label').addClass('permission_owner');
                            $("#proposal-user-permission").dialog('open');
                            
                             if(!$('#uniform-account_users_'+account_id).length){
                               
                                 $('.account_users').uniform();
                             }else{
                                $.uniform.restore(".account_users");
                                $('.account_users').uniform();
                             }

                        }
                    });
                return false;

            });

            $(document).on('click', ".proposal_sharing_btn", function () {
               
                var proposal_id = $(this).attr('data-proposal-id');
                var account_id = $(this).attr('data-account-id');
                var project_name = $(this).attr('data-project-name');
                
                $('#proposal_sharing_proposal_id').val(proposal_id);
                $('.proposal_sharing_project_name').html(project_name);
                

                $("#proposal-sharing-dialog").dialog('open');

                $("#proposal-sharing-dialog").find(".select2-selection__placeholder").text('Search User');
                    
                return false;

            });

                    // Show proposal views Popup
        $(document).on('click', ".proposal_shared_user_list_btn", function() {
            

            var proposalId = $(this).attr('data-proposal-id');
        
        
            var projectName = $(this).attr('data-project-name');

            loadSharedProposalUserTable(projectName,proposalId);
            
        });


        function loadSharedProposalUserTable(projectName,proposalId){

            swal({
                title: 'Loading..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                swal.showLoading();
                }
            })

        
        var tableUrl = 'ajax/sharedProposalUsers/'+proposalId;

        if (showSharedProposalUserTable) {
            
            showSharedProposalUserTable.destroy();
            $('#showSharedProposalUserTable').html('<thead><tr><th>User</th><th>Email</th><th>Company</th><th>Action</th></tr></thead><tbody></tbody>');
        }
        //else {
            // Shared User Datatable
            showSharedProposalUserTable = $("#showSharedProposalUserTable").DataTable({
                "order": [[1, "desc"]],
                "bProcessing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "scrollY": "300px",
                "ajax": {
                    "url": SITE_URL + tableUrl
                },
                "aoColumns": [
                    {'bVisible': true},
                    {'bVisible': true},
                    {'bSearchable': false, "class": 'dtCenter'},
                    {'bSearchable': false,'bSortable': false},
                    
                ],
                "bJQueryUI": true,
                "bAutoWidth": true,
                "sPaginationType": "full_numbers",
                "sDom": 'HfltiprF',
                "aLengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "fnDrawCallback": function() {
                    swal.close();
                    $(".shared_proposal_project_name").text(projectName);
                    $("#sharedProposalUserDialog").dialog('open');
                    initButtons();
                    initTiptip();
                }
            });

        return false;

        }

    $(document).on('change', ".account_users", function () {

        $(this).closest('.nice-label').toggleClass('user_permission_checked',$(this).is(':checked'));

    });

    // Handle Permission User  search
    $('.permissionUsersfilterSearch').on('input', function () {

        var searchVal = $(this).val();
        var parentCol = $(this).parents('#proposal-user-permission');

        if (searchVal.length) {
            console.log(searchVal)
            $(parentCol).find('.nice-label').hide();
            $(parentCol).find(".nice-label:iContains('" + searchVal + "')").show();
            $(parentCol).find(".clearFilterSearch").show();
        } else {
            $(parentCol).find(".nice-label").show();
            $(parentCol).find(".clearFilterSearch").hide();
        }

    });

    $(document).on('click', '.clearFilterSearch',  function() {
        var searchInput = $(this).next('.permissionUsersfilterSearch');
        $(searchInput).val('');
        $(searchInput).trigger('input');
    });

    $(document).on('click', '.exclude_resend_individual',  function() {
        var proposal_id = $(this).attr('rel');

            swal({
                title: "Proposal Email Off?",
                text: "It will Stop Email to this proposal from campaign.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/individualExcludeResend',
                        type: "POST",
                        data: {
                            "proposal_id": proposal_id,
                        },

                        success: function( data){
                            swal('Proposal Email Stop from Resend campaign');
                            oTable.ajax.reload(null,false );

                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal was nt changed:)", "error");
                }
            });

    });

    $(document).on('click', '.include_resend_individual',  function() {
        var proposal_id = $(this).attr('rel');

            swal({
                title: "Proposal Email On?",
                text: "Proposal can be included in email campaigns",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/individualIncludeResend',
                        type: "POST",
                        data: {
                            "proposal_id": proposal_id,
                        },

                        success: function( data){

                            swal('', 'Proposal Email is On');
                            oTable.ajax.reload(null,false );

                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal was not Changed :)", "error");
                }
            });

    });


    $(document).on('click', '.enable_auto_resend_individual',  function() {
        var proposal_id = $(this).attr('rel');

            swal({
                title: "Proposal Auto Resend Enable?",
                text: "It will enable Auto Resend Proposal.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/individualEnableAutoResend',
                        type: "POST",
                        data: {
                            "proposal_id": proposal_id,
                        },

                        success: function( data){
                            swal('Proposal Auto Resend Enable');
                            oTable.ajax.reload(null,false );

                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal was nt changed:)", "error");
                }
            });

    });

    $(document).on('click', '.disable_auto_resend_individual',  function() {
        var proposal_id = $(this).attr('rel');

            swal({
                title: "Proposal Auto Resend Disable?",
                text: "It will disable Auto Resend Proposal.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/individualDisableAutoResend',
                        type: "POST",
                        data: {
                            "proposal_id": proposal_id,
                        },

                        success: function( data){
                            swal('Proposal Auto Resend Disable');
                            oTable.ajax.reload(null,false );

                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal was nt changed:)", "error");
                }
            });

    });

    $(document).on('change', ".proposalBusinessType", function () {
        if($('.proposalBusinessType').val()==''){
            $('.change_bt_popup_btn').prop('disabled', true);
            $('.change_bt_popup_btn').addClass('ui-state-disabled');
        }else{
            $('.change_bt_popup_btn').prop('disabled', false);
            $('.change_bt_popup_btn').removeClass('ui-state-disabled');
        }

    });



    function check_highlighted_row(){
        if(localStorage.getItem("p_last_active_row")){
            var row_num =localStorage.getItem("p_last_active_row");
            $('#proposalsTable tbody').find("[data-proposal-id='"+row_num+"']").closest('tr').addClass('selectedRow');
        }
    }


    $(document).on('click', "#saveFilter", function () {


    if($('.activeFilter').length >0){
    swal({
        title: 'Save Filter',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: "Cancel",
        dangerMode: false,
        reverseButtons:false,
        html:
            '<input id="swal-input1" class="swal2-input" value="" Placeholder="Enter Filter Name"><br><span id="nameExist"></span>',

        preConfirm: function () {
                if($('#swal-input1').val()){

                    return new Promise(function (resolve) {
                    var name= $('#swal-input1').val();

                    $.ajax({
                        url: '<?php echo site_url('ajax/checkFilterName') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {name:name,type:'Proposal'},
                        success: function (response) {
                            if(response.success == true)
                            {
                               $('#nameExist').html("Filter Name Already Exist!");
                               $('#swal-input1').addClass("error");

                               return false;
                            }
                            else{
                                resolve(
                                    $('#swal-input1').val()

                                )
                            }
                        }
                    })

                    })
                }else{
                    alert('Please Enter the filter Name');
                }
            },
        onOpen: function () {
            $('#swal-input1').focus();
            $('.swal2-modal').attr('id','send_proposal_popup');
        }
        }).then(function (result) {

            swal('Saving..');

            $.ajax({
                        url: '/ajax/save_proposal_filter',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "proposal_filter": proposal_filter,
                            "filterName":result
                        },

                        success: function (data) {
                            if (!data.error) {
                                console.log(result);
                                var $cont = $('#saves_filter_list');
                                //var op = "<option value='" + 3 + "'>check apepnd</option>";
                                var op =  "<option  data-default-filter='0' data-filter='"+data.filter_data+"' value='"+data.filter_id+"'>"+result+"</option>";
                                if($cont.find('optgroup[id="saved_filters_lable"]').length>0){
                                    $cont.find('optgroup[id="saved_filters_lable"]').append(op);
                                }else{
                                    $('#saves_filter_list').append('<optgroup id="saved_filters_lable" label="Saved Filters">'+op+'</optgroup>')
                                }
                                swal('Filter saved')
                                //update_saved_filter()
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
        }).catch(swal.noop)
    }else{
        swal('','There are no Filters Applied!')
    }
   });

     $(".created_tabs").live('click', function () {
        $('#olderThenType').val('month');
        $('#newerThenType').val('month');
        $('#removeCreatedFilter').trigger('click');

        if($(this).val() =='created'){
            $('#created_inputs_tab').show();
            $('#older_then_inputs_tab').hide()
        }else{
            $('#older_then_inputs_tab').show();
            $('#created_inputs_tab').hide()
        }
        $.uniform.update();
     });


     // Validate email Address
     function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
     // Edit Contact Email
     $(document).on('click', ".editContactEmail", function () {
        var email = $(this).attr('data-contact-email');
        var clientId = $(this).attr('data-contact-id');
        var contact_name = $(this).attr('data-contact-name');
        var account_name = $(this).attr('data-account-name');
        
        swal({
            title: '',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
            reverseButtons:false,
            html:
            '<p style="text-align:center;font-weight:bold">Update Contact Email </p><p style="font-size:14px;text-align:center;margin-top: 10px;">'+account_name+': '+contact_name+'</p><input id="editContactEmail" class="swal2-input" style="margin: 18px 0px;" value='+email+' Placeholder="Enter Email Address"><br><span id="emailExist">Click Save to Update Email</span>',
            preConfirm: function () {
                if($('#editContactEmail').val()){

                    return new Promise(function (resolve) {
                    var email= $('#editContactEmail').val();
                        if(!(validateEmail(email))){
                            $('#emailExist').html("Please Enter Valid Email Address!");
                            $('#editContactEmail').addClass("error");
                        }else{
                            $('#emailExist').html("Click Save to Update Email");
                            $('#editContactEmail').removeClass("error");
                            resolve(
                                $('#editContactEmail').val()
                            )
                        }
                    })
                }else{
                    alert('Please Enter the Email Address');
                }
            },
        onOpen: function () {
            $('#editContactEmail').focus();
            $('.swal2-modal').attr('id','contact_email_address');
        }
        }).then(function(result) {
                    var newEmail = $('#editContactEmail').val();
                    swal('','Updating Contact Email');
                    $.ajax({
                        url: '<?php echo site_url('ajax/changeContactEmailAddress') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {email:newEmail,id:clientId},
                        success: function (response) {
                            if(response.success == true) {
                                oTable.ajax.reload(null,false );
                                swal('','Contact Email Address Updated');
                            }
                            else{
                                swal("Error", "An error occurred Please try again");
                                return false;
                            }
                        }
                    })
        })
    });

    // keyup for checking validation of email
    $(document).on("keyup","#editContactEmail",function(e) {
    if($(this).val()){
        var email = $(this).val();
        if(!(validateEmail(email))){
            $('#emailExist').html("Please Enter Valid Email Address!");
            $('#editContactEmail').addClass("error");
            $('#contact_email_address').find('.swal2-confirm').prop('disabled', true);
        }else{
            $('#emailExist').html("Click Save to Update Email");
            $('#editContactEmail').removeClass('error');
            $('#contact_email_address').find('.swal2-confirm').prop('disabled', false);
        }
    } else {
        $('#emailExist').html("Please Enter Email Address!");
        $('#editContactEmail').addClass("error");
        $('#contact_email_address').find('.swal2-confirm').prop('disabled', true);
    }
});








    


});// End document ready



    function shortenLargeNumber(num, digits) {
        var units = ['k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'],
            decimal;

        for (var i = units.length - 1; i >= 0; i--) {
            decimal = Math.pow(1000, i + 1);

            if (num <= -decimal || num >= decimal) {
                return +(num / decimal).toFixed(digits) + units[i];
            }
        }

        return num;
    }

    function datePreset(preset) {

        var startDate;
        var endDate;

        switch (preset) {

            case 'today':
                startDate = moment();
                endDate = moment();
                break;

            case 'yesterday':
                startDate = moment().subtract(1, 'days');
                endDate = moment().subtract(1, 'days');
                break;

            case 'last7days':
                startDate = moment().subtract(6, 'days');
                endDate = moment();
                break;

            case 'monthToDate':
                startDate = moment().startOf('month');
                endDate = moment();
                break;

            case 'previousMonth':
                startDate = moment().subtract(1, 'month').startOf('month');
                endDate = moment().subtract(1, 'month').endOf('month');
                break;

            case 'yearToDate':
                startDate = moment().startOf('year');
                endDate = moment();
                break;

            case 'previousYear':
                startDate = moment().subtract(1, 'year').startOf('year');
                endDate = moment().subtract(1, 'year').endOf('year');
                break;
        }

        var presetDate = {
            startDate: startDate.format('MM/DD/YYYY'),
            endDate: endDate.format('MM/DD/YYYY')
        };

        return presetDate;

    }



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

$(document).ready(function(){
    // Group Actions Button

    $("#tableColumnFilterButton").click(function () {
        hideInfoSlider();
        $("#newProposalColumnFilters").toggle();
        // Clear search so that filters aren't affected
       // oTable.fnFilter('');
        // Hide group action menu
        $(".groupActionsContainer").hide();
    });

    $(".close_column").click(function(){
        $("#newProposalColumnFilters").hide();
        
                var column_show = localStorage.getItem("proposals_win_column_show_1");

                if(column_show){
                    $(".column_show").attr('checked', false);
                    var column_show = column_show.split(',');

                    for($i=0;$i < column_show.length;$i++){
                        $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
                    }
                    $.uniform.update();
                }else{
                    $(".column_show").attr('checked', true);
                }
    })


    $('body').click( function(event) {

        var $trigger = $("#tableColumnFilterButton");


        if("tableColumnFilterButton" !== event.target.id && !$trigger.has(event.target).length){
           if($(event.target).parents('#newProposalColumnFilters').length==0 ){
               if(event.target.id !='newProposalColumnFilters'){
                $("#newProposalColumnFilters").hide();

                
                var column_show = localStorage.getItem("proposals_win_column_show_1");

                if(column_show){
                    $(".column_show").attr('checked', false);
                    var column_show = column_show.split(',');

                    for($i=0;$i < column_show.length;$i++){
                        $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
                    }
                    $.uniform.update();
                }else{
                    $(".column_show").attr('checked', true);
                }
               }

           }

        }


    var $trigger2 = $("#eventFilterButton");

      if('eventFilterButton' !== event.target.id && !$trigger2.has(event.target).length){
        $("#newProposalEventColumnFilters").hide();
     }

     var $trigger3 = $("#proposalsTableDropdownToggle");

      if('proposalsTableDropdownToggle' !== event.target.id && !$trigger3.has(event.target).length){
        if($(event.target).parents('#newProposalsPopup').length==0 ){
               if(event.target.id !='newProposalsPopup'){
                $("#newProposalsPopup").hide();


               }

           }

     }
       //$('.groupActionsContainer').hide();
       var $trigger4 = $("#groupActionsButton");

      if('groupActionsButton' !== event.target.id && !$trigger4.has(event.target).length){
        $(".groupActionsContainer").hide();

     }

   });

      // All
      $("#select_p_column_all").live('click', function () {
        $(".column_show").attr('checked', 'checked');
        $.uniform.update();
        //updateNumSelected()
        return false;
    });

    // None
    $("#select_p_column_none").live('click', function () {
        $(".column_show").attr('checked', false);
        $.uniform.update();
        //updateNumSelected()
        return false;
    });




});

function getFilterValue() {
    return $("#campaignEmailFilter").val();
}

$(document).on('click', ".proposalsTableDropdownToggle", function(e) {

    //console.log(document.getElementsByTagName("template")[0]);
    $('#newProposalsPopup').html('');
    $('#newProposalsPopup').show();
    $('.template_class').show();
    $(".template_class").find('.job_cost_report').css('display','none');
    $(".template_class").find('.job_costing').css('display','none');
    $(".template_class").find('.estimating').css('display','none');
    //$('.job_cost_report,.job_costing,.estimating').css('display','none');
    var template;
    var project_id = $(this).attr('data-project-id');
    var project_name = $(this).attr('data-project-name');
    var client_id = $(this).attr('data-client-id');
    var client_name = $(this).attr('data-client-name');
    var audit_key = $(this).attr('data-has-audit-key');
    var access_key = $(this).attr('data-access-key');
    var has_estimate = $(this).attr('data-has-estimate');
    var business_type = $(this).attr('data-business-type');
    var account_id = $(this).attr('data-account-id');
    var show_qbbtn = $(this).attr('data-show-qbbtn');
    var has_estimate_permission = $(this).attr('data-estimate-permission');
    var has_email_permission = $(this).attr('data-email-permission');
    var estimate_status = $(this).attr('data-estimate-status');
    var proposal_url = $(this).attr('data-proposal-url');
    var proposal_access_key = $(this).attr('data-proposal-access-key');
    var contact_name = $(this).attr('data-contact-name');
    var proposal_hidden = $(this).attr('data-proposal-hidden');
    var proposal_excluded = $(this).attr('data-proposal-excluded');
    var proposal_auto_resend = $(this).attr('data-proposal-auto-resend');
    var contact_email = $(this).attr('data-contact-email');
    var proposal_view = $(this).attr('data-proposal-views');
    var proposal_company_signature = $(this).attr('data-company-signature');
    var client_edit_permission = $(this).attr('data-client-edit-permission'); 
    var is_child_company = $(this).attr('data-is-child-company'); 
    var is_shared_proposal = $(this).attr('data-is-shared-proposal'); 
 
    if(show_qbbtn==1){
        $(".template_class").find('.qb_li_btn').css('display','block');
    }else{
        $(".template_class").find('.qb_li_btn').css('display','none');
    }

    if(proposal_hidden==1){
        $(".template_class").find('.hideProposal').css('display','none');
        $(".template_class").find('.showProposal').css('display','block');
    }else{
        $(".template_class").find('.hideProposal').css('display','block');
        $(".template_class").find('.showProposal').css('display','none');
    }

    if(proposal_excluded==1){
        $(".template_class").find('.exclude_resend_individual').css('display','none');
        $(".template_class").find('.include_resend_individual').css('display','block');
    }else{
        $(".template_class").find('.exclude_resend_individual').css('display','block');
        $(".template_class").find('.include_resend_individual').css('display','none');
    }

    if(proposal_auto_resend==1){
        $(".template_class").find('.enable_auto_resend_individual').css('display','none');
        $(".template_class").find('.disable_auto_resend_individual').css('display','block');
    }else{
        $(".template_class").find('.enable_auto_resend_individual').css('display','block');
        $(".template_class").find('.disable_auto_resend_individual').css('display','none');
    }

    

    if(proposal_company_signature==1){
        $(".template_class").find('.addProposalSignature').css('display','none');
        
    }else{
        $(".template_class").find('.addProposalSignature').css('display','block');
       
    }

    if(is_child_company==1){
        $(".template_class").find('.proposal_sharing_li').css('display','block');
        
    }else{
        $(".template_class").find('.proposal_sharing_li').css('display','none');
       
    }

    if(audit_key==''){
        $(".template_class").find('.has_audit').css('display','none');
    }else{
        $(".template_class").find('.has_audit').css('display','block');
    }
    if(proposal_view > 0){
        $('.action_proposal_view').css('display','block');
    }else{
        $('.action_proposal_view').css('display','none');
    }

    if(has_estimate_permission==1){
        //$(".template_class").find('.has_estimate').css('display','block');
        if(estimate_status==1){
            $(".template_class").find('.job_cost_report').css('display','block');
        }else if(estimate_status==2){
            $(".template_class").find('.job_costing').css('display','block');
        }else{
            $(".template_class").find('.estimating').css('display','block');
        }

    }

    if(client_edit_permission==0){
        $('.template_class').find('.edit_contact_li').addClass('disable_edit_contact');
    }else{
        $('.template_class').find('.edit_contact_li').removeClass('disable_edit_contact');
    }

    if(is_shared_proposal==1){
        $('.template_class').find('.is_shared_proposal').hide();
    }else{
        $('.template_class').find('.is_shared_proposal').show();
    }



    $("#estimatepreviewDialog").find('.dialog_project_name').text(project_name);
    $("#estimatepreviewDialog").find('.dialog_project_contact_name').text(client_name+' | '+contact_name);

    $("#estimatepreviewDialog").find('.dialog_project_name').attr('href','proposals/edit/'+project_id);

    $("#estimatepreviewDialog").find('.dialog_project_contact_name').attr('href','clients/edit/'+client_id+'/'+project_id);

    $("#workOrderDialog").find('.dialog_project_name').text(project_name);
    $("#workOrderDialog").find('.dialog_project_contact_name').text(client_name+' | '+contact_name);

    $("#workOrderDialog").find('.dialog_project_name').attr('href','proposals/edit/'+project_id);

    $("#workOrderDialog").find('.dialog_project_contact_name').attr('href','clients/edit/'+client_id+'/'+project_id);

    if(has_email_permission==1){

        $(".template_class").find('.has_email_permission').addClass('send_proposal_email');
        $(".template_class").find('.has_email_permission').removeClass('approval_proposal_email');
        $("#estimatepreviewDialog").find('.has_email_permission').addClass('send_proposal_email');
        $("#estimatepreviewDialog").find('.has_email_permission').removeClass('approval_proposal_email');

    }else{
        $(".template_class").find('.has_email_permission').removeClass('send_proposal_email');
        $(".template_class").find('.has_email_permission').addClass('approval_proposal_email');
        $("#estimatepreviewDialog").find('.has_email_permission').removeClass('send_proposal_email');
        $("#estimatepreviewDialog").find('.has_email_permission').addClass('approval_proposal_email');
    }

    template = $("#template").html();
    template = template.toString()

    template = template.replace(new RegExp('{proposalId}', 'g'), project_id);
    template = template.replace(new RegExp('{projectName}', 'g'), project_name);
    template = template.replace(new RegExp('{clientId}', 'g'), client_id);
    template = template.replace(new RegExp('{clientAccountName}', 'g'), client_name);
    template = template.replace(new RegExp('{audit_key}', 'g'), audit_key);
    template = template.replace(new RegExp('{access_key}', 'g'), access_key);
    template = template.replace(new RegExp('{has_estimate}', 'g'), has_estimate);
    template = template.replace(new RegExp('{business_type}', 'g'), business_type);
    template = template.replace(new RegExp('{account_id}', 'g'), account_id);
    template = template.replace(new RegExp('{proposalUrl}', 'g'), proposal_url);
    template = template.replace(new RegExp('{proposalAccessKey}', 'g'), proposal_access_key);
    template = template.replace(new RegExp('{contactName}', 'g'), contact_name);
    template = template.replace(new RegExp('{contactEmail}', 'g'), contact_email);

    $('#newProposalsPopup').html(template);


    $(".dialog_send_proposal").attr('data-val',project_id);
    $(".dialog_send_proposal").attr('data-project-name',project_name);
    $(".dialog_send_proposal").attr('data-client-id',client_id);
    $(".dialog_send_proposal").attr('data-project-contact',client_name);
    $(".dialog_send_proposal").attr('data-contact-name',contact_name);



});



$(document).on('click', "#estimatepreview", function(e) {
         var currSrc =$(this).attr('data-url');
        $(".proposal_download_btn").attr('href',currSrc+'/download');
        $(".proposal_tab_btn").attr('href',currSrc);
 
        $("#estimatepreviewDialog").dialog('open');
        $("#estimate-preview-iframe").hide();

        $("#estimatepreviewPDF").show();
        $("#estimatepreviewWEB").hide();

        $("#estimatepreviewPDF").attr("data-url", currSrc+'/print');
        $("#estimatepreviewWEB").attr("data-url", currSrc);
        $("#estimatepreviewDialog").find('.proposal_link_copy').attr("data-proposal-link", currSrc);
        // Show the loader
        $("#loadingFrame").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
 
        $("#estimate-preview-iframe").attr("src", currSrc);
        return false;

    });

    $(document).on('click', "#estimatepreviewPDF", function(e) {

        var currSrc =$(this).attr('data-url');
        $(".proposal_download_btn").attr('href',currSrc+'/download');
        $(".proposal_tab_btn").attr('href',currSrc);

        $("#estimatepreviewDialog").dialog('open');
        $("#estimate-preview-iframe").hide();

        $("#estimatepreviewPDF").hide();
        $("#estimatepreviewWEB").show();

        $("#estimatepreviewPDF").attr("data-url", currSrc+'/print');
        $("#estimatepreviewWEB").attr("data-url", currSrc);
        
        // Show the loader
        $("#loadingFrame").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#estimate-preview-iframe").attr("src", currSrc);
        return false;

    });

    $(document).on('click', "#estimatepreviewWEB", function(e) {

        var currSrc =$(this).attr('data-url');
        $(".proposal_download_btn").attr('href',currSrc+'/download');
         $(".proposal_tab_btn").attr('href',currSrc);

        $("#estimatepreviewDialog").dialog('open');
        $("#estimate-preview-iframe").hide();

        $("#estimatepreviewPDF").show();
        $("#estimatepreviewWEB").hide();
        
        $("#estimatepreviewPDF").attr("data-url", currSrc+'/print');
        $("#estimatepreviewWEB").attr("data-url", currSrc);

        // Show the loader
        $("#loadingFrame").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#estimate-preview-iframe").attr("src", currSrc);
        return false;

    });


    $(document).on('click', ".addProposalSignature", function(e) {

        $("#signature_type").val('single');
        $("#signature_proposal_id").val($(this).attr('rel'));
        $('.signature_popup_title').html($('.proposalMenuTitle').html())
        check_signature_validation();
        reset_signature_form();
        $("#proposalSignatureDialog").dialog('open');


        resizeCanvas();
       
        return false;

    });

    $(document).on('click', ".addCustomerChecklist", function(e) {
           $("#billing_proposal_id").val($(this).attr('rel'));
            check_customer_checklist_validation();
            reset_customer_checklist_form();
            $("#customerChecklistDialog").dialog('open');
            return false;
    });

    

    $(document).on("click", ".send_proposal_email", function(e) {

        if (is_approval_user) {
            swal({
                title: 'Loading..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 10000,
                onOpen: () => {
                swal.showLoading();
                $('.swal2-modal').attr('id','')
                }
            })
            var proposalId = $(this).attr('data-val');
            var thisVar = $(this);
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'proposalId': proposalId
                },
                url: "<?php echo site_url('ajax/checkProposalEmailApproval') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            }).success(function (data) {
                
                if (data.approval == '1') {
                    send_proposal_email(thisVar);
                } else {
                    approval_proposal_email(thisVar);
                }
            });

        } else {
            send_proposal_email(this)
        }
        return false;         
    });

    function send_proposal_email(e){
        var cc_setting = '<?php echo  ($account->getProposalEmailCC()) ? TRUE : FALSE; ?>';  
        email_to_input_count = 1; 
         var project_id = $(e).attr('data-val');
         var client_id = $(e).attr('data-client-id');
         var project_name = $(e).attr('data-project-name');
         var project_contact_name = $(e).attr('data-project-contact');
         var contact_name = $(e).attr('data-contact-name');
         tinymce.remove('#email_content');
         swal({
                    title: "<i class='fa fw fa-envelope'></i> Send Proposal",
                    html: '<p style="font-weight: bold; font-size: 14px;"><span style="float:left;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="tiptip" href="proposals/edit/'+project_id+'" title="Edit Project Info">'+project_name+'</a></span></span>'+
                          '<br/><span style="float:left;margin-top:3px" ><span style="display: block;float: left;margin-right:7px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left"  href="clients/edit/'+client_id+'/'+project_id+'">'+project_contact_name+' | '+contact_name+'</a></span></span></p><br><hr/>'+
                        '<form id="send_proposal_email" >'+
                        '<input type="hidden" id="send_proposal_id" name="send_proposal_id" value="'+project_id+'">'+
                        '<input type="hidden" class="" name="send_email" value="Send">'+
                        '<input type="hidden" name="proposal_id" value="'+project_id+'">'+
                        '<table class="boxed-table pl-striped" style="border-bottom:0px"; width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr>' +
                                '<td><label style="width: 150px;text-align: left;"> Email Template <span>*</span></label><span class="cwidth4_container" style="float: left;"><select style="border-radius: 3px;padding: 0.4em;width: 314px;" id="sendTemplateSelect"><?php foreach ($clientTemplates as $template) {?><option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo str_replace('\'', '\\\'', $template->getTemplateName()); ?></option><?php } ?></select></span></td>'+
                                '<td></td>' +
                            '</tr>'+
                            '<tr>' +
                                '<td colspan="2" class="send_proposal_to_field_td"><label for="" style="width: 150px;text-align: left;"> To <span>*</span></label><div class="send_proposal_to_field_div"><div class="buttonInside"><input type="text" id="popup_email_to" name="to[]" class="text send_to "   style="width: 300px; float: right;" required value=""><button type="button" class="add_email_to tiptiptop" title="Add More Emails"><i class="fa fa-plus" aria-hidden="true"></i></button></div></div></td>' +
                               
                            '</tr>'+
                            '<tr>' +
                                '<td><label for="" style="width: 150px;text-align: left;"> Subject <span>*</span></label><input type="text" name="subject" required class="text input60 number_field send_subject" title="Separate email addresses by commas" style="width: 300px; float: left;" id="poup_email_subject"  value=""></td>' +
                                '<td></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td colspan="2"><br/><textarea cols="40" rows="10" id="email_content" name="message">Loading...</textarea></td>'+
                            '</tr>' +
                        '</table>' +
                        '<input type="checkbox" value="1" name="ccIndividualEmail" id="ccIndividualEmail" style="float: left; margin: 10px;"><p style="font-size: 12px;font-weight: bold;padding: 10px 0px 8px 10px;"><span style="float: left;">Send me a copy of this email</span><span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span></p>'+
                        '</form>',

                    showCancelButton: true,
                    width: '950px',
                    confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
                    cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
                    dangerMode: false,
                    showCloseButton: true,
                    onOpen:function() {
                        $("#ccIndividualEmail").prop('checked', cc_setting);
                        tinymce.init({
                                selector: "#email_content",
                                relative_urls : false,
                                remove_script_host : false,
                                elementpath: false,
                                convert_urls : true,
                                menubar: false,
                                browser_spellcheck : true,
                                contextmenu :false,
                                paste_as_text: true,
                                height:'320',
                                setup:function(ed) {
                                    ed.on('keyup', function(e) {
                                        check_popup_validation()
                                    });
                                },
                                init_instance_callback : "loadTemplateContents",
                                plugins: "link image code lists paste preview ",
                                toolbar: tinyMceMenus.email,
                                forced_root_block_attrs: tinyMceMenus.root_attrs,
                                fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                            }); 

                        //loadTemplateContents();
                        $('.swal2-modal').attr('id','send_proposal_popup');

                        // Tiptip the address inputs
                        initTiptip();
                        // Uniform the select
                        $("#sendTemplateSelect").uniform();
                    }



                }).then(function (result) {

                    swal({
                                title: 'Sending..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 10000,
                                onOpen: () => {
                                swal.showLoading();
                                $('.swal2-modal').attr('id','')
                                }
                            })
                            var values, index;

                            // Get the parameters as an array
                            values = $("#send_proposal_email").serializeArray();
                            // Find and replace `content` if there
                            for (index = 0; index < values.length; ++index) {
                                if (values[index].name == "message") {
                                    values[index].value = tinyMCE.activeEditor.getContent();
                                    break;
                                }
                            }

                            console.log("value is showing ",values);

                            $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: values,
                                url: "<?php echo site_url('ajax/send_proposal_individual') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            }).success(function (data) {
                                tinymce.remove('#email_content');
                                oTable.ajax.reload(null,false );
                                swal('','Email Sent Successfully.<br/><br/>A copy of the email was also sent to you.');
                            });


     }).catch(swal.noop);;
     return false;
    }



     $(document).on("click",".approval_proposal_email",function(e) {
        approval_proposal_email(this);
        return false;
     });

     $(document).on("click",".add_email_to",function(e) {
        if(email_to_input_count < 5){
            $('.send_proposal_to_field_div').append('<div class="buttonInside"><input type="text"  name="to[]" class="text send_to"  style="width: 300px; float: right;" required value=""><button type="button" class="remove_email_to tiptiptop" title="Remove"><i class="fa fa-close" aria-hidden="true"></i></button></div>')
            initTiptip();
            email_to_input_count++;
        }
        
    });

    $(document).on("click",".remove_email_to",function(e) {
        $(this).closest('.buttonInside').remove();
    });
     

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    }

     function approval_proposal_email(e){
        var project_id = $(e).attr('data-val');

        var client_id = $(e).attr('data-client-id');
        var project_name = $(e).attr('data-project-name');
        var project_contact_name = $(e).attr('data-project-contact');
        template = $("#approval_email_template").html();
        template = template.toString()

         swal({
                    title: "<i class='fa fw fa-envelope'></i> Send Proposal in Approval Queue",
                    html: template,

                    showCancelButton: true,
                    width: '950px',
                    confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
                    cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
                    dangerMode: false,
                    showCloseButton: true,
                    onOpen:function() {
                        $('.approval_recipients').uniform();
                        $('.swal2-modal').attr('id','send_proposal_popup')
                    },



                }).then(function (result) {

                    var approval_recipients = $('#send_proposal_popup').find('.approval_recipients');
                        var recipients ={};
                        for($i=0;$i<approval_recipients.length;$i++){
                            //console.log('fff')
                            if($(approval_recipients[$i]).is(":checked")){
                                recipients[$(approval_recipients[$i]).attr('data-val')]=$(approval_recipients[$i]).val()
                            }
                        }

                        approval_msg = $('#send_proposal_popup').find('.approval_email_message').val();

                            swal({
                                title: 'Sending..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 10000,
                                onOpen: () => {
                                swal.showLoading();
                                //$('.swal2-modal').attr('id','')
                                }
                            });

                            $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: {
                                    'proposal_id':project_id,
                                    'recipients':recipients,
                                    'message':approval_msg
                                },
                                url: "<?php echo site_url('ajax/send_proposal_approval_request') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            }).success(function (data) {
                                oTable.ajax.reload(null,false )
                                swal('','Request Submited.');
                            });

                        return false;

                }).catch(swal.noop);



            return false;
     }

     function workOrder_ifram_load() {
        $("#loadingFrame2").hide();
        $("#workOrder-preview-iframe").show();
         $("#estimatePreviewDialog").dialog().parent().css('height', '85%');
    }

    function proposal_ifram_load() {
        $("#loadingFrame").hide();
        $("#estimate-preview-iframe").show();
        $("#estimatePreviewDialog").dialog().parent().css('height', '85%');
    }



     $(document).on("click",".workorder_send_btn",function(e) {
          var project_id = $(this).attr('data-val');
        //  var client_id = $(this).attr('data-client-id');
        //  var project_name = $(this).attr('data-project-name');
        //  var project_contact_name = $(this).attr('data-project-contact');
         template = $("#send_work_order_template").html();
         template = template.toString()

         swal({
            title: "<i class='fa fw fa-envelope'></i> Send Work Order",
            html: template,

            showCancelButton: true,
            width: '950px',
            confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
            cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
            dangerMode: false,
            showCloseButton: true,
            onOpen:function() {

                $('.swal2-modal').attr('id','send_proposal_popup')
                check_work_order_popup_validation();
                //initUI();
                $('.work_order_recipients').uniform();
                $('#send_proposal_popup').find('.selector').hide();
                //$.uniform.update();
            }
            }).then(function(){

                var additional_emails = $('#send_proposal_popup').find('.work_order_additional_emails').val();
                   //return false;

                    var work_order_recipients = $('#send_proposal_popup').find('.work_order_recipients');
                    var recipients ={};
                    for($i=0;$i<work_order_recipients.length;$i++){
                        //console.log('fff')
                        if($(work_order_recipients[$i]).is(":checked")){
                            recipients[$(work_order_recipients[$i]).attr('data-val')]=$(work_order_recipients[$i]).val()
                        }
                    }

                    swal({
                        title: 'Sending..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 10000,
                        onOpen: () => {
                        swal.showLoading();
                        //$('.swal2-modal').attr('id','')
                        }
                    })
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'additional_emails':additional_emails,
                            'proposal_id':project_id,
                            'recipients':recipients
                        },
                        url: "<?php echo site_url('ajax/send_work_order_ajax') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    }).success(function (data) {
                        console.log(data);
                        swal('','Work order email sent to all valid emails entered!');
                    });
            }).catch(swal.noop);

            return false;
     });


$(document).on("keyup","#poup_email_subject,#popup_email_to",function(e) {
    if($(this).val()){
        $(this).removeClass('error');

    }else{
        $(this).addClass('error');

    }
    check_popup_validation()

});

$(document).on("keyup","#swal-input1",function(e) {
    //$('#swal-input1').val()
    if($(this).val()){
        $.ajax({
                        url: '<?php echo site_url('ajax/checkFilterName') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {name:$('#swal-input1').val(),type:'Proposal'},
                        success: function (response) {
                            if(response.success == true)
                            {
                               $('#nameExist').html("Filter Name Alredy Exist!");
                               $('#swal-input1').addClass("error");

                            }
                            else{
                                $('#swal-input1').removeClass("error");
                                $('#nameExist').html("");
                            }
                        }
                    })

    }else{
        $(this).addClass('error');

    }


});

function check_popup_validation(){
    
    if(tinyMCE.activeEditor.getContent()=='' || $('#poup_email_subject').val() =='' || $('#popup_email_to').val()==''){
            
                
                $('.send_popup_validation_msg').show();
                $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
            
            
    }else{
        if(isValidEmailAddress($('#popup_email_to').val())){
            $('#popup_email_to').removeClass('error');
                $('.send_popup_validation_msg').hide();
                $('#send_proposal_popup .swal2-confirm').attr('disabled', false);
            }else{
                $('#popup_email_to').addClass('error');
                $('.send_popup_validation_msg').show();
                $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
            }
    }
}

$(document).on("keyup",".work_order_additional_emails",function(e) {
    if($(this).val()){
        $(this).removeClass('error');

    }else{
        $(this).addClass('error');

    }
    check_work_order_popup_validation()

});

function check_work_order_popup_validation(){


    if($("#send_proposal_popup .work_order_recipients:checkbox:checked").length < 1 && $('#send_proposal_popup .work_order_additional_emails').val() =='' ){

        $('.send_popup_validation_msg').show();
        $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
    }else{

        $('.send_popup_validation_msg').hide();
        $('#send_proposal_popup .swal2-confirm').attr('disabled', false);
    }
}



$(document).on("click",".work_order_recipients",function(e) {

    check_work_order_popup_validation();
});



             // Tmeplate change handler
        $(document).on("change","#sendTemplateSelect",function(e) {

            loadTemplateContents();
        });

        function loadTemplateContents(){

            var selectedTemplate = $('#sendTemplateSelect option:selected').data('template-id');

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'templateId': selectedTemplate,
                    'proposalId': $('#send_proposal_id').val()
                },
                url: "<?php echo site_url('account/ajaxGetProposalTemplateParsed') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            }).success(function (data) {
                $(".send_subject").val(data.templateSubject);
                if(!$(".send_to").val()){
                    $(".send_to").val(data.email_to);
                }
               
                if(data.templateBody){
                    tinymce.activeEditor.setContent(data.templateBody);
                }else{
                    tinymce.activeEditor.setContent('');
                }
            });

            $.uniform.update();
        }

$(document).on("click",".email_events",function(e) {
        $('#newClientsPopup').hide();

        var client_id = $(this).attr('data-client-id');
        var proposal_id = $(this).attr('data-proposal-id');
        var project_name = $(this).attr('data-project-name');
        var project_contact_name = $(this).attr('data-project-contact');
        var contact_name = $(this).attr('data-contact-name');
        tinymce.remove('#event_email_content');
        var table = '<p style="font-weight: bold; font-size: 16px;"><span style="position: absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="tiptip" href="proposals/edit/'+proposal_id+'" >'+project_name+'</a></span></span>'+
                    '<span style="right: 0px;position: absolute;" ><span style="display: block;float: left;margin-right:10px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left" class="tiptip" title="Edit " href="clients/edit/'+client_id+'/'+proposal_id+'">'+project_contact_name+' | '+contact_name+'</a></span></span></p><br><hr/><div class="filter_box_div" style="height:15px;"><a style="cursor:pointer;float:left;" title="Filter" class="btn tiptip toggle_email_types_checkboxes"><i class="fa fa-fw fa-filter"></i></a><div class="email_types_checkboxes" style="display:none"><?=$history_flags;?><div style="float:left;font-size: 14px;"><a href="#" id="selectAllEmailsType">All</a> / <a href="#" id="selectNoneEmailsType">None</a></div></div><div id="historyTableLoader" style="position: absolute;right: 100px;display: none;top: 44px;"><img src="/static/blue-loader.svg" /></div><a class="btn right blue-button reload_history_table" href="#" style="border-radius: 5px;padding: 5px 10px 5px 10px;font-size: 14px;margin-bottom: 10px;"><i class="fa fa-fw fa-refresh"></i> Reload</a></div>'+
                    '<table id="email_events_table" style="width:100%" ><thead><tr><th>Sent</th><th>Subject</th><th>From</th><th>To</th><th>Type</th><th class="delivery_column"><div class="badge blue tiptiptop" title="Delivery Status">D</div></th><th class="delivery_column"><div class="badge green tiptiptop" title="Open Status">O</div></th><th class="delivery_column"><i class="fa fa-envelope-o"></i></th></tr></thead><tbody>';


                    table +='</tbody></table><div style="display:none;" id="email_event_email_content_div"><div style="width:100%;float:left;font-size: 15px;margin-bottom: 15px;text-align:left;"><div style="width:30%;float:left;"><strong>Subject: </strong><span class="content_div_subject">Test subject</span></div><div style="width:30%;float:left;"><strong>From: </strong><span class="content_div_from">Sunil yadav</span></div><div style="width:30%;float:left;"><strong>To: </strong><span class="content_div_to">test@gmail.com</span></div><div style="width:10%;float:left;"><a style="font-size: 14px;margin-bottom: 5px;float:right;padding: 5px;position: relative;" class="show_email_event_table btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only " href="#" ><i class="fa fa-chevron-left"></i> Back</a></div><div style="width:100%;float:left;font-size: 15px;margin-bottom: 15px;margin-top: 7px;text-align:left;"><div style="width:30%;float:left;"><strong>Sent: </strong><span class="content_div_sent">07/14/20 1:24 PM</span></div><div style="width:30%;float:left;"><strong>Delivered: </strong><span class="content_div_delievered">07/14/20 1:24 PM</span></div><div style="width:30%;float:left;"><strong>Opened: </strong><span class="content_div_opened">07/14/20 1:24 PM</span></div><div style="width:10%"></div></div></div><div style="float:left;width: 100%;"><textarea id="event_email_content"></textarea></div></div>';

                   swal({
                        title: "<i class='fa fw fa-envelope'></i> Email History",
                        html: table,
                        showCancelButton: false,
                        width: '950px',
                        confirmButtonText: 'Ok',
                        dangerMode: false,
                        showCloseButton: true,
                    onOpen:function() {
                        $('.history_email_type').attr('checked',true);
                        $('.history_email_type').uniform();

                        tinymce.init({
                                selector: "textarea#event_email_content",
                                menubar: false,
                                elementpath: false,
                                relative_urls : false,
                                remove_script_host : false,
                                convert_urls : true,
                                toolbar : false,
                                height:'300',
                                readonly : 1
                        });

                        $('.swal2-modal').attr('id','send_proposal_popup')

                        hTable = $('#email_events_table').on('processing.dt', function (e, settings, processing) {
                                    if (processing) {
                                        $("#historyTableLoader").show();
                                    } else {
                                        $("#historyTableLoader").hide();
                                    }
                            }).DataTable({
                                "processing": true,
                                "serverSide": true,
                                "ajax": {
                                        url: "<?php echo site_url('ajax/get_proposal_email_events_table_data') ?>/" + proposal_id,
                                        data: function(d) {
                                            d.emailType = getEmailTypeValue();
                                        }
                                    },
                                "columns": [
                                                                // 2 Date
                                    {width: '25%',class: 'dtLeft pad_left_10'},                                            // 3 Branch
                                    {width: '25%',class: 'dtLeft'},                                            // 4 Readable status
                                    {width: '18%',class: 'dtLeft'},                              // 5 Status Link
                                    {width: '10%',class: 'dtLeft'},
                                    {width: '5%',class: 'dtCenter'},
                                    {width: '8%',class: 'dtCenter',sortable:false},
                                    {width: '7%',class: 'dtCenter',sortable:false},
                                    {width: '8%',class: 'dtCenter',sortable:false},
                                                                        // 7 Company
                                ],
                                "sorting": [
                                    [0, "desc"]
                                ],
                                "jQueryUI": true,
                                "autoWidth": true,
                                "stateSave": false,
                                "paginationType": "full_numbers",
                                "lengthMenu": [
                                    [10, 25, 50, 100, 200, 500, 1000],
                                    [10, 25, 50, 100, 200, 500, 1000]
                                ],

                                "drawCallback": function (settings) {

                                    initTiptip();

                                },


                            });


            },

        })

     });

     function getEmailTypeValue(){
        var email_types = [];
            $.each($("input[class='history_email_type']:checked"), function(){
                email_types.push($(this).val());
            });

        return email_types;
     }

     $(document).on("click",".history_email_type",function(e) {
        hTable.ajax.reload(null,false )
     });

     // All
    $("#selectAllEmailsType").live('click', function () {
        $(".history_email_type").attr('checked', 'checked');
        hTable.ajax.reload(null,false )
        $.uniform.update();
        return false;
    });

    // None
    $("#selectNoneEmailsType").live('click', function () {
        $(".history_email_type").attr('checked', false);
        hTable.ajax.reload(null,false )
        $.uniform.update();
        return false;
    });

     $(document).on("click",".reload_history_table",function(e) {
        hTable.ajax.reload(null,false )
     });

     $(document).on("click",".toggle_email_types_checkboxes",function(e) {
        $(".email_types_checkboxes").toggle();
        // $(".email_types_checkboxes").animate({
        //         width: "toggle"
        //     });
     });


     $(document).on("click",".email_event_email_show_span",function(e) {
        var event_id = $(this).attr('data-event-id');
        var sent_at = $(this).attr('data-sent');
        var delievered_at = $(this).attr('data-delivered');
        var opened_at = $(this).attr('data-opened');
        $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {'event_id': event_id},
                url: "<?php echo site_url('ajax/get_email_event_email_content') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
            .success(function (data) {

                //CKEDITOR.instances.event_email_content.setData(data.email_content);
                tinymce.get("event_email_content").setContent(data.email_content);
                $('.content_div_subject').text(data.email_subject);
                $('.content_div_from').text(data.sender_name);
                $('.content_div_to').text(data.to_email ? data.to_email : '-');
                $('.content_div_sent').text(sent_at);
                $('.content_div_delievered').text(delievered_at);
                $('.content_div_opened').text(opened_at);
                $('#email_events_table_wrapper').hide();
                $('.filter_box_div').hide();

                $('#email_event_email_content_div').show();
            });

     });

     $(document).on("click",".show_email_event_table",function(e) {

        $('#email_events_table_wrapper').show();
        $('.filter_box_div').show();
        $('#email_event_email_content_div').hide();
     })

    $(document).on("click","#workorderpreview",function(e) {
        var temp_base_url ='<?php echo  site_url();?>';
        var access_key = $(this).attr('data-access-key');
        var project_name = $(this).attr('data-project-name');
        var proposal_id = $(this).attr('data-val');
        var send_url = temp_base_url+'proposals/edit/'+proposal_id+'/preview_workorder';
        var currSrc = temp_base_url+'work_order/'+access_key+'/noDownload';
        var downloadCurrSrc = temp_base_url+'proposals/live/view/work_order/'+access_key+'.pdf';

        $(".workorder_download_btn").attr('href',downloadCurrSrc);
        $(".workorder_download_btn").attr('download',project_name.replace(".", "")+'- Work Order');
        $("#work_order_url_link").val(downloadCurrSrc);
        $(".workorder_send_btn").attr('data-val',proposal_id);
        $("#workOrderDialog").dialog('open');
        $("#workOrder-preview-iframe").hide();

        $("#workorderpreviewPDF").show();
        $("#workorderpreviewWEB").hide();
        
        $("#workorderpreviewPDF").attr('data-access-key',access_key);
        $("#workorderpreviewPDF").attr('data-val',proposal_id);
        $("#workorderpreviewWEB").attr('data-access-key',access_key);
        $("#workorderpreviewWEB").attr('data-val',proposal_id);
        // Show the loaderm
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#workOrder-preview-iframe").attr("src", currSrc);
        return false;
    });

 
       $(document).on("click","#workorderpreviewPDF",function(e) {
        var temp_base_url ='<?php echo  site_url();?>';
        var access_key = $(this).attr('data-access-key');
        var proposal_id = $(this).attr('data-val');
        var send_url = temp_base_url+'proposals/edit/'+proposal_id+'/preview_workorder';
        var currSrc = temp_base_url+'work_order/'+access_key+'/noDownload';
        var downloadCurrSrc = temp_base_url+'proposals/live/view/work_order/'+access_key+'.pdf';

        $(".workorder_download_btn").attr('href',downloadCurrSrc);
        $("#work_order_url_link").val(downloadCurrSrc);
        $(".workorder_send_btn").attr('data-val',proposal_id);
        $("#workOrderDialog").dialog('open');
        $("#workOrder-preview-iframe").hide();

        $("#workorderpreviewPDF").hide();
        $("#workorderpreviewWEB").show();

        // Show the loaderm
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#workOrder-preview-iframe").attr("src", downloadCurrSrc);
        return false;
    });




    $(document).on("click","#workorderpreviewWEB",function(e) {
        var temp_base_url ='<?php echo  site_url();?>';
        var access_key = $(this).attr('data-access-key');
        var proposal_id = $(this).attr('data-val');
        var send_url = temp_base_url+'proposals/edit/'+proposal_id+'/preview_workorder';
        var currSrc = temp_base_url+'work_order/'+access_key+'/noDownload';
        var downloadCurrSrc = temp_base_url+'proposals/live/view/work_order/'+access_key+'.pdf';

        $(".workorder_download_btn").attr('href',downloadCurrSrc);
        $("#work_order_url_link").val(downloadCurrSrc);
        $(".workorder_send_btn").attr('data-val',proposal_id);
        $("#workOrderDialog").dialog('open');
        $("#workOrder-preview-iframe").hide();

        $("#workorderpreviewPDF").show();
        $("#workorderpreviewWEB").hide();
        // Show the loaderm
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#workOrder-preview-iframe").attr("src", currSrc);
        return false;
    });


$(document).on("click",".workorder_link_copy",function(e) {

    $('.workorder_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Link Copied');
    const el = document.createElement('textarea');
    el.value = $('#work_order_url_link').val();
    document.body.appendChild(el);
    el.select();
    document.execCommand("copy");
    document.body.removeChild(el);
    //$('.flash_copy_msg').fadeIn()
    setTimeout(function(){
        $('.workorder_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Copy Link');// or fade, css display however you'd like.
}, 3000);
    return false;
});


$(document).on("click",".proposal_link_copy",function(e) {

    if($(this).attr('data-action') != 1){
        $('.proposal_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Link Copied');
    }
    const el = document.createElement('textarea');
    el.value = $(this).attr('data-proposal-link');
    document.body.appendChild(el);
    el.select();
    document.execCommand("copy");
    document.body.removeChild(el);
    //$('.flash_copy_msg').fadeIn()
    
    if($(this).attr('data-action') == 1){
        swal('','Proposal Link Copied')
    }else{
        setTimeout(function(){
            $('.proposal_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Copy Link');// or fade, css display however you'd like.
        }, 3000);
    }
    
    return false;
});



    $(document).on("click", ".previewProposalImages", function () {
        var proposalId = $(this).data('proposal-id');
        swal('', 'Loading your images');
        swal.showLoading();

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {'proposal_id': proposalId},
            url: "<?php echo site_url('ajax/getProposalImagePreviewData') ?>",
            dataType: "JSON"
        })
        .success(function (data) {

            $("#proposalPreviewContent").empty();

            $("#proposalPreviewDialog").dialog('option', 'title', 'Proposal: ' + data.proposal.title)

            if (data.images.length) {

                var i = 1;

                $.each(data.images, function(index, img) {

                    var imgHtml = '<div class="proposalImgPreviewContainer">' +
                        '<p style="font-weight: bold; text-align: center; max-width: 230px; height: 25px; text-overflow: ellipsis; margin-bottom: 3px;">' + i + '. ' + img.title + '</p>' +
                        '<p style="font-weight: bold; text-align: center; max-width: 230px; height: 25px; text-overflow: ellipsis; margin-bottom: 3px;">' + img.serviceName + '</p>' +
                        '<a class="proposalPreviewLink" rel="previewImageGallery" href="' + img.image + '" title="' + img.title + '">' +
                            '<img src="' + img.image + '" class="proposalImgPreview" id="proposaImgPreview' + index + '" style="width: ' + img.width + '; margin-left: ' + img.paddingLeft + 'px; max-height: 200px;"/>' +
                        '</a>';


                    var layoutNum = 1;

                    imgHtml += '<p class="proposalImagePreviewFooter">';

                    if (img.proposal) {
                        imgHtml += '<span class="superScript grey_b tiptip" title="Show in Proposal" style="float: left; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff; margin-right: 5px;">P</span>';
                    }

                    if (img.work_order) {
                        imgHtml += '<span class="superScript grey_b tiptip" title="Show in Work Order" style="float: left; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff; margin-right: 5px;">WO</span>';
                    }
                    if (img.layout == 1) {
                        layoutNum = 2;
                    }

                    if (img.layout == 2) {
                        layoutNum = 4;
                    }

                    imgHtml += '<span class="superScript grey_b tiptip" title="' + layoutNum + ' per page" style="float:right; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff;">' + layoutNum + ' <i class="fa fa-fw fa-picture-o"></i></span>';

                    if (img.notes) {
                        imgHtml += '<span class="superScript grey_b tiptip" title="' + img.notes.replace(/(<([^>]+)>)/gi, "") + '" style="float:right; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff; margin-right: 5px;"><i class="fa fa-fw fa-file-text-o"></i></span>';
                    }

                    imgHtml += '</p>';
                    imgHtml += '</div>';

                    $("#proposalPreviewContent").append(imgHtml);
                    i++;
                });

                initTiptip();
                $("a.proposalPreviewLink").fancybox({
                    openEffect: 'none',
                    closeEffect: 'none',
                    nextEffect: 'fade',
                    prevEffect: 'fade',
                });


                if (data.images.length == 1) {
                    $("#proposalPreviewDialog").dialog('option', 'width', 900);
                }
                if (data.images.length == 2) {
                    $("#proposalPreviewDialog").dialog('option', 'width', 900);
                }
                if (data.images.length > 2) {
                    $("#proposalPreviewDialog").dialog('option', 'width', 900);
                }

                setTimeout(function() {
                    swal.close();
                    $("#proposalPreviewDialog").dialog('open');
                    //$("#proposalPreviewDialog").dialog("option", "position", "center");
                }, 1500);
            }
        });

        return false;
    });


$(document).on('click', '#proposalsTable tbody td a, #proposalsTable tbody td span',  function() {
    $('tr.selectedRow').removeClass('selectedRow');
    $(this).parents('tr').addClass('selectedRow');
    var row_num = $(this).closest('tr').find('td:eq(0) input[type="checkbox"]').attr('data-proposal-id');
    if(hasLocalStorage){
        localStorage.setItem("p_last_active_row", row_num);
    }

});

$(document).on('click', '.javascript_loaded',  function(e) {
    $('tr.selectedRow').removeClass('selectedRow');
    if(hasLocalStorage){
        localStorage.setItem("p_last_active_row", '');
    }
});

$(document).on('click', '.hideProposal',  function() {
        var proposal_id = $(this).attr('data-proposal');

            swal({
                title: "Hide Proposal?",
                text: "It will not be visible to the customer until turned back on.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/hideProposalForExternal',
                        type: "POST",
                        data: {
                            "proposal_id": proposal_id,
                        },

                        success: function( data){

                            console.log('hide');
                            swal('Proposal Hidden');
                            oTable.ajax.reload(null,false );

                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal not hidden :)", "error");
                }
            });

    });


    $(document).on('click', '.showProposal',  function() {
        var proposal_id = $(this).attr('data-proposal');

            swal({
                title: "Show Proposal?",
                text: "It will be visible to the customer until turned back off.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/showProposalForExternal',
                        type: "POST",
                        data: {
                            "proposal_id": proposal_id,
                        },

                        success: function( data){

                            console.log('show');
                            swal('Proposal Visible');
                            oTable.ajax.reload(null,false );

                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal not hidden :)", "error");
                }
            });

    });


        // Copy work order link
        $(document).on('click', ".add_proposal_btn", function () {
            $('#add_proposal_contact_id_hidden').val('');
            $('#add_proposal_select_btn').hide();
            $("#addProposalDialog").dialog('open');
            setTimeout(function() {
                        $('#SeachcontactName').select2('open');
                        if($('.add_new_class').length<1){
                                $('.select2-results').after('<span class="add_new_class"><ul style="padding: 7px;border-top: 1px solid #ccc;"><li><a href="<?php echo  site_url();?>clients/add/proposal"  style="color: #25AAE1;font-size:14px;"><i class="fa fa-fw fa-plus"></i> Create New Contact</li></ul></span>');
                            }
                    }, 400);
        });

        $(document).on('click', "#add_proposal_select_btn", function () {
            var contact_id = $('#add_proposal_contact_id_hidden').val();
           if(contact_id){
             window.location.href = '<?php echo  site_url();?>proposals/add/'+contact_id;
           }

        });



//Select2 start

    $("#SeachcontactName").select2({
    ajax: {
        url: '<?php echo site_url('ajax/ajaxSelect2SearchClients') ?>',
        dataType: 'json',
        delay: 250,

        data: function (params) {
        return {
            startsWith: params.term, // search term
            firstName: '',
            lastName: '',
            page: params.page
        };
        },
        processResults: function (data, params) {

        params.page = params.page || 1;
        if($('.add_new_class').length<1){
            $('.select2-results').after('<span class="add_new_class"><ul style="padding: 7px;border-top: 1px solid #ccc;"><li><a href="javascript:void(0);" onclick="add_new_lead()" style="color: #25AAE1;">+ New Contact</li></ul></span>');
        }

        return {
            results: data.items,
            pagination: {
            more: (params.page * 30) < data.total_count
            }
        };


        //'<span class="select2-results"><ul class="select2-results__options" role="listbox" id="select2-SeachcompanyName-results" aria-expanded="true" aria-hidden="false"><li role="alert" aria-live="assertive" class="select2-results__option select2-results__message">+Add New</li></ul></span>';
        },
        cache: true
    },
    placeholder: 'Search for a repository',
    allowClear: true,
    debug: true,
    minimumInputLength: 1,
    language: {
        inputTooShort: function () { return ''; },
        noResults: function(){
            return "Contact Not Found";
        }
    },
    templateResult: formatRepo2,
    templateSelection: formatRepoSelection2
    });


function formatRepo2 (repo) {
  if (repo.loading) {
    return repo.label;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +

      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Account:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Contact:</th><td class='select2-result-repository_contact'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Address:</th><td class='select2-result-repository_address'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Owner:</th><td class='select2-result-repository_owner'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Proposals:</th><td class='select2-result-repository_proposal'></td></tr>"+
      "</div>" +
    "</div>"
  );

  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_contact").text(repo.contact);
  $container.find(".select2-result-repository_address").html(repo.address);
  $container.find(".select2-result-repository_owner").text(repo.owner);
  $container.find(".select2-result-repository_proposal").html(repo.proposals_count);

  return $container;
}

function formatRepoSelection2 (repo) {
  return '('+repo.label+') ' + repo.contact ;
}
$(".select2-selection__placeholder").text('Search existing Contact/Company')

$('#SeachcontactName').on("select2:selecting", function(e) {
   // what you would like to happen

   var select_id = e.params.args.data.id;
   $('#add_proposal_contact_id_hidden').val(select_id)
   $('#add_proposal_select_btn').show();
    event.preventDefault();
});


//Proposal sharing Search User select2

$("#SeachaccountName").select2({
    ajax: {
        url: '<?php echo site_url('ajax/ajaxSelect2SearchProposalShareUser') ?>',
        dataType: 'json',
        delay: 250,
        
        data: function (params) {
        return {
            startsWith: params.term, // search term
            proposal_id: $('#proposal_sharing_proposal_id').val(),
        };
        },
        processResults: function (data, params) {
        
        params.page = params.page || 1;
        // if($('.add_new_class').length<1){
        //     $('.select2-results').after('<span class="add_new_class"><ul style="padding: 7px;border-top: 1px solid #ccc;"><li><a href="javascript:void(0);" onclick="add_new_lead()" style="color: #25AAE1;">+ New Contact</li></ul></span>');
        // }
        
        return {
            results: data.items,
            pagination: {
            more: (params.page * 30) < data.total_count
            }
        };
        

        //'<span class="select2-results"><ul class="select2-results__options" role="listbox" id="select2-SeachcompanyName-results" aria-expanded="true" aria-hidden="false"><li role="alert" aria-live="assertive" class="select2-results__option select2-results__message">+Add New</li></ul></span>';
        },
        cache: true
    },
    placeholder: 'Search for a User',
    allowClear: true,
    debug: true,
    minimumInputLength: 1,
    language: {
        inputTooShort: function () { return ''; },
        noResults: function(){
            return "User Not Found";
        }
    },
    templateResult: formatRepoProposalshare,
    templateSelection: formatRepoSelectionProposalshare
    });


function formatRepoProposalshare (repo) {
  if (repo.loading) {
    return repo.label;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      
      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Name:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Email:</th><td class='select2-result-repository_email'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Company:</th><td class='select2-result-repository_company'></td></tr>"+
      "</div>" +
    "</div>"
  );
  
  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_email").text(repo.email);
  $container.find(".select2-result-repository_company").html(repo.company);

  return $container;
}

function formatRepoSelectionProposalshare (repo) {
    
    if(repo.label){
        return '('+repo.label+') ' + repo.company;
    }else{
        return 'Search User';
    }
    
    
    
    }



function notes_tooltip() {

$(".proposal_table_notes_tiptip").tipTip({   delay :200,
        maxWidth : "400px",
        context : this,
        defaultPosition: "right",
        content: function (e) {

          setTimeout( function(){
             currentXhr = $.ajax({
                        url: '<?php echo site_url('ajax/getTableNotes') ?>',
                        type:'post',
                        data:{relationId:notes_tiptip_proposal_id,type:'proposal'},
                        cache: false,
                        success: function (response) {
                            $('#tiptip_content').html(response);
                            //console.log('ffffggg')
                        }
                    });
                },200);
                    return 'Loading...';
                }
    });
};

function price_breakdown_tooltip() {

$(".proposal_table_price_breakdown_tiptip22").tipTip({   delay :200,
        maxWidth : "400px",

        content: function (e) {

          setTimeout( function(){
         currentXhr = $.ajax({
                        url: '<?php echo site_url('ajax/getProposalPriceBreakdown') ?>',
                        type:'post',
                        data:{proposalId:price_breakdown_tiptip_proposal_id},
                        cache: false,
                        success: function (response) {
                            $('#tiptip_content').html(response);
                            //console.log('ffffggg')
                        }
                    });
                },200);
                    return 'Loading...';
                }
    });
};

function proposal_name_tooltip() {

$(".proposal_table_proposal_name_tiptip22").tipTip({   delay :200,
        maxWidth : "400px",

        content: function (e) {

          setTimeout( function(){
         currentXhr = $.ajax({
                        url: '<?php echo site_url('ajax/getProposalNameTiptip') ?>',
                        type:'post',
                        data:{proposalId:proposal_name_tiptip_proposal_id},
                        cache: false,
                        success: function (response) {
                            $('#tiptip_content').html(response);
                            //console.log('ffffggg')
                        }
                    });
                },200);
                    return 'Loading...';
                }
    });
};

 $(document).on('mouseenter', ".proposal_table_notes_tiptip", function () {
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    notes_tiptip_proposal_id = $(this).data('val');
    return false;
});

$(document).on('mouseover', ".proposal_table_price_breakdown_tiptip", function () {
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    $this = this;
    if($($this).hasClass('addTiptip')){
        return false;
    }
    price_breakdown_tiptip_proposal_id = $(this).data('proposal-id');
    currentXhr = $.ajax({
                        url: '<?php echo site_url('ajax/getProposalPriceBreakdown') ?>',
                        type:'post',
                        data:{proposalId:price_breakdown_tiptip_proposal_id},
                        cache: false,
                        success: function (response) {
                            //$('#tiptip_content').html(response);
                            $($this).tipTip({
                                delay: 200,
                                defaultPosition:'top',
                                maxWidth: '400px',
                                content: decodeURI(response),
                            });
                            $($this).addClass('addTiptip')
                            $($this).trigger('mouseenter');
                        }
                    });
    return false;
});
$(document).on('mouseout', ".proposal_table_price_breakdown_tiptip", function () {
    $this = this;
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }

});
$(document).on('mouseout', ".proposal_table_proposal_name_tiptip", function () {
    $this = this;
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    if($($this).hasClass('addTiptip')){
        $($this).removeClass('addTiptip')
        return false;
    }
});

$(document).on('mouseover', ".proposal_table_proposal_name_tiptip", function () {
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    $this = this;
    if($($this).hasClass('addTiptip')){
        return false;
    }
    proposal_name_tiptip_proposal_id = $(this).data('proposal-id');
    currentXhr = $.ajax({
                    url: '<?php echo site_url('ajax/getProposalNameTiptip') ?>',
                    type:'post',
                    data:{proposalId:proposal_name_tiptip_proposal_id},
                    cache: false,
                    success: function (response) {
                        $($this).tipTip({
                            delay: 200,
                            defaultPosition:'top',
                            maxWidth: '400px',
                            content:response,
                        });

                        $($this).addClass('addTiptip');
                        $($this).trigger('mouseenter');
                    }
                });
    return false;
});


// User permission user tiptip

$(document).on('mouseout', ".proposal_table_permission_user_name_tiptip", function () {
    $this = this;
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    if($($this).hasClass('addTiptip')){
        $($this).removeClass('addTiptip')
        return false;
    }
});

$(document).on('mouseover', ".proposal_table_permission_user_name_tiptip", function () {
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    $this = this;
    if($($this).hasClass('addTiptip')){
        return false;
    }
    proposal_name_tiptip_proposal_id = $(this).data('proposal-id');
    currentXhr = $.ajax({
                    url: '<?php echo site_url('ajax/getProposalPermissionUserTiptip') ?>',
                    type:'post',
                    data:{proposalId:proposal_name_tiptip_proposal_id},
                    cache: false,
                    success: function (response) {
                        $($this).tipTip({
                            delay: 200,
                            defaultPosition:'top',
                            maxWidth: '400px',
                            content:response,
                        });

                        $($this).addClass('addTiptip');
                        $($this).trigger('mouseenter');
                    }
                });
    return false;
});


//Signee details tooltip
$(document).on('mouseout', ".proposal_signee_details_tiptip", function () {
    $this = this;
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    if($($this).hasClass('addTiptip')){
        $($this).removeClass('addTiptip')
        return false;
    }
});

$(document).on('mouseover', ".proposal_signee_details_tiptip", function () {
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    $this = this;
    if($($this).hasClass('addTiptip')){
        return false;
    }
    proposal_name_tiptip_proposal_id = $(this).data('proposal-id');
    currentXhr = $.ajax({
                    url: '<?php echo site_url('ajax/getProposalSigneeTiptip') ?>',
                    type:'post',
                    data:{proposalId:proposal_name_tiptip_proposal_id},
                    cache: false,
                    success: function (response) {
                        $($this).tipTip({
                            delay: 200,
                            defaultPosition:'right',
                            maxWidth: '400px',
                            content:response,
                        });

                        $($this).addClass('addTiptip');
                        $($this).trigger('mouseenter');
                    }
                });
    return false;
});


$(document).on('mouseout', ".proposal-table-duplicate-name", function () {
    $this = this;
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    if($($this).hasClass('addTiptip')){
        $($this).removeClass('addTiptip')
        return false;
    }
});

$(document).on('mouseover', ".proposal-table-duplicate-name", function () {
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    $this = this;
    if($($this).hasClass('addTiptip')){
        return false;
    }
    proposalId = $(this).data('proposal-id');

    currentXhr = $.ajax({
        url: '<?php echo site_url('ajax/proposalDuplicateTiptip') ?>',
        type:'post',
        data:{
            proposalId: proposalId
        },
        cache: false,
        success: function (response) {
            $($this).tipTip({
                delay: 200,
                defaultPosition:'top',
                maxWidth: '400px',
                content:response,
            });

            $($this).addClass('addTiptip');
            $($this).trigger('mouseenter');
        }
    });

    return false;
});


function check_signature_validation(){
    
    if($('#signature_firstname').val() =='' || $('#signature_lastname').val()=='' || $('#signature_company_name').val() =='' || $('#signature_title').val()=='' || !isEmail($('#signature_email').val()) ||
    $('#signature_address').val() =='' || $('#signature_city').val()=='' || $('#signature_state').val() =='' || $('#signature_zip').val()=='' || $('#signature_office_phone').val()=='' || $('#signature_cell_phone').val()=='' || $('#signature_office_phone').val()=='___-___-____' || $('#signature_cell_phone').val()=='___-___-____'){
            $('.signature_validation_msg').show();
            $(".signature_save_btn").prop("disabled", true).addClass("ui-state-disabled");
            return false;
    }else{
        $('#proposalSignatureDialog input').removeClass('error');
        $('.signature_validation_msg').hide();
        
        $(".signature_save_btn").prop("disabled", false).removeClass("ui-state-disabled");
        return true;
    }
}



function reset_signature_form(){
    
    $('#signature_firstname').val('');
    $('#signature_lastname').val('');
    $('#signature_company_name').val('');
    $('#signature_title').val('');
    $('#signature_email').val('');
    $('#signature_comments').val('');

    $('#signature_address').val('');
    $('#signature_city').val('');
    $('#signature_state').val('');
    $('#signature_zip').val('');
    $('#signature_cell_phone').val('');
    $('#signature_office_phone').val('');

    $('.signature_validation_msg,.signature_msg').hide();

    resizeCanvas();
    reset_choose_sign();
}


$(document).on("keyup","#signature_firstname,#signature_lastname,#signature_company_name,#signature_title,#signature_address,#signature_city,#signature_state,#signature_zip,#signature_office_phone,#signature_cell_phone",function(e) {
    
    if($(this).val() || $(this).val()!='___-___-____'){
        $(this).removeClass('error');

    }else{
        $(this).addClass('error');

    }
    check_signature_validation()

});

$(document).on("keyup","#signature_email",function(e) {
    if(isEmail($(this).val())){
        
            $(this).removeClass('error');
         
    }else{
       
        $(this).addClass('error');

    }
    check_signature_validation()

});


/*customer check list */


function reset_customer_checklist_form(){
    
    $('#billing_contact').val('');
    $('#billing_address').val('');
    $('#billing_email').val('');
    $('#property_owner_name').val('');
    $('#legal_address').val('');
    $('#customer_phone').val('');
    $('#billing_phone').val('');
    $('#customer_email').val('');
    $('#onsite_contact').val('');
    $('#onsite_phone').val('');
    $('#onsite_email').val('');
    $('#invoicing_portal').val('');
    $('#special_instruction').val('');

    $('.signature_validation_msg,.signature_msg').hide();

 }

function check_customer_checklist_validation(){
    
    if($('#billing_contact').val() =='' || $('#billing_address').val() =='' || $('#billing_phone').val() =='' || $('#billing_phone').val()=='___-___-____' || !isEmail($('#billing_email').val()) || $('#property_owner_name').val() =='' || $('#legal_address').val() =='' || $('#customer_phone').val() =='' || $('#customer_phone').val()=='___-___-____' || !isEmail($('#customer_email').val()) || $('#onsite_contact').val() =='' || $('#onsite_phone').val() =='' || $('#onsite_phone').val()=='___-___-____' || !isEmail($('#onsite_email').val()) || $('#invoicing_portal').val() ==''){
            $('.customer_checklist_validation_msg').show();
             $(".customer_checklist_save_btn").prop("disabled", true).addClass("ui-state-disabled");
            return false;
    }else{
        $('#customerChecklistDialog input').removeClass('error');
        $('.customer_checklist_validation_msg').hide();
        
        $(".customer_checklist_save_btn").prop("disabled", false).removeClass("ui-state-disabled");
        return true;
    }
}

 

$(document).on("keyup","#billing_contact,#billing_phone,#billing_address,#billing_email,#property_owner_name,#legal_address,#customer_phone,#customer_email,#onsite_contact,#onsite_phone,#onsite_email,#invoicing_portal",function(e) {
    
    if($(this).val() || $(this).val()!='___-___-____'){
        $(this).removeClass('error');

    }else{
        $(this).addClass('error');

    }
    check_customer_checklist_validation()
 
});

$(document).on("keyup","#billing_email,#onsite_email,#customer_email",function(e) {
    if(isEmail($(this).val())){
        
            $(this).removeClass('error');
         
    }else{
       
        $(this).addClass('error');

    }
    check_customer_checklist_validation()
 
});
/*customer check list close */

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function previewFile(input) {
    var file = $("input[type=file]").get(0).files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function () {
            $("#previewImg").attr("src", reader.result);
            $("#signature_url").val(reader.result);
        }
        $("#previewImg").show()
        reader.readAsDataURL(file);
    }
}


  $(document).on("keyup", "#signature_type_input", function () {

    if($('#signature_type_input').val()){
        var canvas1 = document.getElementById("choose_sign_canvas_option1");
        var ctx = canvas1.getContext("2d");
        var text = $('#signature_type_input').val();

        ctx.clearRect(0, 0, canvas1.width, canvas1.height);
        ctx.fillStyle = "#3e3e3e";
        ctx.font = "40px autography";
        ctx.fillText(text, 20, canvas1.height - 25);
        
        
        var resizedCanvas = document.createElement("canvas");
        var resizedContext = resizedCanvas.getContext("2d");

        resizedCanvas.height = "100";
        resizedContext.drawImage(canvas1, 0, 0, 280, 100);
        var myResizedData = resizedCanvas.toDataURL();


        
        $('#choose_sign_data_url_option1').val(myResizedData);
        

        var canvas2 = document.getElementById("choose_sign_canvas_option2");
        var ctx = canvas2.getContext("2d");
        var text = $('#signature_type_input').val();

        ctx.clearRect(0, 0, canvas2.width, canvas2.height);
        ctx.fillStyle = "#3e3e3e";
        ctx.font = "40px autosignature";
        ctx.fillText(text, 20, canvas2.height - 25);
        var dataurl2 = canvas2.toDataURL();

        var resizedCanvas = document.createElement("canvas");
        var resizedContext = resizedCanvas.getContext("2d");

        resizedCanvas.height = "100";
        resizedContext.drawImage(canvas2, 0, 0, 280, 100);
        var myResizedData = resizedCanvas.toDataURL();

        $('#choose_sign_data_url_option2').val(myResizedData);
        
        var canvas3 = document.getElementById("choose_sign_canvas_option3");
        var ctx = canvas3.getContext("2d");
        var text = $('#signature_type_input').val();

        ctx.clearRect(0, 0, canvas3.width, canvas3.height);
        ctx.fillStyle = "#3e3e3e";
        ctx.font = "40px BrothersideSignature";
        ctx.fillText(text, 20, canvas3.height - 25);
        var dataurl3 = canvas3.toDataURL();

        var resizedCanvas = document.createElement("canvas");
        var resizedContext = resizedCanvas.getContext("2d");

        resizedCanvas.height = "100";
        resizedContext.drawImage(canvas3, 0, 0, 280, 100);
        var myResizedData = resizedCanvas.toDataURL();

        $('#choose_sign_data_url_option3').val(myResizedData);
        $('.sign_radio').show();
        var sign_option = $('.sign_radio:checked').val();
        
        if(sign_option){
            $('.signature_msg').hide();
            $('#signature_url').val( $('#choose_sign_data_url_option'+sign_option).val());
        }
        
    }else{
        clear_sign_canvas();
    }
        
  })

$(document).on("change", ".sign_radio", function () {
    $('.signature_msg').hide();
    var choose_option_id = $(this).val();
    var image_data_url = $('#choose_sign_data_url_option'+choose_option_id).val();
    $('#signature_url').val(image_data_url);
});

function reset_choose_sign(){
    $('#signature_type_input').val('');
    clear_sign_canvas();
    
}
 function clear_sign_canvas(){
    $('.sign_radio').hide();
    $('.signature_msg').hide();
    $('#signature_url').val('');
    var text = 'Your Name';
    var canvas1 = document.getElementById("choose_sign_canvas_option1");
    var ctx = canvas1.getContext('2d');
    ctx.clearRect(0, 0, canvas1.width, canvas1.height);
    ctx.fillStyle = "#3e3e3e";
    ctx.font = "40px autography";
    ctx.fillText(text, 20, canvas1.height - 25);
    
    var canvas2 = document.getElementById("choose_sign_canvas_option2");
    var ctx = canvas2.getContext('2d');
    ctx.clearRect(0, 0, canvas2.width, canvas2.height);
    ctx.fillStyle = "#3e3e3e";
    ctx.font = "40px autosignature";
    ctx.fillText(text, 20, canvas2.height - 25);

    var canvas3 = document.getElementById("choose_sign_canvas_option3");
    var ctx = canvas3.getContext('2d');
    ctx.clearRect(0, 0, canvas3.width, canvas3.height);
    ctx.fillStyle = "#3e3e3e";
    ctx.font = "40px BrothersideSignature";
    ctx.fillText(text, 20, canvas3.height - 25);
 }



  document.fonts.load('1rem "autography"').then(() => { console.log('font loaded')})
  document.fonts.load('1rem "autosignature"').then(() => { console.log('font loaded')})
  document.fonts.load('1rem "BrothersideSignature"').then(() => { console.log('font loaded')})

    
    // Show proposal views Popup
    $(document).on('click', ".showProposalLinks", function() {
        var entityType = $(this).attr('data-type');


        var proposalId = $(this).attr('data-entity-id');


        var projectName = $(this).attr('data-project-name');

        loadProposalLinkTable(projectName,proposalId);
        
    });

         // Proposal Views Dialog
    $("#proposalLinks").dialog({
        width: 900,
        minHeight : 450,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false,
        position: 'top',
        open: function(event, ui) {
            $(this).parent().css({'top': window.pageYOffset + 150});
        },
    });

    function loadProposalLinkTable(projectName,proposalId) {
        if (showProposalLinksDataTable) {
            //activityTable.ajax.url(tableUrl).clear().load();
            showProposalLinksDataTable.destroy();
            $('#showProposalLinksTable').html('<thead><tr><th style="width: 20px;"><input type="checkbox" id="previewMasterCheck"></th><th>Status</th><th>Email</th><th>Sent</th><th>Expires</th><th>Views</th><th>Last Viewed</th><th>Action</th></tr></thead><tbody></tbody>');
        }
        //else {
            // Activity Datatable
            showProposalLinksDataTable = $("#showProposalLinksTable").DataTable({
                "order": [
                    [1, "desc"]
                ],
                "bProcessing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('ajax/proposalViews/'); ?>/"+proposalId
                },

                "aoColumns": [{
                    'bSortable': false,
                    'class': 'preview_table_checkbox ',
                    'sWidth': '20'
                },
                    {
                        'bVisible': true,
                        'class': 'dtCenter'
                    },
                    {
                        'bVisible': true
                    },
                    {
                        'bSearchable': false,
                        'iDataSort': 0
                    },
                    {
                        'bSortable': true
                    },
                    {
                        'bSortable': true,
                        'class': 'dtCenter'
                    },
                    {
                        'bSortable': true
                    },
                    {
                        'bSortable': true
                    }
                ],

                "bJQueryUI": true,
                "bAutoWidth": true,
                "sPaginationType": "full_numbers",
                "sDom": 'HfltiprF',
                "aLengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "drawCallback": function (settings) {
                    $(".proposal_link_project_name").text(projectName);
                    $("#groupSetExpriry").attr('data-proposal-id',proposalId);
                    $("#groupRemoveExpiry").attr('data-proposal-id',proposalId);
                    $(".groupPreviewEnableDisable").attr('data-proposal-id',proposalId);
                    $(".groupSignatureEnableDisable").attr('data-proposal-id',proposalId);

                    $("#proposalLinks").dialog('open');
                    initTiptip();
                    initButtons();
                    $("#groupActionsButtonPreview").hide();
                },
                "createdRow": function( row, data, dataIndex ) {
                    if ( data[8] == 1 ) {
                    $(row).addClass( 'view_expired' );
                    }
                }
            });
        }

    $(document).on("click", ".preview_active_inactive", function (e) {
        var proposal_id = $(this).attr('data-proposal-id');
        var is_active = $(this).attr('data-preview-active');
        var preview_id = $(this).attr('data-preview-id');
        var active_msg = (is_active == 1) ? 'disable' : 'enable';
        var active_msg_cap = (is_active == 1) ? 'Disable' : 'Enable';

        swal({
            title: "Are you sure?",
            text: "This will " + active_msg + " this proposal link",
            showCancelButton: true,
            confirmButtonText: active_msg_cap,
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'proposal_id': proposal_id,
                        'is_active': (is_active == 1) ? 0 : 1,
                        'preview_id': preview_id

                    },
                    url: "<?php echo site_url('ajax/proposal_preview_active_inactive') ?>?" + Math.floor((Math.random() * 100000) + 1),
                    dataType: "JSON"
                }).success(function (data) {
                    
                    swal('', 'Proposal Link Updated');
                    showProposalLinksDataTable.ajax.reload(null, false);

                });

                return false;
            } else {
                swal("Cancelled", "Your Preview is safe :)", "error");
            }
        });

    });

    $(document).on("click", ".preview_signature_enable_disable", function (e) {
        var proposal_id = $(this).attr('data-proposal-id');
        var is_active = $(this).attr('data-preview-signature');
        var preview_id = $(this).attr('data-preview-id');
        var active_msg = (is_active == 1) ? 'disable' : 'enable';
        var active_msg_cap = (is_active == 1) ? 'Disable' : 'Enable';

        swal({
            title: "Are you sure?",
            text: "This will " + active_msg + " this proposal Signature",
            showCancelButton: true,
            confirmButtonText: active_msg_cap,
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'proposal_id': proposal_id,
                        'is_active': (is_active == 1) ? 0 : 1,
                        'preview_id': preview_id

                    },
                    url: "<?php echo site_url('ajax/proposal_preview_signature_active_inactive') ?>?" + Math.floor((Math.random() * 100000) + 1),
                    dataType: "JSON"
                }).success(function (data) {
                    console.log(data);

                    swal('', 'Proposal Signature Setting Updated');
                    showProposalLinksDataTable.ajax.reload(null, false);

                });

                return false;
            } else {
                swal("Cancelled", "Your Preview is safe :)", "error");
            }
        });

    });


    $(document).on("click", ".remove_shared_proposal", function (e) {
        var proposal_id = $(this).attr('data-proposal-id');
        
        var shared_id = $(this).attr('data-shared-id');
       

        swal({
            title: "Are you sure?",
            text: "This will Remove this proposal for User",
            showCancelButton: true,
            confirmButtonText: 'Remove',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Removing..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'proposal_id': proposal_id,
                        'shared_id': shared_id

                    },
                    url: "<?php echo site_url('ajax/remove_shared_proposal_permission') ?>?" + Math.floor((Math.random() * 100000) + 1),
                    dataType: "JSON"
                }).success(function (data) {
                    
                    swal('', 'Proposal Sharing Removed');
                    showSharedProposalUserTable.ajax.reload(null, false);

                });

                return false;
            } else {
                swal("Cancelled", "Your Preview is safe :)", "error");
            }
        });

    });

    $(document).on("click",".copy_proposal_link22",function(e) {

        $(this).html('<i class="fa fa-fw fa-copy"></i> Link Copied');
        $this =this;
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($(this).attr('data-preview-link')).select();
        document.execCommand("copy");
        temp.remove();


        setTimeout(function(){
                $($this).html('<i class="fa fa-fw fa-copy"></i> Copy Link');// or fade, css display however you'd like.
        }, 3000);
        return false;
    });

    // Copy work order link
    $(document).on('click', ".copy_proposal_link", function () {
            var linkInput = $(this).attr('data-preview-link');

            // swal({
            //     width: 600,
            //     html: 'Work Order Link<br />' +
            //     '<input type="text" style="width: 550px;" value="' + linkInput + '" />'
            // });

            swal({
                html: 'Proposal Link<br />' +
                '<input type="text" style="width: 550px;" value="' + linkInput + '" />',
                showCancelButton: true,
                cancelButtonColor: "#328add",
                confirmButtonColor: "#328add",
                confirmButtonText: "Copy to clipboard",
                cancelButtonText: "Cancel",
                 width: 600,
                dangerMode: false,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $this =this;
                    var temp = $("<input>");
                    $("body").append(temp);
                    temp.val(linkInput).select();
                    document.execCommand("copy");
                    temp.remove();
                    swal('','Link Copied');
                }
            });


            $.uniform.update();
        });

        // Group Actions Button
        $(document).on("click", "#groupActionsButtonPreview", function () {

            // Hide the filter
            $("#newProposalFilters").hide();
            // Toggle the buttons
            $(".groupActionsContainer").toggle();
        });

        //Hide Menu when clicking on a group action item
        $(document).on("click", ".groupActionItemsPreview a", function () {
            $("#groupActionsContainer").hide();
            return false;
        });

    $("#previewMasterCheck").live('change', function () {
        var checked = $(this).is(":checked");
        $(".previewGroupSelect").prop('checked', checked);
        updatePreviewNumSelected();
    });

    // Update the counter after each change
    $(".previewGroupSelect").live('change', function () {
        updatePreviewNumSelected();
    });

    // All / None user master check
    $("#previewMasterCheck").live('change', function () {
        var checked = $(this).is(":checked");
        $(".previewGroupSelect").prop('checked', checked);
        updatePreviewNumSelected();
    });

    function getSelectedPreviewIds() {
        var IDs = new Array();
        $(".previewGroupSelect:checked").each(function () {
            IDs.push($(this).val());
        });
        return IDs;
    }


    // Group action selected numbers
    function updatePreviewNumSelected() {
        var num = $(".previewGroupSelect:checked").length;
        // Hide the options if 0 selected
        if (num < 1) {

            $("#groupActionsButtonPreview").hide();
            $(".groupActionsContainer").hide();
        } else {

            $("#groupActionsButtonPreview").show();
        }
    }

    function uncheckAllPreviewGroupCheckbox() {
        $(".previewGroupSelect").prop('checked', false);
        $("#previewMasterCheck").prop('checked', false);
        $.uniform.update();
        updatePreviewNumSelected();
    }

        $("#groupRemoveExpiry").click(function () {

        var proposal_id = $(this).attr('data-proposal-id');
        swal({
            title: "Are you Sure?",
            text: "Preview Link Expiry Date will removed",
            showCancelButton: true,
            confirmButtonText: 'Remove',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Removing..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '/ajax/remove_group_proposal_preview_expiry',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'preview_ids': getSelectedPreviewIds(),
                        'proposal_id': proposal_id
                    },

                    success: function (data) {
                        swal('', 'Preview Expiry Removed');
                        showProposalLinksDataTable.ajax.reload(null, false);
                        uncheckAllPreviewGroupCheckbox();
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred. Please try again");
                    }
                })
            } else {
                swal("Cancelled", "Your Preview Link was not changed :)", "error");
            }
        });

    });

    $("#grouplinkdcDate").datepicker();

    $("#groupSetExpriry").click(function () {

        $("#group_expiry_proposal_id").val($(this).attr('data-proposal-id'));
        // $("#expiry_preview_id").val($(this).attr('data-preview-id'));
        $("#group-expiry-date-change-confirm").dialog('open');

    });


    $("#group-expiry-date-change-confirm").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var expiryDate = $("#grouplinkdcDate").val();
                    var proposal_id = $("#group_expiry_proposal_id").val();
                    var expiry_preview_ids = getSelectedPreviewIds();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'preview_ids': expiry_preview_ids,
                            'expiryDate': expiryDate,
                            'proposal_id': proposal_id
                        },
                        url: "<?php echo site_url('ajax/set_group_proposal_preview_expiry') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.succes) {
                                swal('', 'Preview Expiry Set');
                                showProposalLinksDataTable.ajax.reload(null, false);
                                uncheckAllPreviewGroupCheckbox();
                            } else {
                                swal('', 'An error occurred. Please try again');

                            }

                            $("#group-expiry-date-change-confirm").dialog('close');
                        });

                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });


    $(".groupPreviewEnableDisable").click(function () {

        var proposal_id = $(this).attr('data-proposal-id');
        var is_enable = $(this).attr('data-is-enable');
        var msg = 'Enable';
        if (is_enable == 0) {
            var msg = 'Disable';
        }
        swal({
            title: "Are you Sure?",
            text: "Preview Link will " + msg,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '/ajax/group_enable_disable_proposal_preview',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'preview_ids': getSelectedPreviewIds(),
                        'proposal_id': proposal_id,
                        'is_enable': is_enable
                    },

                    success: function (data) {
                        swal('', 'Preview Link ' + msg + 'd');
                        showProposalLinksDataTable.ajax.reload(null, false);
                        uncheckAllPreviewGroupCheckbox();
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred. Please try again");
                    }
                })
            } else {
                swal("Cancelled", "Your Preview Link was not changed :)", "error");
            }
        });

    });

    $(".groupSignatureEnableDisable").click(function () {

        var proposal_id = $(this).attr('data-proposal-id');
        var is_enable = $(this).attr('data-is-enable');
        var msg = 'Enable';
        if (is_enable == 0) {
            var msg = 'Disable';
        }
        swal({
            title: "Are you Sure?",
            text: "Preview Signature will " + msg,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '/ajax/group_enable_disable_proposal_signature',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'preview_ids': getSelectedPreviewIds(),
                        'proposal_id': proposal_id,
                        'is_enable': is_enable
                    },

                    success: function (data) {
                        swal('', 'Preview Signature ' + msg + 'd');
                        showProposalLinksDataTable.ajax.reload(null, false);
                        uncheckAllPreviewGroupCheckbox();
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred. Please try again");
                    }
                })
            } else {
                swal("Cancelled", "Your Preview Signature was not changed :)", "error");
            }
        });

    });
  // End Script


</script>



<div id="change-business-type" title="Change Proposals Business Type">
        <p>Choose one Business Type to assign to the selected  <span id="changeBusinessTypeNum"></span> Proposals</p><br/>
        <p><strong> Note:</strong> Any existing assignments will be removed and replaced with the selected assignments only</p><br/>
        <label >Select Business Type</label>
        <select  class="dont-uniform businessType"  style="width: 64%" name="business_type" >
                    <?php
                        foreach($businessTypes as $businessType){
                            echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                        }
                    ?>
                </select>

        <p id="changeBusinessTypeStatus"></p>
</div>

<div id="change-proposal-business-type" title="Update Proposal Business Type">
                    <p style="font-size: 14px;margin: 15px 0px 20px 0px;"><span style="font-weight: bold;width: 110px;text-align: right;float: left;margin-right: 10px;">Account: </span><span class="change-bt-account-name"></span></p>
                    <p style="font-size: 14px;margin: 15px 0px 20px 0px;"><span style="font-weight: bold;width: 110px;text-align: right;float: left;margin-right: 10px;">Contact: </span><span class="change-bt-contact-name"></span></p>
                    <p style="font-size: 14px;margin: 15px 0px 20px 0px;"><span style="font-weight: bold;width: 110px;text-align: right;float: left;margin-right: 10px;">Proposal: </span><span class="change-bt-proposal-name"></span></p>
                    <label style="font-size: 14px;width: 110px;text-align: right;float: left;margin-top: 3px;margin-right: 10px;"><strong>Business Type:</strong></label>
                    <input type="hidden" id="business_proposal_id" name="proposalsChangeBusinessTypes">
                    <select  class="proposalBusinessType" id="proposalBusinessType" style="width: 64%" name="proposal_business_type">
                    <option value="">Please select business type </option>
                        <?php
                            foreach($businessTypes as $businessType){
                                echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                            }
                        ?>
                    </select>

                </div>

<div id="proposal-user-permission" title="Proposal User Permission">
    <a href="javascript:void(0);" class="clearFilterSearch" style="display: none;font-size: 25px;top: 6px;position: absolute;right: 20px;" >×</a>
    <input type="text" class="text permissionUsersfilterSearch" placeholder="Search Users" style="float: right;margin-right: 30px;padding: 5px;width: 160px;">
    <p style="float: left;"><label style="font-size: 14px;text-align: right;float: left;margin-top: 8px;margin-right: 10px;"><strong>User Permission: <span class="permission_project_name"></span></strong></label></p>
    <input type="hidden" id="permission_proposal_id" name="permission_proposal_id">

    <div class="padded" style="margin-top:35px;display: grid;grid-template-columns: repeat(3,1fr);">
    
    </div>


</div>



<div id="proposalPreviewDialog" title="Proposal Images">
    <div id="proposalPreviewImageContainer">
    <div id="proposalPreviewContent"></div>
    </div>
</div>

<div id="workOrderDialog" title="Preview Work Order" style="display:none;">
<p style="font-weight: bold;width: 700px;position: absolute;font-size: 14px;top: 3px;"><span style="position:absolute"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="dialog_project_name" href="#" ></a></span></span><br/>
    <span style="position:absolute;left:0px;margin-top:3px" ><span style="display: block;float: left;margin-right:7px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left"   href="#" class="dialog_project_contact_name">'</a></span></span></p>
    <div style="float: left;">
        <input id="work_order_url_link" type="hidden" >

        <span class="flash_copy_msg" style="margin-left: 380px;display: none;">Link Copied to clipboard</span>
    </div>
<a href="javascript:void(0);"  class="btn right blue-button workorder_link_copy tiptip" title="Copy Work Order Link" style="margin-bottom: 5px;" >
        <i class="fa fa-fw fa-copy" ></i> Copy Link</a>
<a href="javascript:void(0);" download="" class="btn right blue-button workorder_download_btn tiptip" title="Download your Work-Order" style="margin-bottom: 5px;margin-right:5px;" >
<i class="fa fa-fw fa-download" ></i>Download</a>
<a href="javascript:void(0);"  id="workorderpreviewPDF" class="btn right blue-button  tiptip" title="Pdf View" style="margin-bottom: 5px;margin-right:5px;" >
<i class="fa fa-fw fa-download" ></i>PDF/Print</a>
<a href="javascript:void(0);" id="workorderpreviewWEB" class="btn right blue-button  tiptip" title="Web View" style="margin-bottom: 5px;margin-right:5px;" >
<i class="fa fa-fw fa-globe" ></i>Web View</a>
<a href="javascript:void(0);"  class="btn right blue-button workorder_send_btn tiptip" title="Send your Work-Order" style="margin-bottom: 5px; margin-right:5px;" >
<i class="fa fa-fw fa-envelope" ></i>Send</a>
<div style="text-align: center;" id="loadingFrame2">
                    <br />
                    <br />
                    <br />
                    <br />
                    <p><img src="/static/blue-loader.svg" /></p>
                </div>

<iframe id="workOrder-preview-iframe" onload="workOrder_ifram_load()" style="width: 100%; height: 650px;border-top: 1px solid rgb(68, 68, 68);"></iframe>

</div>

<div id="template" style="display:none">

<div class="dropdownMenuContainer template_class">
        <div class="closeDropdown closeProposalsDropdown" style="line-height: 10px;">
            <a href="#" class="closeDropdownMenu">&times;</a>
        </div>
        <div class="proposalMenuTitle">
            <h4>{clientAccountName}: {projectName}</h4>
        </div>
        <ul class="dropdownMenu" style="float: left;width: 220px">
            <li class="divider noHover"><b>Actions</b></li>
            <li>
                <a href="<?php echo site_url('proposals/edit/{proposalId}') ?>">
                    <img src="/3rdparty/icons/application_edit.png">Edit Proposal
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('proposals/edit/{proposalId}') . '/send'; ?>"
                data-val="{proposalId}"
                data-project-name="{projectName}"
                data-client-id="{clientId}"
                data-project-contact="{clientAccountName}"
                data-contact-name="{contactName}"
                 class="send_proposal_email has_email_permission">
                    <img src="/3rdparty/icons/email_go.png">Send Proposal
                </a>

            </li>
            <li>
                <a href="<?php echo site_url('proposals/edit/{proposalId}') . '/basic_info'; ?>">
                    <img src="/3rdparty/icons/information.png">Edit Project Info
                </a>
            </li>
            <li>
                <a href="#" rel="{proposalId}" class="view-notes">
                    <img src="/3rdparty/icons/page_white_edit.png"> Add Note
                </a>
            </li>
            <li>
                <a  href="#" class="proposal_link_copy" data-proposal-link="{proposalUrl}" data-action="1">
                    <img src="/3rdparty/icons/book_link.png"> <span>Copy Proposal Link</span>
                </a>
            </li>
            <li class="is_shared_proposal">
                <a href="#" data-has-estimate="{has_estimate}" data-business-type="{business_type}" class="copy-proposal" rel="{proposalId}">
                    <img src="/3rdparty/icons/page_copy.png"> Copy Proposal
                </a>
            </li>
            <li class="is_shared_proposal">
                <a href="#" data-has-estimate="{has_estimate}" data-business-type="{business_type}" class="duplicate-proposal" rel="{proposalId}">
                    <img src="/3rdparty/icons/application_double.png"> Duplicate Proposal
                </a>
            </li>
            <li>
                <a href="#" class="hideProposal"  data-proposal="{proposalId}" >
                    <img src="/3rdparty/icons/icons8-invisible.png"> Hide Proposal
                </a>
            </li>
            <li>
                <a href="#" class="showProposal"  data-proposal="{proposalId}" >
                    <img src="/3rdparty/icons/icons8-eye.png"> Show Proposal
                </a>
            </li>
            <li class="is_shared_proposal">
                <a href="#" rel="{proposalId}" class="confirm-deletion" id="delete_proposal_{proposalId}">
                    <img src="/3rdparty/icons/delete.png"> Delete Proposal
                </a>
            </li>
            <!--
            <li class="divider">
                <a href="#" rel="{proposalId}" class="preview-proposal-events" id="events_proposal_{proposalId}">
                    <img src="/3rdparty/icons/application_go.png">Proposal Events
                </a>
            </li>
            -->
            <li>
                <a href="#" class="scheduleProposalEvent" data-account="{account_id}" data-proposal="{proposalId}" data-projectname="{projectName}">
                    <img src="/3rdparty/icons/time_add.png"> Schedule an Event
                </a>
            </li>
            <li>
                <a href="#" class="manage_business_type"  data-proposal-account="{clientAccountName}" data-contact-name="{contactName}" rel="{proposalId}" data-projectname="{projectName}">
                    <img src="/3rdparty/icons/building_edit.png"> Business Type
                </a>
            </li>
            <li>
                <a href="#" class="exclude_resend_individual"   rel="{proposalId}" >
                    <img src="/3rdparty/icons/email_delete.png"> Email Off
                </a>
            </li>
            <li>
                <a href="#" class="include_resend_individual"   rel="{proposalId}" >
                    <img src="/3rdparty/icons/email_add.png"> Email On
                </a>
            </li>
            <li class="is_shared_proposal">
                <a href="#" class="addProposalSignature"   rel="{proposalId}" >
                    <img src="/3rdparty/icons/text_signature.png"> Add Signature
                </a>
            </li>
            <li class="is_shared_proposal">
                <a href="#" class="addCustomerChecklist"   rel="{proposalId}" >
                    <img src="/3rdparty/icons/application_edit.png"> Customer Checklist
                </a>
            </li>
            <li>
                <a href="#" class="enable_auto_resend_individual"   rel="{proposalId}" >
                    <img src="/3rdparty/icons/email_go.png"> Enable Auto Resend
                </a>
            </li>
            <li>
                <a href="#" class="disable_auto_resend_individual"   rel="{proposalId}" >
                    <img src="/3rdparty/icons/email_error.png"> Disable Auto Resend
                </a>
            </li>
            
        </ul>
        <ul class="dropdownMenu" style="float: left;width: 220px">

            <li class="divider noHover">
                <b>Views</b>
            </li>
            <li>
                <a id="estimatepreview" href="#" data-url="{proposalUrl}">
                    <img src="/3rdparty/icons/application_go.png"> Preview Proposal
                </a>
            </li>
            <li>
                <a href="#" id="workorderpreview" data-access-key="{proposalAccessKey}" data-val="{proposalId}" data-project-name="{projectName}">
                    <img src="/3rdparty/icons/hammer.png"> Work Order: Send | See | Print
                </a>
            </li>
            <li>
                <input type="hidden" class="divider workOrderLink" value="<?php echo site_url('proposals/live/view/work_order/{access_key}.pdf') ?>" />
                <a href="#" class="copyWorkOrderLink">
                    <img src="/3rdparty/icons/link.png"> Work Order: Get Link
                </a>
            </li>
            <li class="action_proposal_view">
                <a href="javascript:void(0);" class="showProposalLinks" data-entity-id="{proposalId}" data-project-name="{projectName}">
                    <img src="/3rdparty/icons/server_link.png"> Proposal Links
                </a>
            </li>
            <li class="action_proposal_view">
                <a href="javascript:void(0);" class="showProposalViews" data-type="proposal" data-entity-id="{proposalId}" data-project-name="{projectName}">
                    <img src="/3rdparty/icons/application_view_tile.png"> Proposal Views
                </a>
            </li>
            
            <li>
                <a href="<?php echo site_url('proposals/activity/{proposalId}'); ?>">
                    <img src="/3rdparty/icons/time.png"> Proposal Activity
                </a>
            </li>
            <li>
                <a href="#" rel="{proposalId}" class="view-notes">
                    <img src="/3rdparty/icons/page_white_edit.png"> Proposal Notes
                </a>
            </li>

            <li>
                <a href="javascript:void(0);"  class="email_events"
                    data-project-name="{projectName}"
                    data-proposal-id="{proposalId}"
                    data-project-contact="{clientAccountName}"
                    data-contact-name="{contactName}"
                    data-client-id="{clientId}"
                    >
                    <img src="/3rdparty/icons/time_add.png"> Email History
                </a>
            </li>

            <li class="has_audit is_shared_proposal">
                <a href="https://my.prositeaudit.com/edit/{audit_key}" target="_blank">
                    <img src="/3rdparty/icons/map_edit.png"> Edit Audit
                </a>
            </li>
            <li class="has_audit">
                <a href="https://my.prositeaudit.com/report/{audit_key}" target="_blank">
                    <img src="/3rdparty/icons/map_go.png"> View Audit Report
                </a>
            </li>


            <li class="divider noHover qb_li_btn is_shared_proposal"><b>Quickbooks</b></li>
            <li class="qb_li_btn">
                <a href="<?php echo site_url('proposals/invoice/{proposalId}'); ?>">
                    <img src="/static/images/qb-logo-16.png"> Invoice
                </a>
            </li>

        </ul>
        <ul class="dropdownMenu" style="float: left;width: 220px">
            <li class="divider noHover">
                <b>Contact</b>
            </li>
            <li class="is_shared_proposal">
                <a href="<?php echo site_url('proposals/add/{clientId}'); ?>">
                    <img src="/3rdparty/icons/add.png"> Add New Proposal
                </a>
            </li>
            <li class="divider is_shared_proposal">
                <a href="<?php echo site_url('proposals/clientProposals/{clientId}'); ?>">
                    <img src="/3rdparty/icons/application_go.png"> Existing Proposals
                </a>
            </li>
            <li>
                <a href="#details-{clientId}" rel="{clientId}" class="viewClient">
                    <img src="/3rdparty/icons/user_suit.png"> Contact Details
                </a>
            </li>
            <li class="edit_contact_li is_shared_proposal">
                <a href="<?php echo site_url('clients/edit/{clientId}'); ?>">
                    <img src="/3rdparty/icons/user_edit.png"> Edit Contact
                </a>
            </li>

            <li class="is_shared_proposal">
                <a href="<?php echo  site_url('leads/add/client/{clientId}'); ?>">
                    <img src="/3rdparty/icons/user_suit.png"> Create Lead
                </a>
            </li>
            <li class="is_shared_proposal">
                <a href="#"class="editContactEmail" data-contact-name="{contactName}" data-account-name="{clientAccountName}" data-contact-email="{contactEmail}" data-contact-id="{clientId}">
                    <img src="/3rdparty/icons/user_edit.png"> Update Contact Email
                </a>
            </li>

                    <li class="divider noHover has_estimate job_cost_report"><b>Job Cost Report</b></li>
                    <li class="has_estimate job_cost_report">
                        <a href="<?php echo site_url('proposals/job_cost_report/{proposalId}'); ?>">
                            <img src="/3rdparty/icons/calculator_edit.png"> Job Cost Report
                        </a>
                    </li >

                        <li class="divider noHover has_estimate job_costing"><b>Job Costing</b></li>
                        <li class="has_estimate job_costing">
                            <a href="<?php echo site_url('proposals/job_costing/{proposalId}'); ?>">
                                <img src="/3rdparty/icons/calculator_edit.png"> Job Costing
                            </a>
                        </li>
                        <li class="has_estimate job_costing">
                        <a href="#" class="send_mobile_job_costing_link" data-id="{proposalId}">
                            <img src="/3rdparty/icons/link.png"> Mobile Job Costing: send Link
                        </a>
                        </li>

                        <li class="divider noHover has_estimate estimating"><b>Estimating</b></li>
                        <li class="has_estimate estimating">
                            <a href="<?php echo site_url('proposals/estimate/{proposalId}'); ?>">
                                <img src="/3rdparty/icons/calculator_edit.png"> Estimate Proposal
                            </a>
                        </li>
                    <?php if ($account->isAdministrator()) { ?>
                        <li class="divider noHover is_shared_proposal"><b>Permission</b></li>
                        <li class="user_permission_li is_shared_proposal">
                            <a href="javascript:void(0);" class="user_permission_btn" data-project-name="{projectName}" data-proposal-id="{proposalId}" data-account-id="{account_id}">
                                <img src="/3rdparty/icons/folder_user.png"> User Permission
                            </a>
                        </li>
                        <li class="proposal_sharing_li is_shared_proposal">
                            <a href="javascript:void(0);" class="proposal_sharing_btn" data-project-name="{projectName}" data-proposal-id="{proposalId}" data-account-id="{account_id}">
                                <img src="/3rdparty/icons/arrow_switch.png"> Share Proposal
                            </a>
                        </li>
                        <li class="proposal_sharing_li is_shared_proposal">
                            <a href="javascript:void(0);" class="proposal_shared_user_list_btn" data-project-name="{projectName}" data-proposal-id="{proposalId}" data-account-id="{account_id}">
                                <img src="/3rdparty/icons/application_link.png"> Proposal Shared Users 
                            </a>
                        </li>
                    <?php } ?>

        </ul>
    </div>

</div>

<div id="approval_email_template" style="display:none">
    <form id="approval_email_form">
    <table width="100%" cellpadding="0" style="font-size:14px;" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <div class="padded" style="float:left;text-align:left">
                                        <p>Please choose one or many from the list below to send your proposal for approval please!</p>

                                        <p>&nbsp;</p>

                                        <p><b>VIP</b>: After you send your proposal for approval, you will not be able to change/edit until it is approved. You will receive an email asap after the approval.</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="padded">
                                        <?php
                                        foreach ($recipients as $recipient) {
                                            ?>
                                            <label class="nice-label" for="recipient_<?php echo $recipient->accountId ?>"><?php echo $recipient->firstName . ' ' . $recipient->lastName ?> <input type="checkbox" value="<?php echo $recipient->email ?>" class="approval_recipients" data-val="<?php echo $recipient->accountId ?>" name="recipients[<?php echo $recipient->accountId ?>]" id="recipient_<?php echo $recipient->accountId ?>"/></label>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="padded">
                                        <p style="text-align:left">Message:</p>
                                        <textarea name="message" class="approval_email_message" cols="30" rows="10" style="float:left;width: 50%; height: 70px;"></textarea>
                                    </div>
                                </td>
                            </tr>

            </table>
            <span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span>
        </form>
</div>

<div id="send_work_order_template" style="display: none;">
                    <form >
                        <table style="margin-top:25px" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <th style="text-align: left; padding-bottom: 10px;font-size:14px" width="510">Please chose send to options here:</th>
                                <th   style="text-align: left; padding-bottom: 10px;font-size:14px">Add any other emails here. For more than one, separate by comma:</th>

                            </tr>
                            <tr>
                                <td>
                                    <?php

                                    if (!count($workOrderRecipients)) {
                                        ?><p class="">No recipients found! Please add from <a href="<?php echo site_url('account/work_order_recipients') ?>">My Account > Work Order Recipients</a>.</p><?php
                                    } else {
                                        foreach ($workOrderRecipients as $recipient) {
                                            ?>
                                            <label class="nice-label" for="recipient_<?php echo $recipient->getRecipientId() ?>"><?php echo $recipient->getName(); ?> <input type="checkbox" value="<?php echo $recipient->getEmail() ?>" class="work_order_recipients" data-val="<?php echo $recipient->getRecipientId() ?>" name="recipients[<?php echo $recipient->getRecipientId() ?>]" id="recipient_<?php echo $recipient->getRecipientId() ?>"/></label>
                                            <?php
                                        }
                                    }

                                    ?>
                                </td>
                                <td valign="top"><input  style="width: 95%; margin-top: 5px;" type="text" name="additional_emails" class="work_order_additional_emails text" placeholder="Add Emails Here"/></td>

                            </tr>
                        </table>
                    </form>
                    <span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span>
</div>

<div class="javascript_loaded">
    <div id="duplicate-proposal" title="Duplicate Proposal">

        <div class="dupe-copy-wording">
            <p>Use this to send out the same proposal to several different customers.</p>
            <p><strong>Example:</strong> You are bidding the same project to 3 different General Contractors.</p>
            <p>Please understand that the number that shows up in your pipeline is the first bid created.</p>
            <p>After you win/lose this project, delete the duplicate proposals.</p>
        </div>

        <p class="clearfix" id="duplicate-selected-client">
            Selected Contact: <strong id="clientName">Contact</strong> <a href="#" id="reset-duplicate-client-search">Select other contact</a>
        </p>

        <p class="clearfix input_field_table" >
            <table id="duplicate-select-client" style="border-spacing: 0 1em;">

                <tr>
                    <td><strong style="padding-right: 5px;">Search Contact</strong></td>
                    <td>
                    <select name="duplicate-client" id="duplicate-client" class="dont-uniform" data-placeholder="Chose number" data-allow-clear="true" ><option value=""></option></select>
                        <!-- <input type="text" name="duplicate-client" id="duplicate-client" style="float: left;"> -->
                    </td>
                </tr>
                <tr id="duplicate_business_type_selectbox_tr">
                    <td><strong>Business Type</strong></td>
                    <td >
                        <select name="duplicate_business_type" id="duplicate_business_type_selectbox" >
                        <option value="">Please Select</option>
                        <?php
                            foreach($businessTypes as $businessType){
                                echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                            }
                        ?>
                        </select>
                    </td>
                </tr>
            </table>

        </p>

        <p id="duplicate_estimate_chackbox" style="padding-top:10px;width:30%"><input type="checkbox" name="duplicate_estimate" id="duplicate_estimate" > <span style="margin-top: 2px;position: absolute;">Duplicate Estimate</span><span style="margin-top:2px;float:right"><i class="fa fa-info-circle  tiptip" title="If checked, all estimate details will be copied to the new proposal"></i></span></p>
        <input id="duplicate-client-id" type="hidden" name="duplicate-client-id">
        <input id="duplicate-proposal-id" type="hidden" name="duplicate-proposal-id">
    </div>
    <div id="copy-proposal" title="Copy Proposal">

        <div class="dupe-copy-wording">
            <p>Use this to copy the content of an existing proposal and send to a new customer/project.</p>
            <p>Please remember to delete any picture/images etc. prior to sending.</p>
            <p>You must have the contact name entered prior to using this feature.</p>
        </div>

        <p class="clearfix" id="copy-selected-client" style="display: none">
            Selected Contact: <strong id="clientName">Contact</strong><br />
            <a href="#" id="reset-copy-client-search">Select other contact</a>
        </p>

        <div class="clearfix" id="copy-select-client">

            <table style="border-spacing: 0 1em;">
                <tr>
                    <td style="padding: 5px;"><strong>Search Contact</strong></td>
                    <td style="padding: 5px;">

                    <select name="copy-client" id="copy-client" class="dont-uniform" data-placeholder="Chose number" data-allow-clear="true" ><option></option></select>
                        <!-- <input type="text" class="text" name="copy-client" id="copy-client" style="float: left;"> -->
                    </td>

                </tr>
                <tr id="copy_business_type_selectbox_tr">
                    <td><strong>Business Type</strong></td>
                    <td >
                        <select name="copy_business_type" id="copy_business_type_selectbox" >
                        <option value="">Please Select</option>
                        <?php
                            foreach($businessTypes as $businessType){
                                echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                            }
                        ?>
                        </select>
                    </td>
                </tr>

            </table>

        </div>
        <input id="copy-client-id" type="hidden" name="copy-client-id">
        <input id="copy-proposal-id" type="hidden" name="copy-proposal-id">
    </div>

    <div id="proposal-events" title="Proposal Events">
        <p><span style="font-size: 16px;font-weight:bold"><i class="fa fa-fw fa-history"></i> Proposal Events</span>
                <a class="m-btn grey tiptip" style="margin-left: 525px;border-radius: 2px;display: inline-block;line-height: 30px;padding: 0 1rem;/* vertical-align: ;; none; */color: #fff;background-color: #25aae1;letter-spacing: .5px;cursor: pointer;" title="Events Filters" id="eventFilterButton"><i
                                    class="fa fa-fw fa-table"></i> Events Filters</a>
                </p>

                                    <div id="newProposalEventColumnFilters">

                <p style="padding: 5px;"> <a href="javascript:void(0);" id="selectAll">All</a> / <a href="javascript:void(0);" id="selectNone">None</a></p>

                <div class="clearfix"></div>

                <div class="filterRow" style="margin-top:2px;display: inline-grid;">
                <?php
                foreach($proposal_event_types as $type){
                ?>

                <label class="event-checkbox-inline">
                    <input type="checkbox" checked="checked" class="event_show" name="event_show" value="<?=$type->getId();?>"><span style="margin-top: 3px;position: absolute;width:200px"><?=$type->getTypeName();?></span>
                </label>
                <?php

                }
                ?>


                </div>

                <div class="clearfix filterRow"></div>



                </div>


                <hr />
        <div id="timeline_box" style="position:absolute;width: 98%px;height: 540px;overflow-y: scroll;background-color:#eee">
            <div class="timeline" id="timeline">
            </div>
        </div>
    </div>

    <div id="notes" title="Proposal Notes" style="display: none;">
        <form action="#" id="{add-note}" style="font-size: 15px;">
            <p>
                <label style="font-weight: bold;">Add Note</label>
                <input type="text" class="text" name="noteText" id="{noteText}" style="width: 500px;margin-bottom: 10px;padding: 5px;">
                <input type="hidden" name="relationId" id="relationId" value="0">
                <button type="button" style="position: relative;top: 2px;" class="btn blue-button dont-uniform add-notes-popup-btn" value="Add"><i class="fa fa-fw fa-floppy-o"></i>Add</button>

            </p>
            <iframe id="notesFrame" src="" frameborder="0" width="100%" height="300"></iframe>
        </form>
    </div>
    <div id="notes_popup_div" style="display: none;">
        <iframe id="newNotesFrame2" src="" frameborder="0" width="100%" height="300"></iframe>

    </div>
    <div id="notes-client" title="Client Notes">
        <form action="#" id="add-note-client">
            <p>
                <label>Add Note</label>
                <input type="text" name="noteText-client" id="noteText-client" style="width: 500px;">
                <input type="hidden" name="relationId-client" id="relationId-client" value="0">
                <input type="submit" value="Add">
            </p>
            <iframe id="notesFrame-client" src="" frameborder="0" width="100%" height="250"></iframe>
        </form>
    </div>
    <div id="confirm-delete-message" title="Confirmation">
        <p>Are you sure you want to delete this proposal?</p>
        <a id="client-delete" href="" rel=""></a>
    </div>

    <div id="estimatepreviewDialog" title="Preview Proposal" style="display:none;">

    <p style="font-weight: bold;width: 700px;position: absolute;font-size: 14px;top: 3px;"><span style="position:absolute;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="dialog_project_name" href="#" ></a></span></span><br/>
    <span style="position:absolute;left:0px;margin-top:3px" ><span style="display: block;float: left;margin-right:7px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left"   href="#" class="dialog_project_contact_name">'</a></span></span></p>
    <a href="javascript:void(0);"  class="btn right blue-button proposal_link_copy tiptip" title="Copy Proposal Link" style="margin-bottom: 5px;" >
        <i class="fa fa-fw fa-copy" ></i> Copy Link</a>
    <a href="" target="_blank"  style="margin-bottom: 5px;"  class="btn right blue-button proposal_tab_btn tiptip" title="Customer View" >
    <i class="fa fa-fw fa-external-link"></i>Customer View</a>
    <a href=""  download style="margin-bottom: 5px;"  class="btn right blue-button proposal_download_btn tiptip" title="Download your Proposal" >
        <i class="fa fa-fw fa-download"></i>Download</a>
    <a href="JavaScript:void(0);" data-url="" id="estimatepreviewPDF"   class="btn right blue-button tiptip" title="PDF/Print" >
    <i class="fa fa-fw fa-download"></i>PDF/Print</a>
    <a href="JavaScript:void(0);" data-url="" id="estimatepreviewWEB"   class="btn right blue-button tiptip" title="Web Proposal" >
    <i class="fa fa-fw fa-globe"></i>Web View</a>

        <a href="#" class="btn right update-button send_proposal_email has_email_permission dialog_send_proposal tiptip"
                data-val=""
                data-project-name=""
                data-client-id=""
                data-project-contact=""
                data-contact-name=""
                title="Send your proposal">
                    <i class="fa fa-fw fa-envelope"></i> Send
                </a>
        <div style="text-align: center;" id="loadingFrame">
                    <br />
                    <br />
                    <br />
                    <br />
                    <p><img src="/static/blue-loader.svg" /></p>
                </div>
        <iframe id="estimate-preview-iframe" onload="proposal_ifram_load()" style="width: 100%; height: 650px; margin-top: 10px; border-top: 1px solid #444;"></iframe>

</div>

    <div id="dialog-message" title="Client Information">
        <p class="clearfix"><strong class="fixed-width-strong">First Name:</strong> <span id="field_firstName"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Last Name:</strong> <span id="field_lastName"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Title:</strong> <span id="field_title"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Company:</strong> <span id="field_company"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Email:</strong> <span id="field_email"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Address:</strong> <span id="field_address"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">City:</strong> <span id="field_city"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Zip:</strong> <span id="field_zip"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">State:</strong> <span id="field_state"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Country:</strong> <span id="field_country"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Cell Phone:</strong> <span id="field_cellPhone"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Business Phone:</strong> <span id="field_businessPhone"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Fax:</strong> <span id="field_fax"></span></p>
    </div>

    <div id="no-proposals-selected" title="Error">
        <p>No proposals were selected!</p>
        <br/>

        <p>Select at least one proposal to carry out a group action</p>
    </div>

    <div id="groupExportProposals" title="Select File Name">
        <p>Enter a file name for your export</p>
        <br/>
        <form id="group_export_form" action="<?php echo site_url('proposals/groupExport');?>" method="post" id="groupExportForm">
        <p><input type="text" id="groupExportName" name="groupExportName" placeholder="File Name"></p>
        <p><input type="hidden" name="groupExportProposalIds" id="groupExportProposalIds"></p>
        </form>
    </div>
    <!-- add sign dialog-->
    <div id="proposalSignatureDialog" title="Proposal Signature" style="display:none;min-height:540px">
    
        <p class="signature_popup_title"></p>
        <div class="adminInfoMessage signatureInfoMsg" style="display: block;margin-bottom: 20px;"><i class="fa fa-fw fa-info-circle"></i>This signature will be applied to all selected proposals, except for.
            <ul>
                <li style="padding:10px 0px">Proposals that have already been signed</li>
                <li  class="signature_admin_permission_msg">Proposals you do not have permission to sign</li>
            </ul>
            </div>
        <input type="hidden" id="signature_proposal_id" value="">
        <input type="hidden" id="signature_url" name="signature_url" value="">
        <div style="width:49%;float:left">
            <table class="boxed-table pl-striped" style="border-bottom:0px"; width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td><label style="width: 150px;text-align: left;">First Name <span>*</span></label><input type="text" name="signature_firstname" id="signature_firstname" class="text" style="width: 180px; float: left; " value=""></td>
                    <td><label style="width: 150px;text-align: left;">Last Name <span>*</span></label><input type="text" name="signature_lastname" id="signature_lastname" class="text"  style="width: 180px; float: left; " value=""></td>
                </tr>
                <tr>
                    <td><label for="" style="width: 150px;text-align: left;">Company Name <span>*</span></label><input type="text" id="signature_company_name" name="signature_company_name" class="text" style="width: 180px; float: left;" required value=""></td>
                    <td><label for="" style="width: 150px;text-align: left;">Title <span>*</span></label><input type="text" name="signature_title" id="signature_title" class="text" style="width: 180px; float: left; " value=""></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="" style="width: 85px;text-align: left;">Email <span>*</span></label><input type="text" name="signature_email" id="signature_email" class="text" style="width: 300px; float: left;" value=""></td>
                </tr>


                <tr>
                    <td><label style="width: 150px;text-align: left;">Address <span>*</span></label><input type="text" name="signature_address" id="signature_address" class="text" style="width: 180px; float: left; " value=""></td>
                    <td><label style="width: 150px;text-align: left;">City <span>*</span></label><input type="text" name="signature_city" id="signature_city" class="text"  style="width: 180px; float: left; " value=""></td>
                </tr>
                <tr>
                    <td><label for="" style="width: 150px;text-align: left;">State <span>*</span></label><input type="text" id="signature_state" name="signature_state" class="text" style="width: 180px; float: left;"  value=""></td>
                    <td><label for="" style="width: 150px;text-align: left;">Zip <span>*</span></label><input type="text" name="signature_zip" id="signature_zip" class="text" style="width: 180px; float: left; " value=""></td>
                </tr>
                <tr>
                    <td><label for="" style="width: 150px;text-align: left;">Office Phone <span>*</span></label><input type="text" id="signature_office_phone" name="signature_office_phone" class="text phoneFormat" style="width: 180px; float: left;"  value=""></td>
                    <td><label for="" style="width: 150px;text-align: left;">Cell Phone <span>*</span></label><input type="text" name="signature_cell_phone" id="signature_cell_phone" class="text phoneFormat" style="width: 180px; float: left; " value=""></td>
                </tr>


            </table>
        </div>
        <div style="width:49%;float:left;border:0px;margin-left: 10px" id="signature-tabs">
            <label style="width: 140px;;margin-top: 4px;font-weight: bold;line-height: 24px;display: block;">Signature</label>
            
            <ul>
                <li><a href="#tabs-1">Draw</a></li>
                <li><a href="#tabs-2">Upload</a></li>
                <li><a href="#tabs-3">Type</a></li>
            </ul>
            <div id="tabs-1" style="min-height: 235px;">
                <div id="my_pad" style="height: 235px;">
                    <div id="signature-pad" class="signature-pad">
                        <div class="signature-pad--body">
                            <canvas></canvas>
                        </div>
                        <div class="signature-pad--footer">
                            <div class="description">Sign above</div>

                            <div class="signature-pad--actions">
                                <div>
                                    <button type="button" class="button clear" data-action="clear">
                                        Clear
                                    </button>

                                    <button type="button" class="button" data-action="undo">Undo
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tabs-2" style="min-height: 228px;">
                <div class="input-group" style="margin-top:20px;">
                        <input type="file" class="form-control" id="signature_file_input"
                                onchange="previewFile(this);" accept="image/*"
                                style="border-color:rgb(206, 212, 218);background-image:none">

                </div>

                <img id="previewImg" src="" class="img-fluid img-thumbnail" style="max-width:230px;display:none;margin-top:20px;border-color:none;background-image:none">
            </div>
            <div id="tabs-3" style="min-height: 228px;">
                <div class="input-group" style="margin-top:20px;">
                    <input type="text" placeholder="Type your name to sign" class="text" id="signature_type_input" >
                    <input type="hidden"  id="signature_type" >
                </div>
                <div class="type_preview_box">
                    <div class="choose_sign_option1 choose_sign_div" style="height: 60px;">
                        <input type="radio" class="sign_radio dont-uniform" id="choose_sign_option1" value="1" name="choose_sign_radio" />
                        <input type="hidden" id="choose_sign_data_url_option1" name="choose_sign_data_url_option1" />
                        <canvas id="choose_sign_canvas_option1" width="380" height="80"></canvas>
                        
                    </div>
                    <div class="choose_sign_option2 choose_sign_div" style="height: 60px;">
                        <input type="radio" class="sign_radio dont-uniform" id="choose_sign_option2" value="2" name="choose_sign_radio" />
                        <input type="hidden" id="choose_sign_data_url_option2" name="choose_sign_data_url_option2" />
                        <canvas id="choose_sign_canvas_option2" width="380" height="80"></canvas>
                        
                    </div>
                    <div class="choose_sign_option3 choose_sign_div" style="height: 60px;">
                        <input type="radio" class="sign_radio dont-uniform" id="choose_sign_option3" value="3" name="choose_sign_radio" />
                        <input type="hidden" id="choose_sign_data_url_option3" name="choose_sign_data_url_option3" />
                        <canvas id="choose_sign_canvas_option3"width="380" height="80"></canvas>
                        
                    </div>
                    
                </div>
            </div>
            <div class="boxed-table">
                <label for="" style="width: 85px;text-align: left;">Comments</label><textarea rows="4" name="signature_comments" id="signature_comments" class="text" style="width: 300px; float: left; "></textarea>
            </div>
        </div>       
        <span class="signature_validation_msg" style="right: 0;font-size: 12px;font-weight: bold;color: rgb(255, 0, 0);bottom: 0;position: absolute;">Please Fill all required fields.</span>
        <span class="signature_msg" style="right: 0;font-size: 12px;font-weight: bold;color: rgb(255, 0, 0);bottom: 0;position: absolute;">Please provide a valid Signature.</span>
    </div>
    <!-- end add sign dialog-->




     <!-- add customer checklist dialog-->
     <div id="customerChecklistDialog" title="Customer Checklist" style="display:none;min-height:540px">
    
     <input type="hidden" id="billing_proposal_id" value="">

      <div style="width:49%;float:left">
    <label style="font-weight:bold;position:relative;top:28px; ">CUSTOMER BILLING INFORMATION </label>

        <table class="boxed-table pl-striped" style="border-bottom:0px; margin-top:10px;" width="48%" cellpadding="0" cellspacing="0">
            <tr>
                <td><label style="width: 150px;text-align: left;">Billing Contact <span>*</span></label><input type="text" name="billing_contact" id="billing_contact" class="text" style="width: 180px; float: left; " value=""></td>
                <td style="float:left;margin-top:40px;"><label style="width: 150px;text-align: left;">Billing Address <span>*</span></label>
                       <textarea rows="4" name="billing_address" id="billing_address" class="text" style="width: 181px; float: left; "></textarea>
                    </td>
            </tr>
            <tr>
                <td><label for="" style="width: 150px;text-align: left;">Phone <span>*</span></label><input type="text" id="billing_phone" name="billing_phone" class="text phoneFormat" style="width: 180px; float: left;" required value=""></td>
                <td><label for="" style="width: 150px;text-align: left;">Billing Email <span>*</span></label>
                <input type="text" name="billing_email" id="billing_email" class="text" style="width: 180px; float: left; " value=""></td>
            </tr>
           


            <tr>
                <td><label style="width: 150px;text-align: left;">Property Owner Name <span>*</span></label><input type="text" name="property_owner_name" id="property_owner_name" class="text" style="width: 180px; float: left; " value=""></td>
                <td style="float:left;margin-top:40px;"><label style="width: 150px;text-align: left;">Legal Address <span>*</span></label>
                <textarea rows="4" name="legal_address" id="legal_address" class="text" style="width: 181px; float: left; "></textarea>
                </td>
            </tr>
            <tr>
                <td><label for="" style="width: 150px;text-align: left;">Phone <span>*</span></label><input type="text" id="customer_phone" name="customer_phone" class="text phoneFormat" style="width: 180px; float: left;"  value=""></td>
                <td><label for="" style="width: 150px;text-align: left;">Email <span>*</span></label>
                <input type="text" name="customer_email" id="customer_email" class="text" style="width: 180px; float: left; " value=""></td>
            </tr>
            


        </table>
    </div>
    <div style="width:48%;float:left;border:0px;margin-left: 10px" id="signature-tabs">
                <div class="PrintChecklist" style="display: none;"> 
                    <a  href="#" onclick="print_checklist()" >
                    <img src="/3rdparty/icons/print.png"> Print 
                    </a>
               </div>
        <p style="font-weight:bold;position:relative;top:28px;">ONSITE CONTACT INFORMATION </p>

        <table class="boxed-table pl-striped" style="border-bottom:0px;margin-top:10px;" width="47%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="float:left;"><label style="width: 120px;text-align:left;margin-top:38px;">Onsite Contact <span>*</span></label>
                <input type="text" name="onsite_contact" id="onsite_contact" class="text" style="width: 160px; float: left; " value=""></td>
                <td ><label style="text-align: left;margin-top:30px;">Phone <span>*</span></label>
                <input type="text" name="onsite_phone" id="onsite_phone" class="text phoneFormat"  style="width: 180px; float: left; " value=""></td>
            </tr>
            <tr>
                <td><label for="" style="width: 150px;text-align: left;">Email <span>*</span></label><input type="text" id="onsite_email" name="onsite_email" class="text" style="width: 180px; float: left;" required value=""></td>
                <td><label for="" style="width: 150px;text-align: left;">Invoicing Portal Y/N <span>*</span></label><input type="text" name="invoicing_portal" id="invoicing_portal" class="text" style="width: 180px; float: left; " value=""></td>
            </tr>
            
            <tr>
                <td><label style="width: 150px;text-align: left;">Special Instruction: </label>
                <textarea rows="4" name="special_instruction" id="special_instruction" class="text" style="width: 181px; float: left;">
                </textarea>
            </tr> 
        </table>
        
      
        
    </div>       
    <span class="customer_checklist_validation_msg" style="right: 0;font-size: 12px;font-weight: bold;color: rgb(255, 0, 0);bottom: 0;position: absolute;">Please Fill all required fields.</span>
    <span class="signature_msg" style="right: 0;font-size: 12px;font-weight: bold;color: rgb(255, 0, 0);bottom: 0;position: absolute;">Please provide a valid Url.</span>
</div>
<!-- customer checklist dialog-->

<style>
    #uniform-templateSelect span {
        width: 200px!important;
    }

    #uniform-templateSelect {
        width: 225px!important;
    }
    #uniform-templateFields span {
        width: 125px!important;
    }

    #uniform-templateFields {
        width: 150px!important;
        margin-left: 41px;
    }
    #uniform-resendSelect span {
        width: 200px!important;
    }

    #uniform-resendSelect {
        width: 225px!important;
    }
    #uniform-resendSelect select{
        width: 225px!important;
    }

    #fancybox-overlay {
        z-index: 1002 !important;
    }

    #proposalsTable tbody tr.odd.selectedRow,
    #proposalsTable tbody tr.even.selectedRow,
    #proposalsTable tbody tr.even.selectedRow td.sorting_1,
    #proposalsTable tbody tr.odd.selectedRow td.sorting_1
    {
        background-color: #e4e3e3!important;
    }

    #proposalsTable tbody tr.odd.sharedProposal,
    #proposalsTable tbody tr.even.sharedProposal,
    #proposalsTable tbody tr.even.sharedProposal td.sorting_1,
    #proposalsTable tbody tr.odd.sharedProposal td.sorting_1
    {
        background-color: #bce7ef;;
    }

    #addProposalDialog .select2-container {
    width: 60.5% !important;
    padding: 0;
    }

    #proposal-sharing-dialog .select2-container {
    width: 65% !important;
    padding: 0;
    }
.select2-selection__rendered{
    float: left!important;

}
.select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}
.select_box_error {
    border-radius: 2px;
    border: 1px solid #e47074 !important;
    background-color: #ffedad !important;
    box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
}
#add-note {
    margin-top: 15px;
}
#add-note button{
    font-size: 15px;
}
#add-note button span{
    line-height: 0;
}
#tiptip_holder {
    max-width: 400px!important;

}
#showProposalLinksTable_wrapper{padding-bottom: 75px!important;}
#showProposalLinksTable_wrapper .dropdownMenu{
    padding-left: 0px!important;
}
#select2-SeachaccountName-container{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    width: 265px;
}

</style>

    <div id="resend-proposals" title="Confirmation">
        <h3><i class="fa fa-fw fa-envelope-o"></i> Group Resend Emails</h3>
        <p style="margin-bottom: 15px;">
        <span style="padding-right: 38px;font-weight:bold">Email Template</span>

            <select id="templateSelect">
                <?php
                foreach ($clientTemplates as $template) {
                    /* @var $template \models\ClientEmailTemplate */
                    ?>
                    <option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo str_replace('\'', '\\\'', $template->getTemplateName()); ?></option>
                    <?php
                }
                ?>
            </select>

            <?php if ($account->isAdministrator()) { ?>
            <span style="float: right;padding-right: 65px;"><input type="checkbox" id="emailCustom"> <span style="display: inline-block; padding-top: 2px;"> Customize Email Sender Info</span></span>

        <?php } ?>
                <span style="float: right;padding-right: 15px;"><input type="checkbox" id="emailCC"> <span
                    style="display: inline-block; padding-top: 2px;"> Send CC to User</span></span>



    </p>
    <p>

    <span style="padding-right: 13px;font-weight:bold">Choose Campaign:</span>

        <select name="resendId" id="resendSelect" >
                <option value="">Select Resend Campaign</option>
                <option value="0">New</option>
                <option value="-1">No Campaign</option>
                
            </select>
        <label style="padding-left: 150px;font-weight:bold" class="no_campaign">Campaign Name:</label>
        <input type="text" class="text new_resend_name no_campaign" name="new_resend_name"/>

    </p><br/>




        <p style="margin-bottom: 15px;">
            <span style="width: 100px; display: inline-block;padding-right: 39px;font-weight:bold ">Subject:</span><input
                class="text" type="text" id="messageSubject" style="width: 225px;">
                <label style="padding-left: 150px;font-weight:bold" class="no_campaign">Add Field:</label>
                <select id="templateFields">
                        <option value="">- Select a field</option>
                        <?php
                        foreach ($proposal_email_template_fields as $fields) {
                            ?>
                            <option value="{<?php echo $fields->getFieldCode(); ?>}"><?php echo $fields->getFieldName(); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <a class="btn" href="javascript:void(0);" id="addAtCursorEdit"><i class="fa fa-fw fa-plus-circle"></i> Add</a>



        </p>
        <?php if ($account->isAdministrator()) { ?>
        <p class="emailFromOption" style="color: #b81900; margin-bottom: 10px;">Leave blank for the emails to come from
            the owner of the proposal.</p>
        <p class="emailFromOption" style="margin-bottom: 10px;"><span
                    style="width: 100px;font-weight:bold; display: inline-block">From Name:</span><input class="text"
                                                                                                         type="text"
                                                                                                         id="messageFromName"
                                                                                                         style="width: 200px;"><span
                    style="padding-left: 50px;width: 100px;font-weight:bold; display: inline-block">From Email:</span><input
                    class="text" type="text" id="messageFromEmail" style="width: 200px;"></p>

    <?php } ?>

        <p style="font-weight:bold;margin-bottom: 10px;">Email Content</p>
        <span style="color: rgb(184, 25, 0);margin-bottom: 10px;display:none" class="is_templateSelect_disable adminInfoMessage "><i class="fa fa-fw fa-info-circle"></i> Email content cannot be edited when adding to an existing campaign</span>
        <textarea id="message" style="height:320px">This is the content</textarea>
        
        <?php  if($account->requiresApproval()==1){
                $approvalLimit = $account->getApprovalLimit();
                $formattedLimit = '$' . number_format($approvalLimit, 2);

            ?>
        <div style="margin-top:2px;color:#b81900;font-size:12px;">Note:You have "Require bid approval" limit <?php echo $formattedLimit;  ?> so it will not send email 
        to proposals those total are more than <?php echo $formattedLimit;  ?></div>
        <?php } ?>


        <!-- <div style="width:95%;float: left;background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;margin-top:5px;border-radius:4px;line-height: 20px;">
            <div style="width: 33%;float: left;" class="has_excluded"><strong><span id="resendNum"></span></strong> Proposals Selected</div>
            <div style="width: 33%;float: left;text-align: center;"><strong>This will send <span id="resendIncludeNum"></span> emails</strong></div>
            <div style="width: 33%;float: left;text-align: right;" class="has_excluded"><strong><span id="resendExcludeNum"></span></strong> emails are tagged as 'Email Off'</div>
            <div style="width: 33%;float: left;margin-top:5px;" class="has_excluded_hide"><input type="checkbox" id="sendExcludedEmail" style="margin-left:0px;margin-top:0px;"><span style="margin-top: -2px;position: absolute;" >Send All Emails <i class="fa fa-fw fa-info-circle tiptipright" style="cursor:pointer;" title="Send ALL proposals, even if tagged as 'Email Off'"></i></span></div>
        </div> -->
        <br/>
        <p class="is_templateSelect_disable" style="margin-bottom: 10px;">Note: If you have already emailed a proposal in this campaign, it will not be resent</p>

    </div>

    <div id="preconfirm-resend-proposals" title="Confirmation">
        <h3>Confirmation - Resend Proposals</h3>

        <div style="width:88%;float: left;background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;margin-top:5px;border-radius:4px;line-height: 20px;">
            <div style="width: 95%;float: left;"><strong>This will send <span id="resendIncludeNum"></span> emails</strong></div>
            <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="resendNum"></span></strong> Proposals Selected</div>
            <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="resendExcludeNum"></span></strong> emails are tagged as 'Email Off'</div>
            <div style="width: 95%;float: left;margin-top:5px;" class="has_excluded_hide"><input type="checkbox" id="sendExcludedEmail" style="margin-left:0px;margin-top:0px;"><span style="margin-top: -2px;position: absolute;" >Send All Emails <i class="fa fa-fw fa-info-circle tiptipright" style="cursor:pointer;" title="Send ALL proposals, even if tagged as 'Email Off'"></i></span></div>
        </div>
    </div>

    <div id="resend-proposals-status" title="Confirmation">
        <h3>Confirmation - Resend Proposals</h3>

        <p id="resendProposalsStatus"></p>
        <p id="alreadyProposals" style="margin-top: 10px;"></p>
        <p id="bouncedProposals" style="margin-top: 10px;"></p>
        <p id="unsentProposals" style="margin-top: 10px;"></p>
        <p id="unsentDetails" style="margin-top: 10px;">Only approved proposals, or proposals below the Approval Limit were sent</p>
    </div>

    <div id="delete-proposals" title="Confirmation">
        <h3>Confirmation - Delete Proposals</h3>

        <p>This will delete a total of <strong><span id="deleteNum"></span></strong> proposals.</p>
        <br/>
        <p id="deleteDuplicatesOption"><input type="checkbox" id="deleteDuplicates"> Also delete duplicates?</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="delete-proposals-status" title="Confirmation">
        <h3>Confirmation - Delete Proposals</h3>

        <p id="deleteProposalsStatus"></p>
    </div>

    <div id="status-proposals" title="Confirmation">
        <h3>Updating status of <span id="statusChangeNum"></span></strong> proposals.</h3>

        <p>Change to: <select id="changeStatus">
                <?php foreach ($statuses as $status) {
                        /* @var \models\Status $status */
                ?>
                    <option value="<?php echo $status->getStatusId(); ?>" data-sales="<?php echo $status->getSales(); ?>"><?php echo $status->getText(); ?></option>
                <?php } ?>
            </select>
        </p>
        <br/>

        <div id="statusWin" style="display: none;">
            <p><strong><span id="statusUnwonCount"></span></strong> proposals will be marked as won.</p><br />
            <p>Select the win date for these proposals: <input type="text" class="text" id="statusWinDate" /></p>
        </div>
        <div id="statusUnwin" style="display: none;">
            <p><strong><span id="statusWonCount"></span></strong> proposals that are currently 'sold' will become unsold.</p><br />
        </div>
        <br />
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="status-proposals-status" title="Confirmation">
        <h3>Confirmation - Update Proposal Status</h3>

        <p id="statusProposalsStatus"></p>
    </div>

    <div id="status-unduplicate" title="Make Standalone">
        <p>This will convert any selected duplicate proposals into standalone proposals.</p>
        <br/>
        <p>Are you sure you want to proceed?</p>
    </div>

    <div id="standalone-status" title="Confirmation">
        <h3>Confirmation - Setting proposals to Standalone</h3>

        <p id="standaloneStatus"></p>
    </div>

    <div id="status-date-change-confirm" title="Update Status Change Date">
        <p>This will update when the proposal was changed to the current status.</p>
        <br/>
        <p>Select Date: <input type="text" id="sdcDate"/></p>
    </div>

    <div id="sdc-status" title="Confirmation">
        <h3>Confirmation - Updating Status Change Date</h3>

        <p id="sdcStatus"></p>
    </div>

    <div id="date-change-confirm" title="Update Proposal Date">
        <p>This will update when the proposal was created</p>
        <br/>
        <p>Select Date: <input type="text" id="dcDate"/></p>
    </div>

    <div id="swdc-status" title="Confirmation">
        <h3>Confirmation - Updating Win Date</h3>

        <p id="swdcStatus"></p>
    </div>

    <div id="win-date-change-confirm" title="Update Proposal Win Date">
        <p style="margin-top: 10px;">Choose the Win Date for the selected proposals.</p>

        <p class="win-date-check-msg adminInfoMessage" style="margin-left: 0px;" ></p>

        <p style="margin-top: 10px;">Select Date: <input type="text" class="text" id="wdcDate"/></p>
    </div>

    <div id="win-date-none-change" title="Update Proposal Win Date">

        <p class="adminInfoMessage" style="margin-left: 0px;" ><i class='fa fa-fw fa-info-circle'></i>None of the proposals you have selected have a 'Won' Status so we can't update any win dates.</p>
    </div>

    <div id="dc-status" title="Confirmation">
        <h3>Confirmation - Updating Proposal Date</h3>

        <p id="dcStatus"></p>
    </div>


    <div id="reassign-proposals" title="Reassign Proposals">
        <h3>Confirmation - Reassign Proposals</h3>

        <p>Change to: <select id="reassignUser">
                <?php foreach ($accounts as $userAccount) { ?>
                    <option value="<?php echo $userAccount->getAccountId(); ?>"><?php echo $userAccount->getFullName() ?></option>
                <?php } ?>
            </select>
        </p>
        <br/>

        <p>This will update the owner of <strong><span id="statusChangeNum"></span></strong> proposals.</p>
        <br/>

        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="reassign-proposals-status" title="Confirmation">
        <h3>Confirmation - Reassign Proposal Status</h3>

        <p id="reassignProposalsStatus"></p>
    </div>

    <div id="groupResendSettingsModal" title="Change Auto Re-Send Settings">
        <h3>Group Auto Re-Send Settings</h3>

        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Auto Re-Send</label>
                        <select name="automatic_resend" id="automatic_resend" style="float: left;">
                            <option value="0">Disabled</option>
                            <option value="1">Enabled</option>
                        </select>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Every</label>
                        <input type="text" name="frequency" id="frequency" value="<?= (($proposal_resend_frequency / 86400) >= 1) ? (round($proposal_resend_frequency / 86400)) : 1 ?>" class="text" style="width: 20px;">
                        <label style="text-align: left; width: auto;">Days</label>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Template</label>
                        <select name="template" id="template" style="float: left;">
                            <?php foreach ($proposal_email_templates as $template): /** @var $template models\ClientEmailTemplate */ ?>
                                <option value="<?= $template->getTemplateId() ?>"><?= str_replace('\'', '\\\'', $template->getTemplateName()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="exportProposals" title="Select File Name">
        <p>Enter a file name for your export</p>
        <br/>

        <p><input type="text" id="exportName" placeholder="File Name"></p>
    </div>

    <div id="proposalActivity" title="Proposal Activity">
        <h4><i class="fa fa-fw fa-history"></i> Proposal Activity: <span id="proposalActivityProjectName"></span></h4>
        <hr />

        <table id="proposalActivityTable" class="boxed-table" style="width: 100%">
            <thead>
            <tr>
                <th>Date Int</th>
                <th>Date</th>
                <th>User</th>
                <th>IP Address</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div id="price-modifier-dialog" title="Modify Proposal Prices" style="text-align: center;">
        <br />
        <p>Choose a percentage value to modify all proposal service prices by.</p><br />

        <div style="text-align: center;">
            <input type="number" step="0.01" id="priceModifierValue" value="0.00" style="width: 80px; padding: 5px; font-size: 20px" /> %
        </div>

        <br /><br />
        <p>Click 'Apply' to adjust the price of all selected proposals.</p>
        <br /><br />
    </div>

    <div id="copy-to-contact-dialog" title="Copy Proposals">
        <h3>Confirmation - Copy <span id="copyChangeNum"></span></strong> Proposals.</h3>

        <p>This will create a copy of the proposal for the same client.</p><br />

        <p>Change to: <select id="copyToContactStatus">
                <?php foreach ($statuses as $status) {
                    /* @var \models\Status $status */
                    ?>
                    <option value="<?php echo $status->getStatusId(); ?>" data-sales="<?php echo $status->getSales(); ?>"><?php echo $status->getText(); ?></option>
                <?php } ?>
            </select>
        </p>
    </div>
    <div id="proposalViews" title="Proposal Views" style="display:none;">
        <h4><span class="proposal_view_project_name" style="color: #3f3f41;"></span>: Proposal Views</h4><a href="javascript:void(0)" class="reloadProposalViewTable blue-button btn" style="position: absolute;right: 13px;top: 10px;"><i class="fa fa-fw fa-refresh"></i> Reload Table</a>
        <hr />

        <table id="showProposalViewsTable" class="boxed-table" style="width: 100%">
            <thead>
            <tr>
                
                <th>Viewer</th>
                <th>Last Viewed</th>
                <th>View Time</th>
                <!-- <th>Status</th> -->
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div id="sharedProposalUserDialog" title="Shared Proposal Users" style="display:none;">
        <h4><span class="shared_proposal_project_name" style="color: #3f3f41;"></span>: Shared Proposal Users</h4>
        <hr />

        <table id="showSharedProposalUserTable" class="boxed-table" style="width: 100%">
            <thead>
            <tr>
                
                <th>User</th>
                <th>Email</th>
                <th>Company</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>
<script>
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var changeColorButton = wrapper.querySelector("[data-action=change-color]");
    var undoButton = wrapper.querySelector("[data-action=undo]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
    var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
    var canvas = wrapper.querySelector("canvas");
    console.log(clearButton);
    var signaturePad = new SignaturePad(canvas, {
        // It's Necessary to use an opaque color when saving image as JPEG;
        // this option can be omitted if only saving as PNG or SVG
        backgroundColor: 'rgb(255, 255, 255)'
    });

    console.log(signaturePad);
    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        // This part causes the canvas to be cleared
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        //canvas.height = 150;
        canvas.getContext("2d").scale(ratio, ratio);

        signaturePad.clear();
    }

    // On mobile devices it might make more sense to listen to orientation change,
    // rather than window resize events.
    window.onresize = resizeCanvas;
    resizeCanvas();

   

    // One could simply use Canvas#toBlob method instead, but it's just to show
    // that it can be done using result of SignaturePad#toDataURL.
    function dataURLToBlob(dataURL) {
        // Code taken from https://github.com/ebidel/filer.js
        var parts = dataURL.split(';base64,');
        var contentType = parts[0].split(":")[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], {
            type: contentType
        });
    }

    clearButton.addEventListener("click", function (event) {
        signaturePad.clear();
    });

    undoButton.addEventListener("click", function (event) {
        var data = signaturePad.toData();

        if (data) {
            data.pop(); // remove the last dot or line
            signaturePad.fromData(data);
        }
    });

    function print_checklist()
    {
        var proposal_id = $("#billing_proposal_id").val();
        var url = "<?php echo site_url('pdf/checklist') ?>/" + proposal_id;
        window.open(url);
    }


    </script>

