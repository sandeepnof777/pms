 
<style>
 #dialog-message .clearfix {
    line-height: 1.7!important;
}
   
.paging_full_numbers {
    width: 500px !important;
}
.datatable-scroll {
    overflow-x: auto;
    overflow-y: visible;
}

.dataTables_info {
    width: 46%!important;
    clear: none!important;
}
.error_editor {
    border: 2px solid #FBC2C4;
}
.client_table_checkbox div{padding: 0px!important;}
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
.locked-tag .select2-selection__choice__remove{
            display: none!important;
        }
        .locked-tag:before {
            font-family: "FontAwesome";
            content: "\f023";
            border-right: 1px solid #aaa;
            cursor: pointer;
            font-weight: bold;
            padding: 0 4px;
        }
.dataTables-clientsNew tbody tr.odd.selectedRow,
.dataTables-clientsNew tbody tr.even.selectedRow,
.dataTables-clientsNew tbody tr.even.selectedRow td.sorting_1,
.dataTables-clientsNew tbody tr.odd.selectedRow td.sorting_1
{
    background-color: #e4e3e3!important;
}
.select2-container {
    width: 250px !important;
    padding: 0;
}

</style>
<table cellpadding="0" cellspacing="0" border="0" class="dataTables-clientsNew display nowrap" id="clientsTable">
    <thead>
    <tr>
        <td class="client_table_checkbox"><input type="checkbox" id="clientMasterCheck"></td>
        <td></td>
        <td>Account</td>
        <td>Business</td>
        <td>Contact</td>
        <td>Email</td>
        <td>Cell Phone</td>
        <td>Bids</td>
        <td>Bid Total</td>
        <td>Owner</td>
        
        <td>Last Activity Timestamp</td>
        <td>Last Activity</td>
        <td>Opened At</td>
        
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<div id="datatablesError" title="Error" style="text-align: center; display: none;">
    <h3>Oops, something went wrong</h3>

    <p>We're having a problem loading this page.</p><br />
    <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>&subject=Support: Help with Table">contact support</a> if this keeps happening.</p>
</div>
<div id="clients-delete-status" title="Delete Contact">

    <p id="clientDeleteStatus">Deleting Contact...<img src="/static/loading.gif" /></p>

</div>
<script type="text/javascript">
var clientFilter;

    var ui;

    $(document).ready(function() {
        if(localStorage.getItem("client_column_show_1") == null && localStorage.getItem("client_column_show") != null){

                var column_local_storage = localStorage.getItem("client_column_show");
                column_local_storage = column_local_storage.split(",");
                var index = column_local_storage.indexOf("7");
                var index2 = column_local_storage.indexOf("9");
                
                if (index !== -1) {
                    column_local_storage[index] = "9";
                }
                if (index2 !== -1) {
                    column_local_storage[index2] = "11";
                }
                
                column_local_storage.push("7","8");
                
            localStorage.setItem("client_column_show_1",column_local_storage);
        }
        // Datatables error Dialog
        $("#datatablesError").dialog({
            width: 500,
            modal: true,
            buttons: {
                Retry: function () {
                    window.location.reload();
                }
            },
            autoOpen: false
        });
    });
</script>
<?php 

    $url = 'ajax/ajaxGetClients';
    $resend_id = $this->uri->segment(3);
    if ($filterResend) {
        $url = 'ajax/ajaxGetClients?action=resend&resend_id='.$resend_id;
    }
?>
<script type="text/javascript">
function getFilterValue() {
    return $("#campaignEmailFilter").val();
}
//console.log(getFilterValue());
var oTable;
    $(document).ready(function () {
        $.fn.dataTable.ext.errMode = 'none';
        deletePermission = <?php echo ($account->hasFullAccess() ? 'true' : 'false'); ?>;
function initClientTable(){

     oTable =  $('.dataTables-clientsNew').on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
        $("#datatablesError").dialog('open');
    } )
    .on('processing.dt', function (e, settings, processing) {
        if (processing) {
            $("#clientsTableLoader").show();
        } else {
            $("#clientsTableLoader").hide();
        }
    })
    .DataTable( {
        search:  {
            search: "<?php echo $search; ?>"
        },
        "processing": true,
        "serverSide": true,
        "preDrawCallback": function( settings ) {
            if ($.fn.DataTable.isDataTable('.dataTables-clientsNew')) {
                var dt = $('.dataTables-clientsNew').DataTable();

                //Abort previous ajax request if it is still in process.
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        },
        "ajax": {
            url: "<?php echo site_url($url); ?>",
            data: function(d) {
                d.type = getFilterValue();
            }
        },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "width":'5px',
                "searchable": false,
                "sortable": false
            },
            {"targets": [ 1 ],"sortable": false},
            {"targets": [ 2 ],"sortable": true},
            {"targets": [ 3 ],"sortable": false},
            {"targets": [ 4 ],"sortable": true},
            {"targets": [ 5 ],"sortable": true},
            {"targets": [ 6 ],"sortable": true},
            {"targets": [ 7 ],"sortable": true,"class": 'dtCenter'},
            {"targets": [ 8 ],"sortable": true,"class": 'dtCenter'},
            {"targets": [ 9 ],"sortable": true},
            {"targets": [ 10 ],"visible": false},
            {"targets": [ 11 ],"searchable": false, 'orderData': 10,"visible": <?php echo $show_last_activity;?>},
            {"targets": [ 12 ],"searchable": false,"visible": <?php echo $show_opened_at;?>},
            
        ],
        "sorting": [
                 [11, "desc"]
             ],
        "jQueryUI": true,
        
            "scrollX": true,
        "autoWidth": false,
        "scrollY": '70vh',
        "scrollCollapse": true,
        "paginationType": "full_numbers",
        "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
        "lengthMenu": [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000]
        ],
        "drawCallback": function (settings) {

            if (!ui) {
                initUI(true);
                ui = false;
            }
            notes_tooltip();
            check_highlighted_row();
            if (oTable) {

                $("#filterNumResults").text(oTable.page.info().recordsDisplay);
                numMappedProposals = oTable.page.info().recordsDisplay;

                // Only Update if map is visible
                //updateMap(true);

            }
            $("#groupSelectAllTop").html('<span id="numSelected">0</span> selected');
            $("#clientMasterCheck").prop('checked', false);
            $("#filterLoading").hide();
            $("#filterResults").show();
            //$("#filterResults").css('visibility', 'visible');
        }
    } );
    oTable.column(10).visible(false);
   <?php if($show_opened_at === 'false'){?>
        oTable.column(12).visible(false);
    <?php } ?>
    var column_show = localStorage.getItem("client_column_show_1");
    if(column_show){
        oTable.columns( [2,3,4,5,6,7,8,9,11] ).visible( false );
        oTable.columns(column_show).visible( true );
        var column_show = column_show.split(',');
        for($i=0;$i < column_show.length;$i++){
            $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
        }

    } else {
        $(".column_show").prop("checked",true);

        var column_show = [2,3,4,5,6,7,8,9,11];
        console.log(column_show);
        oTable.columns( column_show ).visible( true );
        // for($i=0;$i < column_show.length;$i++){
        //     $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
        // }
        // $(".column_show").attr('checked', 'checked');
    }
}


        function applyFilter() {
        $("#filterResults").hide();
        //$("#filterResults").css('visibility', 'hidden');
        $("#filterLoading").show();
        setTimeout(function () {
            $(".resetFilter").show();

            var users = [];
            var userValues = [];
            var leadBusinessTypes = [];
            var leadBusinessTypeValues = [];

            if ($(".businessTypeFilterCheck:checked").length != $(".businessTypeFilterCheck").length) {
                leadBusinessTypes = $(".businessTypeFilterCheck:checked").map(function () {
                    leadBusinessTypeValues.push($(this).attr('data-text-value'));
                    return $(this).val();
                }).get();
            }

            if (!leadBusinessTypes.length) {
                leadBusinessTypes = [];
            }

            if ($(".userFilterCheck:checked").not('.branchFilterCheck').length != $(".userFilterCheck").not('.branchFilterCheck').length) {
                users = $(".userFilterCheck:checked").not('.branchFilterCheck').map(function () {
                    userValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!users.length) {
                users = [];
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

            var filterBadgeHtml = '';
            var userHeaderText = ' [ All ]';
            var accountHeaderText = ' [ All ]';
            var businessTypeHeaderText = ' [ All ]';
            var excludeIncludeHeaderText = ' [ All ]';
            var numFilters = 0;

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


// Business Type
            if (leadBusinessTypes.length) {

                numFilters++;
                $('#businessTypeFilterHeader').addClass('activeFilter');

                var businessTypeBadgeText = '[' + leadBusinessTypes.length + ']';
                businessTypeHeaderText = '[' + leadBusinessTypes.length + ']';
                    if ($(".businessTypeFilterCheck:checked").length == $(".businessTypeFilterCheck").length) {
                        businessTypeBadgeText = 'All';
                        businessTypeHeaderText = '[ All ]';
                    }

                if (leadBusinessTypes.length == 1) {
                    businessTypeBadgeText = leadBusinessTypeValues[0];
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

        // resend exclude/include

        var resendInclude = $('#cResendInclude').prop("checked") ? 1 : 0 ;
        var resendExclude = $('#cResendExclude').prop("checked") ? 1 : 0 ;

        //exclude filter start
        var excludeCheck = [];
        var excludeCheckValues = [];

        excludeCheck = $(".excludeCheck:checked").map(function () {
                    excludeCheckValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                if (!excludeCheck.length) {
                    excludeCheck = [];
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

            var numOtherValues = (excludeCheck.length);

            if (numOtherValues==1) {
                $('#excludeIncludeFilterHeader').addClass('activeFilter');
                excludeIncludeHeaderText = '[' + numOtherValues + ']';
            }
            else {
                $('#excludeIncludeFilterHeader').removeClass('activeFilter');
            }
            $("#excludeIncludeHeaderText").text(excludeIncludeHeaderText);
            
            // exclude filter end

            // Apply the HTML
            $("#filterBadges").html(filterBadgeHtml);

            if (numFilters < 1) {
                $(".filterButton").removeClass('update-button');
                $(".filterButton").addClass('grey');
                $('.resetFilterButton').hide();
                $('#newResetClientFilterButton2').hide();
            }
            else {
                $(".filterButton").addClass('update-button');
                $(".filterButton").removeClass('grey');
                $('.resetFilterButton').show();
                $('#newResetClientFilterButton2').show();
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
            for($i=0;$i<leadBusinessTypeValues.length;$i++){
                var queryStr = { "id" : leadBusinessTypes[$i],"name": leadBusinessTypeValues[$i]};
                business_type_object_array.push(queryStr);
            }

            
            clientFilter = { 
                    "cFilterUser": userValues,
                    "cFilterUserObject": user_object_array,
                    "cFilterClientAccount": clientAccountValues,
                    "cFilterClientAccountObject": account_object_array,
                    "cFilterBusinessType":leadBusinessTypeValues,
                    "cFilterBusinessTypeObject": business_type_object_array,
                    "cResendInclude": resendInclude,
                    "cResendExclude": resendExclude,
                     };

            <?php 
                if($this->uri->segment(2)!='resend'){
                    $filter_url = site_url('ajax/setClientFilter');
                }else{
                    $filter_url = site_url('ajax/setClientResendFilter').'/'.$this->uri->segment(3);
                }
            
            ?>         
            $.ajax({
                type: "POST",
                url: '<?php echo $filter_url; ?>',
                data: {
                    cFilterUser: users,
                    cFilterClientAccount: clientAccounts,
                    cFilterBusinessType: leadBusinessTypes,
                    cResendInclude: resendInclude,
                    cResendExclude: resendExclude,
                },
                dataType: 'JSON',
                success: function () {
                    // Update the table
                   // oTable.fnDraw();
                  
                   //oTable.ajax.reload();
                   if($.fn.DataTable.isDataTable('#clientsTable')){
                        oTable.ajax.reload();
                    }else{
                        initClientTable();
                    }
                }
            });
            
        }, 200);
       
    }


        $("#saves_filter_list").change(function() {

        clearPreset = false;
            // Reset All Checkboxes
            $(".filterCheck, .filterColumnCheck").prop('checked', true);
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
                     if(key=='cFilterBusinessTypeObject'){
                        $('.businessTypeFilterCheck').prop('checked', false);
                        $('#allBusinessTypes').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.businessTypeFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                       
                    }else if(key=='cFilterBranch'){
                        if(value.length >2 ){
                            $('#allUsersCheck').prop('checked', true);
                        }else{
                            $('#allUsersCheck').prop('checked', false);
                            $('.pFilterBranch').prop('checked', false);
                            for($i=0;$i<value.length;$i++){
                                $('.branchFilterCheck[data-branch-id="' + value[$i] +'"]').prop('checked', true);
                            }
                        }
                        
                    }else if(key=='cFilterUserObject'){
                        $('.userFilterCheck').prop('checked', false);
                        $('#allUsersCheck').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.userFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                    }
                     else if(key=='cFilterClientAccountObject'){
                         console.log(value)
                         for($i=0;$i<value.length;$i++){
                             var checkbox =     '<div class="filterColumnRow searchSelectedRow">'+
                                                '<input type="checkbox" class="filterCheck clientAccountFilterCheck searchSelected" checked="checked" value="'+value[$i].id+'" data-text-value="'+value[$i].name+'"/>'+
                                                '<span class="accountName">'+value[$i].name+'</span> </div>';
                                                $('#accountsFilterColumn').append(checkbox);
                        }
                         
                     }else if(key=='cResendExclude'){
                       
                        if(value == 1){
                            $("#cResendExclude").prop('checked',true);
                        }
                        else{
                            $("#cResendExclude").prop('checked',false);
                        }
                     }
                     else if(key=='cResendInclude'){
                       
                        if(value == 1){
                            $("#cResendInclude").prop('checked',true);
                        }
                        else{
                            $("#cResendInclude").prop('checked',false);
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
                $.uniform.update();
            }


        }, 500);
    });


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
        $("#confirm-delete-message").dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: function () {
                    var clientId = $("#client-delete").attr('rel');
                    console.log(clientId);
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        url: "<?php echo site_url('clients/delete'); ?>/"+clientId,
                        data: clientId,
                        dataType: "JSON"
                    }).success(function(response) {
                            if (response.success) {
                                oTable.ajax.reload(null,false);
                                $("#confirm-delete-message").dialog("close");
                                $("#clients-delete-status").dialog('open');
                                $("#clientDeleteStatus").html("1 Contact was Deleted");
                            } else {
                                $("#clientDeleteStatus").html("Something went wrong");
                            }
                        })
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        $("#clients-delete-status").dialog({
            width: 500,
            modal: true,
            autoOpen: false,
            buttons: {
                Ok: function () {
                   
                    $(this).dialog("close");
                }
            }
        });
        $("#permission-denied").dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        $(".confirm-deletion").live('click', function () {
            $('#newClientsPopup').hide()
            if (deletePermission) {
                $("#client-delete").attr('rel', $(this).attr('rel'));
                $("#confirm-delete-message").dialog('open');
            }
            else {
                $("#permission-denied").dialog('open');
            }
            return false;
        });
        $('.viewClient').live('click', function () {
            $('#newClientsPopup').hide()
            var clientId = $(this).attr('rel');
            $.getJSON("<?php echo site_url('ajax/getClientData') ?>/" + clientId, function (data) {
                var items = [];
                $.each(data, function (key, val) {
                    $("#field_" + key).html(val);
                });
            });
            $("#dialog-message").dialog("open");
        });
        /**
         * Email events stuff here
         */
        $("#email_events").dialog({
            modal: true,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            width: 700
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
        // $(".btn-notes, .view-notes").live('click', function () {
        //     $('#newClientsPopup').hide();
        //     var id = $(this).attr('rel');
        //     var frameUrl = '<?php echo site_url('account/notes/client') ?>/' + id;
        //     $("#notesFrame").attr('src', frameUrl);
        //     $("#relationId").val(id);
        //     $('#notesFrame').load(function () {
        //         $("#notes").dialog('open');
        //     });
        //     return false;
        // });
        // $("#add-note").submit(function () {
        //     var request = $.ajax({
        //         url: '<?php echo site_url('ajax/addNote') ?>',
        //         type: "POST",
        //         data: {
        //             "noteText": $("#noteText").val(),
        //             "noteType": 'client',
        //             "relationId": $("#relationId").val()
        //         },
        //         dataType: "json",
        //         success: function (data) {
        //             if (data.success) {
        //                 //refresh frame
        //                 $("#noteText").val('');
        //                 $('#notesFrame').attr('src', $('#notesFrame').attr('src'));
        //             } else {
        //                 if (data.error) {
        //                     alert("Error: " + data.error);
        //                 } else {
        //                     alert('An error has occurred. Please try again later!')
        //                 }
        //             }
        //         }
        //     });
        //     return false;
        // });
        $(".btn-notes, .view-notes").live('click', function () {
                    $('#newClientsPopup').hide();
                    var id = $(this).attr('rel');
                    var frameUrl = '<?php echo site_url('account/notes/client') ?>/' + id;
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
                                    
                                    $('.swal2-modal').attr('id','leads_notes_popup');
                                    setTimeout(function(){
                                                    $('#noteText').focus();
                                                },200);
                                }
                            }).then(function (result) {
                            
                        }).catch(swal.noop)
                        
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
                                "noteType": 'client',
                                "relationId": $("#relationId").val()
                            },
                            dataType: "json",
                            success: function (data) {
                                if (data.success) {
                                    //refresh frame
                                    $("#noteText").val('');
                                    $('#newNotesFrame').attr('src', $('#notesFrame').attr('src'));
                                    // Update the icon
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


        /**
         * Reassign stuff here
         */

        // The click

        $(".reassign-proposals").live('click', function() {
            $('#select-client').show();
            $('#newClientsPopup').hide();
            $('#selected-client').hide();
            $("#confirm-reassign").dialog('open');
        });

        // The modal
        $("#confirm-reassign").dialog({
            modal: true,
            buttons: {
                Save: {
                        'class': 'btn ui-button update-button',
                        text: 'Move Proposals',
                        click: function () {
                
                        var clientTo = $('#new-selected-client-id').val();
                        var clientFrom = $('.reassign-proposals').data('client-id');
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('clients/reassign');?>",
                            dataType: "json",
                            data: { clientTo : clientTo, clientFrom : clientFrom },
                            success: function (response) {
                                if(response.success){
                                    swal('', response.msg)
                                    $("#confirm-reassign").dialog("close");
                                    oTable.ajax.reload();
                                }
                            }
                        })
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            width: 700
        });

        $("#reassignClientTo").change(function() {
            $("#client-reassign").data('reassign', $(this).val());
        });



        $(".filterButton").click(function () {
            $(".newFilterContainer").toggle();
            $(".groupActionsContainer").hide();
        });

        $("#newProposalFilterButton").click(function () {
            hideInfoSlider();
            $("#newProposalFilters").toggle();
            // Clear search so that filters aren't affected
            oTable.fnFilter('');
            // Hide group action menu
            $(".groupActionsContainer").hide();
        });

        $("#closeFilters").click(function () {
            $(".newFilterContainer").toggle();
            $(".filterColumn, .filterColumnWide").addClass('filterCollapse');
        });

        $(".filterColumnWide .filterColumnHeader").click(function () {
            $(this).parents('.filterColumnWide').toggleClass('filterCollapse');

        });

        $(".filterColumn .filterColumnHeader").click(function () {
            $(this).parents('.filterColumn').toggleClass('filterCollapse');
        });

        // Group Actions Button
        $("#groupActionsButton").click(function () {
            // Hide the filter content
            $(".newFilterContainer").hide();
            // Toggle the buttons
            $(".groupActionsContainer").toggle();
        });

        //Hide Menu when clicking on a group action item
        $(".groupActionItems a").click(function () {
            $(".groupActionsContainer").hide();
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
            }
            //$.uniform.update();
        });

        // Filter Check box handler
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
            }

            var numSearchSelected = $('.searchSelected').length;
            if (numSearchSelected < 1) {
                $('#allClientAccounts').prop('checked', true);

            }
            else {
                $('#allClientAccounts').prop('checked', false);
            }

            //$.uniform.update();
            applyFilter();
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
            //$.uniform.update();
            applyFilter();
        });
        $("#newResetClientFilterButton2").click(function () {
            $(".resetFilterButton").trigger('click')
        });

        // Removing user filter
        $(document).on('click', '#removeUserFilter', function () {
            $(".userFilterCheck").prop('checked', false);
            //$.uniform.update();
            applyFilter();
        });

        // Removing user filter
        $(document).on('click', '#removeBusinessTypeFilter', function () {
            $(".businessTypeFilterCheck").prop('checked', false);
            //$.uniform.update();
            applyFilter();
        });

        // Removing Account Filter
        $(document).on('click', '#removeAccountFilter', function () {
            $(".clientAccountFilterCheck").prop('checked', false);
            $('.searchSelectedRow').remove();
            $('#allClientAccounts').prop('checked', true);
            //$.uniform.update();
            applyFilter();
        });

        // removing compaign filter
        $(document).on('click', '#removeExcludedFilter', function () {
            $(".excludeCheck").prop('checked', false);
            // $.uniform.update();
            applyFilter();
        });

        // Search Accounts
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

        // New filter reset button
        $(".resetFilterButton").click(function () {

            //initUI();

            // Reset All Checkboxes
            $(".filterCheck, .filterColumnCheck").prop('checked', true);
            $(".filterColumn, .filterColumnWide").addClass('filterCollapse');

            $('.searchSelectedRow').remove();
            $('#accountSearch').val('');
            $('#accountSearch').trigger('input');
            $('#saves_filter_list').val('');
            //$.uniform.update();
            applyFilter();

            return false;
        });
        applyFilter();


$(document).on('click', '#clientsTable tbody td a, #clientsTable tbody td span',  function() {
    $('tr.selectedRow').removeClass('selectedRow');
    $(this).parents('tr').addClass('selectedRow');
    var row_num = $(this).closest('tr').find('td:eq(0) input[type="checkbox"]').attr('data-client-id');
    if(hasLocalStorage){
        localStorage.setItem("c_last_active_row", row_num);
    }
    
});

$(document).on('click', '.javascript_loaded',  function(e) {
    $('tr.selectedRow').removeClass('selectedRow');
    if(hasLocalStorage){
        localStorage.setItem("c_last_active_row", '');
    }
});

function check_highlighted_row(){
    if(localStorage.getItem("c_last_active_row")){
        var row_num =localStorage.getItem("c_last_active_row");
        $('#clientsTable tbody').find("[data-client-id='"+row_num+"']").closest('tr').addClass('selectedRow');
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

                resolve(
                    $('#swal-input1').val()
                    
                )
                })
            }else{
                alert('Please Enter the filter Name');
            }
            
        },
        preConfirm: function () {
                if($('#swal-input1').val()){
                    
                    return new Promise(function (resolve) {
                    var name= $('#swal-input1').val();
                   
                    $.ajax({
                        url: '<?php echo site_url('ajax/checkFilterName') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {name:name,type:'Client'},
                        success: function (response) {
                            if(response.success == true)
                            {
                               $('#nameExist').html("Filter Name Alredy Exist!"); 
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
                        url: '/ajax/save_client_filter',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "client_filter": clientFilter,
                            "filterName":result
                        },

                        success: function (data) {
                            if (!data.error) {
                                console.log(result);
                                var $cont = $('#saves_filter_list');
                                //var op = "<option value='" + 3 + "'>check apepnd</option>";
                                var op =  "<option  data-default-filter='0' data-filter='"+data.filter_data+"' value='"+data.filter_id+"'>"+result+"</option>";
                                //if($cont.find('optgroup[id="saved_filters_lable"]').length>0){
                                    $cont.append(op);
                                // }else{
                                //     $('#saves_filter_list').append('<optgroup id="saved_filters_lable" label="Saved Filters">'+op+'</optgroup>')
                                // }
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


   $(document).on("keyup","#swal-input1",function(e) {
    //$('#swal-input1').val()
    if($(this).val()){
        $.ajax({
                        url: '<?php echo site_url('ajax/checkFilterName') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {name:$('#swal-input1').val(),type:'Client'},
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


//Select2 start

$("#select-new-client-reassign").select2({
  ajax: {
    url: '<?php echo site_url('ajax/ajaxSelect2SearchClients') ?>',
    dataType: 'json',
    delay: 250,

    data: function (params) {
      return {
        startsWith: params.term, // search term
        //firstName: $("#firstName").val(),
        lastName: $("#select-new-client-reassign-last-name").val(),
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
$('#select2-select-new-client-reassign-container').find(".select2-selection__placeholder").text('Search existing Contact/Company');

$('#select-new-client-reassign').on("select2:selecting", function(e) {
   // what you would like to happen
   var select_id = e.params.args.data.id;
   var select_label = e.params.args.data.label
   //$("#tiptip_holder").fadeOut('fast');
    $("#new-selected-client-id").val(select_id);
    $("#selected-client").find('strong').html(select_label);

    validate_duplicate_proposal_popup();
    //$(":button:contains('Duplicate')").prop("disabled", false).removeClass("ui-state-disabled");

});

function validate_duplicate_proposal_popup(){
    var client_id = $("#new-selected-client-id").val();
    if(client_id !=''){
        $("#selected-client").show();
        $("#select-client").hide();
        $(":button:contains('Duplicate')").prop("disabled", false).removeClass("ui-state-disabled");
    }
}

//Select2 end

    $("#reset-proposals-reassign-search").click(function () {
        resetDuplicateDialog();
    });

    function resetDuplicateDialog() {
        $("#selected-client").hide().find('strong').html('');
        $("#select-client").show().find('input').val('');
        $(":button:contains('Duplicate')").prop("disabled", true).addClass("ui-state-disabled");
    }

    
});//end ready




</script>


<div class="javascript_loaded">
    <div id="notes" title="Notes" style="display: none;">
        <form action="#" id="{add-note}" style="font-size: 15px;">
            <p>
                <label style="font-weight: bold;">Add Note</label>
                <input type="text" class="text" name="noteText" id="{noteText}" style="width: 500px;margin-bottom:10px;padding: 5px;">
                <input type="hidden" name="relationId" id="relationId" value="0">
                <button type="submit" class="btn blue-button dont-uniform add-notes-popup-btn" style="position:relative;top:2px" value="Add"><i class="fa fa-fw fa-floppy-o"></i>Add</button>

            </p>
            <iframe id="notesFrame" src="" frameborder="0" width="100%" height="300"></iframe>
        </form>
    </div>
    <div id="email_events" title="Email History">
        <table id="email_events_table22" width="100%" cellpadding="0" cellspacing="0">
            
        </table>
    </div>
    <div id="dialog-message" title="Contact Information">
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
    <div id="confirm-delete-message" title="Confirmation">
        <p>Are you sure you want to delete your contact? <br>This will delete all the proposals sent to him.</p>
        <a id="client-delete" href="" rel=""></a>
    </div>
    <div id="permission-denied" title="Confirmation">
        <p>You do not have the permission to do this. Please contact your administrator.</p>
    </div>

    <div id="confirm-reassign" title="Confirmation">
        <p style="padding: 10px 0px;">This will move all of the proposals from the current contact to the new selected contact.</p>
        <p class="clearfix" id="selected-client">
            Selected Contact: <strong id="clientName">Contact</strong> <a href="#" id="reset-proposals-reassign-search">Select other contact</a>
        </p>

        <p class="clearfix input_field_table" >
            <table id="select-client" style="border-spacing: 0 1em;">

                <tr>
                    <td><strong style="padding-right: 5px;">Search Contact</strong></td>
                    <td>
                    <select name="select-new-client-reassign" id="select-new-client-reassign" class="dont-uniform" data-placeholder="Chose number" data-allow-clear="true" ><option value=""></option></select>
                    </td>
                </tr>
            </table>
        </p>

        <input id="new-selected-client-id" type="hidden" name="new-selected-client-id">
        <a id="client-reassign" href="" data-url="" data-reassign="0"></a>
    </div>
</div>

<div id="notes_popup_div" style="display: none;">
        <iframe id="newNotesFrame2" src="" frameborder="0" width="100%" height="300"></iframe>
    
</div>