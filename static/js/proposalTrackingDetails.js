

var showProposalViewsDataTable;
var showEditProposalViewsDataTable;



$(document).ready(function () {

    function formatTime(time) {
        var ret = '';
        if (time !== 0) {
            ret = time % 60 + "s " + ret;
            time = Math.floor(time / 60);
            if (time !== 0) {
                ret = time % 60 + "m " + ret;
                time = Math.floor(time / 60);
                if (time !== 0) {
                    ret = time % 60 + "h ";
                }
            }
        } else {
            ret = '0s';
        }
        return ret;
    }


    
     // Proposal Views Dialog
     $("#proposalViews").dialog({
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


    $(document).on('click', ".reloadProposalViewTable", function() {
            var entityType = $(this).attr('data-type');
        
       
            var entityId = $(this).attr('data-entity-id');
        
        
            var projectName = $(this).attr('data-project-name');

            loadProposalViewTable(projectName,entityType,entityId)
    });


        // Show proposal views Popup
        $(document).on('click', ".showProposalViews", function() {
            var entityType = $(this).attr('data-type');
        
       
            var entityId = $(this).attr('data-entity-id');
        
        
            var projectName = $(this).attr('data-project-name');

            loadProposalViewTable(projectName,entityType,entityId);
            
        });


        function loadProposalViewTable(projectName,entityType,entityId){

            swal({
                title: 'Loading..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                swal.showLoading();
                }
            })
        
        $('.reloadProposalViewTable').attr('data-entity-id',entityId);
        $('.reloadProposalViewTable').attr('data-type',entityType);
        $('.reloadProposalViewTable').attr('data-project-name',projectName);
        var tableUrl = 'ajax/showProposalViews/'+entityType +'/' + entityId;

        if (showProposalViewsDataTable) {
            //activityTable.ajax.url(tableUrl).clear().load();
            showProposalViewsDataTable.destroy();
            $('#showProposalViewsTable').html('<thead><tr><th>Viewer</th><th>Last Viewed</th><th>View Time</th><th>Details</th></tr></thead><tbody></tbody>');
        }
        //else {
            // Activity Datatable
            showProposalViewsDataTable = $("#showProposalViewsTable").DataTable({
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
                    $(".proposal_view_project_name").text(projectName);
                    $("#proposalViews").dialog('open');
                    initButtons();
                    initTiptip();
                }
            });
        //}
        return false;

        }




        $(document).on('click', ".proposalViewDetails", function() {

            
            var linkId = $(this).data('link-id');
            getProposalViewDataByLinkId(linkId);
        

        });

        
        function getProposalViewDataByLinkId(linkId){
            swal({          
                title: 'Loading..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                swal.showLoading();
                }
            })
            
            $.ajax({
                    url: SITE_URL+'ajax/getProposalViewDataByLinkId/'+linkId,
                    type: "POST",
                    data: { 'linkId': linkId },
                    dataType: "json",
                    success: function (data) {
                            
                        var mapIframeUrl = SITE_URL + 'proposals/ipMap';
                        var displayRefreshBtnStyle = '';
                        var displayServiceOpenBtnStyle = 'display:none';
                        

                        if(data.servicePageViewData){
                            var displayServiceOpenBtnStyle = '';
                        }

                        var clickIcon = "<i class='fa fa-fw fa-mouse-pointer'></i>";
                        var clockIcon = "<i class='fa fa-fw fa-clock-o'></i>";
                            var view_data = '<div class="proposalViewPopupContent">';
                           
                            var project_name_temp = (data.proposalData.projectName.length > 50) ? data.proposalData.projectName.substring(0,50)+'...' : data.proposalData.projectName;
                            view_data += '<div class="proposalViewPopupHeader"><span style="font-size:17px;font-weight:bold;">Project Name: '+project_name_temp+'</span><span class="closeProposalViewPopup"><i class="fa fa-times" aria-hidden="true"></i></span><span class="backToPopupContent"><i class="fa fa-chevron-left" aria-hidden="true"></i></span><a href="javascript:void(0)" class="reload_view_swal btn blue-button tiptip" data-type="link" title="Refresh" style="'+displayRefreshBtnStyle+'" data-link-id="'+linkId+'" ><i class="fa fa-fw fa-refresh"></i> </a></div><hr>';
                            view_data += '<div class="proposalViewPopupContentBody">';
                            view_data += '<div class="proposalViewLeftSection">';
                            view_data += '<p  ><span style="float:left;"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;'+data.created_at+'</span><strong style="margin-left:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Total Time: </strong><span>'+formatTime(data.duration)+'</span></p>';
                            view_data += '<p style="padding-bottom: 10px;padding-top: 10px;"><strong>Contact: </strong><span>'+data.viewer+'</span></p>';
                            view_data +='<table class="striped-table view-page-data-table" width="380px" style="font-size:14px;text-align:left;"><tr><th colspan="2">Page Times</th></tr>';
                                            for (const [page, time] of Object.entries(data.pageData)) {
                                                if(page=='Services'){
                                                    var barWidth = Math.floor((time / data.duration) * 100);
                                                    barWidth = (barWidth > 100)? 100 : barWidth;
                                                    view_data += '<tr><td width="110">'+page+'<a href="javascript:void(0)" class="show_service_tr" style="'+displayServiceOpenBtnStyle+'"><i class="fa fa-fw fa-chevron-up"></i></a></td><td><span class="popupPageViewTime">'+formatTime(time)+'</span><span class="pagePopupViewChart" style="width:'+barWidth+'px;"></span></td></tr>';
                                                    
                                                    var servicePageViewData = data.servicePageViewData;
                                                    if(servicePageViewData){
                                                
                                               
                                                        $.each(servicePageViewData, function (index, serviceData) {
                                                            console.log(serviceData);
                                                            
                                                            view_data += '<tr class="service_details_tr" ><td style="max-width: 160px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+serviceData.serviceTitle+'</td><td><span class="popupPageServiceViewTime"> '+serviceData.clicks+' Clicks</span><span class="" >'+formatTime(serviceData.duration)+'</span></td></tr>';


                                                        });
                                                        
                                                    }
                                                 
                                                
                                                }else{
                                                    var barWidth = Math.floor((time / data.duration) * 100);
                                                    barWidth = (barWidth > 100)? 100 : barWidth;
                                                    console.log(page);
                                                     if(page == 'Provider'){
                                                        view_data += '<tr><td width="110">Company Info</td><td><span class="popupPageViewTime">'+formatTime(time)+'</span><span class="pagePopupViewChart" style="width:'+barWidth+'px;"></span></td></tr>';
                                                     }else{
                                                        view_data += '<tr><td width="110">'+page+'</td><td><span class="popupPageViewTime">'+formatTime(time)+'</span><span class="pagePopupViewChart" style="width:'+barWidth+'px;"></span></td></tr>';
                                                    }
                                                }
                                            }
                            view_data += '</table>';
                            

                            view_data += '</div>';
                            view_data += '<div class="proposalViewRightSection">';
                                            

                            if(data.viewData){
                                view_data += '<label><strong>Select View</strong><label>';
                                view_data += '<select class="proposalViewList" id="proposalViewList"><option data-link-id="'+linkId+'" value="0">All View Data ['+data.viewData.length+' Total Views]</option>';
                                $.each(data.viewData, function (index, viewData) {
                                                            
                                    view_data += '<option value="'+viewData.id+'">'+viewData.date+'</option>';

                                });
                                view_data += '</select>';
                            }
                                            //Audit Viewed
                                            if(data.audit.auditHasLink){
                                                view_data += '<div class="audit_viewed_info" ><p><span>Audit Viewed</span>';
                                                if(data.audit.viewed > 0){
                                                    
                                                    view_data += '<span class="tiptip" title="Clicks:'+data.audit.viewed+'</br>Duration:'+formatTime(data.audit.viewTime)+'"><i class="fa fa-fw fa-check-circle"></i></span>';
                                                }else{
                                                    view_data += '<i class="fa fa-fw fa-info-circle" style="padding-left: 0px;"></i>';
                                                }
                                                view_data += '</p></div>';
                                            }
                                            //Image Viewed
                                            view_data += '<div class="image_viewed_info" ><h4>Images Viewed</h4><div class="image_scrollable_box" >';
                                            
                                            var imageDurationData = data.imageDurationData;
                                             
                                                
                                            if(imageDurationData !=''){
                                                
                                               
                                                $.each(imageDurationData, function (index, imageData) {
                                                    view_data += '<div class="image_box"><p class="image_head_title">'+imageData.title+'<span style="float: right;" class="tiptip" title="Clicks:'+imageData.clicks+'</br>Duration:'+formatTime(imageData.duration)+'"><i class="fa fa-info-circle"></i></span></p><a class="viewed_image_details" href="'+imageData.imagepath+'"><img src="'+imageData.imagepath+'" /></a></div>'
                                                });
                                                
                                            }else{
                                                view_data += '<p >No Images Viewed</p>';
                                            }
                                            view_data += '</div></div>';


                                            //Map Viewed
                                            
                                            
                                            var mapDurationData = data.mapDurationData;
                                             
                                                
                                            if(mapDurationData !=''){
                                                view_data += '<div class="image_viewed_info" ><h4>Map Viewed</h4><div class="image_scrollable_box" >';
                                               
                                                $.each(mapDurationData, function (index, imageData) {
                                                    view_data += '<div class="image_box"><p class="image_head_title">'+imageData.title+'<span style="float: right;" class="tiptip" title="Clicks:'+imageData.clicks+'</br>Duration:'+formatTime(imageData.duration)+'"><i class="fa fa-info-circle"></i></span></p><a class="viewed_image_details" href="'+imageData.imagepath+'"><img src="'+imageData.imagepath+'" /></a></div>'
                                                });
                                                view_data += '</div></div>';
                                            }
                                            
                                            
                                            
                                            //Video Played
                                            view_data += '<div class="video_played_info" ><h4>Videos Viewed</h4><div class="video_scrollable_box" >';
                                            if(data.videoDurationData !=''){
                                                
                                               
                                                
                                                $.each(data.videoDurationData, function (index, videoData) {
                                                    view_data += '<div class="video_box"><p class="video_head_title">'+videoData.title+'</p><span style="float: right;margin-top: -20px;" class="tiptip" title="Clicks:'+videoData.clicks+'</br>Duration:'+formatTime(videoData.duration)+'"><i class="fa fa-info-circle"></i></span><div style="position:relative"><a class="viewed_video_details fancybox.iframe"  href="'+videoData.videopath+'"><img src="'+videoData.thumbImageURL+'" /></a><div class="track-play-overlay"><a href="javascript:void(0)" class="track-play-icon"><i class="fa fa-play-circle"></i></a></div></div></div>'
                                                });
                                               
                                                
                                            }else{
                                                view_data += '<p >No Videos Viewed</p>';
                                            }
                                            view_data += '</div></div>';
                                            
                                            //Service Link Viewed
                                            if(data.service_link_viewed != ''){


                                                view_data += '<div class="service_link_viewed_info" ><h4>Links Viewed</h4><div>';
                                                
                                                $.each(data.service_link_viewed, function (index, serviceLinkData) {    
                                                    //if(data.service_link_viewed[$i].duration =='-1');
                                                    view_data += '<p><a class="link_wrap_text" target="_blank" href="'+serviceLinkData.url+'">'+serviceLinkData.url+'</a><span class="tiptip left" title="Clicks:'+serviceLinkData.clicks+'"><i class="fa fa-fw fa-info-circle"></i></span>';
                                                })
                                                view_data += '</div></div>';
                                            }
                                       
                                            //Signed Details
                                            view_data += '<div class="signed_info" ><p><span>Proposal Signature</span></p>';
                                            if(data.signed.signed_at){
                                              
                                                view_data += '<p><label>Name:</label> '+data.signed.full_name+'</p><p><label>Title:</label> '+data.signed.title+'</p><p><label>Date:</label> '+data.signed.signed_at+'</p>';
                                                   
                                            }else{
                                                view_data += '<p>Not Signed Yet</p>';
                                            }
                                            view_data += '</div>';

                                            //User Signed Details
                                            view_data += '<div class="signed_info" ><p><span>User Signature</span></p>';
                                            if(data.user_signed.signed_at){
                                              
                                                view_data += '<p><label>Name:</label> '+data.user_signed.full_name+'</p><p><label>Title:</label> '+data.user_signed.title+'</p><p><label>Date:</label> '+data.user_signed.signed_at+'</p>';
                                                   
                                            }else{
                                                view_data += '<p>Not Signed Yet</p>';
                                            }
                                            view_data += '</div>';

                                            if(data.printed){
                                                
                                                view_data += '<div class="printed_info" ><p><span>Printed</span>';
                                                view_data += '<span class="tiptip" style="border:none" title="Last Printed at '+data.printed.printed_at+'"><i class="fa fa-fw fa-check-circle"></i></span></p>';
                                                view_data += '</div>';
                                        }

                                        

                            view_data += '</div></div></div>';
                            view_data += '<div class="proposalViewPopupMap"><div style="text-align: center;" id="loadingFrameView"><br /><br /><br /><br /><p><img src="/static/blue-loader.svg" /></p></div><iframe id="proposalViewMapIframe"   style="width:780px;height:calc(100vh - 100px)" ></iframe><div>';
                            
                            swal({
                                title: "",
                                allowOutsideClick: false,
                                showCancelButton: false,
                                showConfirmButton: false,
                                dangerMode: false,
                                reverseButtons:false,
                            
                                customClass: 'proposal-view-swal-width',
                                html: view_data,
                                onOpen:  function() {

                                    $('.swal2-select').addClass('dont-uniform');
                                    
                                }
                            });
                            initTiptip();
                            $('#proposalViewList').uniform();
                            initButtons();
                            $("a.viewed_image_details").fancybox({
                                openEffect: 'none',
                                closeEffect: 'none',
                                nextEffect: 'fade',
                                prevEffect: 'fade',
                            });

                            $("a.viewed_video_details").fancybox({
                                openEffect: 'none',
                                closeEffect: 'none',
                                nextEffect: 'fade',
                                prevEffect: 'fade',
                            });
                            
                    }
                });

        };

        $(document).on('change', ".proposalViewList", function() {
            
            if($(this).val() == 0){
                var linkId = $(this).find(':selected').attr('data-link-id');
                //$('.proposalViewDetails[data-link-id="'+linkId+'"]').trigger('click');
                getProposalViewDataByLinkId(linkId);
            }else{
                getProposalViewDataById($(this).val());            
            }
        });

    function getProposalViewDataById(viewId){
            
            swal({          
                title: 'Loading..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                swal.showLoading();
                }
            })

            $.ajax({
                    url: SITE_URL+'ajax/getProposalViewDataById/'+viewId,
                    type: "POST",
                    data: { 'viewId': viewId },
                    dataType: "json",
                    success: function (data) {
                            
                        var mapIframeUrl = SITE_URL + 'proposals/ipMap';
                        var displayRefreshBtnStyle = '';
                        var displayServiceOpenBtnStyle = 'display:none';
                        if(data.statusText=='Complete'){
                            var displayRefreshBtnStyle = 'display:none';
                        }

                        if(data.servicePageViewData.length>0){
                            var displayServiceOpenBtnStyle = '';
                        }

                        var clickIcon = "<i class='fa fa-fw fa-mouse-pointer'></i>";
                        var clockIcon = "<i class='fa fa-fw fa-clock-o'></i>";
                            var view_data = '<div class="proposalViewPopupContent">';
                            // var seconds = data.duration;
                            // var formatted = moment.utc(seconds*1000).format('HH:mm:ss');
                            var project_name_temp = (data.proposalData.projectName.length > 50) ? data.proposalData.projectName.substring(0,50)+'...' : data.proposalData.projectName;
                            view_data += '<div class="proposalViewPopupHeader"><span style="font-size:17px;font-weight:bold;">Project Name: '+project_name_temp+'</span><span class="closeProposalViewPopup"><i class="fa fa-times" aria-hidden="true"></i></span><span class="backToPopupContent"><i class="fa fa-chevron-left" aria-hidden="true"></i></span><a href="javascript:void(0)" class="reload_view_swal btn blue-button tiptip" data-type="view" title="Refresh" style="'+displayRefreshBtnStyle+'" data-view-id="'+viewId+'" ><i class="fa fa-fw fa-refresh"></i> </a><span class="swal_view_status_badge tiptip" title="Status">'+data.statusBadge+'</span></div><hr>';
                            view_data += '<div class="proposalViewPopupContentBody">';
                            view_data += '<div class="proposalViewLeftSection">';
                            view_data += '<p ><span style="float:left;"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;'+data.created_at+'</span><strong style="margin-left:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Total Time: </strong><span>'+data.formattedDuration+'</span></p>';
                            view_data += '<p style="padding-bottom: 10px;padding-top: 10px;"><strong>Contact: </strong><span>'+data.viewer+'</span></p>';
                            view_data +='<table class="striped-table view-page-data-table" width="380px" style="text-align:left;"><tr><th colspan="2">Page Times</th></tr>';
                                            for (const [page, time] of Object.entries(data.pageData)) {
                                                if(page=='Services'){
                                                    var barWidth = Math.floor((time / data.duration) * 100);
                                                    barWidth = (barWidth > 100)? 100 : barWidth;
                                                    view_data += '<tr><td width="110">'+page+'<a href="javascript:void(0)" class="show_service_tr" style="'+displayServiceOpenBtnStyle+'"><i class="fa fa-fw fa-chevron-up"></i></a></td><td><span class="popupPageViewTime">'+formatTime(time)+'</span><span class="pagePopupViewChart" style="width:'+barWidth+'px;"></span></td></tr>';
                                                    
                                                    if (data.servicePageViewData.length) {
                                                       
                                                       
                                                                        for (const [idx, service] of Object.entries(data.servicePageViewData)) {
                                                                            var barWidth = Math.floor((service.duration / data.duration) * 100);
                                                                            barWidth = (barWidth > 100)? 100 : barWidth;
                                                                            view_data += '<tr class="service_details_tr" ><td style="max-width: 160px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+service.serviceTitle+'</td><td><span class="popupPageServiceViewTime"> '+service.clicks+' Clicks</span><span class="" >'+formatTime(service.duration)+'</span></span></td></tr>';
                                                                        }
                                                        
                                                    }
                                                
                                                }else{
                                                    var barWidth = Math.floor((time / data.duration) * 100);
                                                    barWidth = (barWidth > 100)? 100 : barWidth;
                                                    console.log(page)
                                                     if(page == 'Provider'){
                                                         view_data += '<tr><td width="110">Company Info</td><td><span class="popupPageViewTime">'+formatTime(time)+'</span><span class="pagePopupViewChart" style="width:'+barWidth+'px;"></span></td></tr>';
                                                     }else{
                                                        view_data += '<tr><td width="110">'+page+'</td><td><span class="popupPageViewTime">'+formatTime(time)+'</span><span class="pagePopupViewChart" style="width:'+barWidth+'px;"></span></td></tr>';
                                                     }
                                                    
                                                }
                                            }
                            view_data += '</table>';
                            
                            if(data.userAgent){
                                var os_version = (data.userAgent.os_version) ? ' '+data.userAgent.os_version : '';
                                view_data += '<div class="device_info" style="padding-top: 20px;line-height: 1.5;"><span><i class="fa fa-fw fa-'+data.userAgent.os.toLowerCase()+'"></i> '+data.userAgent.os+os_version+'&nbsp;&nbsp;&nbsp;&nbsp;</span><br/><span><i class="fa fa-fw fa-'+data.userAgent.device.toLowerCase()+'"></i> '+data.userAgent.device+'&nbsp;&nbsp;&nbsp;&nbsp;</span><br/><span><i class="fa fa-fw fa-'+data.userAgent.browser.toLowerCase()+'"></i> '+data.userAgent.browser+'&nbsp;&nbsp;&nbsp;&nbsp;</span><br/><span><a href="javascript:void(0)" class="showViewerMap" data-url="'+mapIframeUrl+'/'+data.ipAddress+'" style="color:#545454"><i class="fa fa-fw fa-map-marker"></i> Location</a></span></div>';

                            }
                            view_data += '</div>';

                            

                            view_data += '<div class="proposalViewRightSection">';

                            if(data.viewData){
                                view_data += '<label><strong>Select View</strong><label>';
                                view_data += '<select class="proposalViewList" id="proposalViewList"><option data-link-id="'+data.linkId+'" value="0">All View Data ['+data.viewData.length+' Total Views]</option>';
                                $.each(data.viewData, function (index, viewData) {
                                    var selected = '';
                                    if(viewId == viewData.id){
                                        selected = 'selected="seleted"';
                                    }                        
                                    view_data += '<option value="'+viewData.id+'" '+selected+'>'+viewData.date+'</option>';


                                });
                                view_data += '</select>';
                            }
                                            
                                            //Audit Viewed
                                            if(data.audit.auditHasLink){
                                                view_data += '<div class="audit_viewed_info" ><p><span>Audit Viewed</span>';
                                                if(data.audit.viewed > 0){
                                                    
                                                    view_data += '<span class="tiptip" title="Clicks:'+data.audit.viewed+'</br>Duration:'+formatTime(data.audit.viewTime)+'"><i class="fa fa-fw fa-check-circle"></i></span>';
                                                }else{
                                                    view_data += '<i class="fa fa-fw fa-info-circle" style="padding-left: 0px;"></i>';
                                                }
                                                view_data += '</p></div>';
                                            }
                                            //Image Viewed
                                            view_data += '<div class="image_viewed_info" ><h4>Images Viewed</h4><div class="image_scrollable_box" >';
                                            if(data.imageDurationData.length){

                                               
                                                for($i=0;$i<data.imageDurationData.length;$i++){
                                                
                                                    view_data += '<div class="image_box"><p class="image_head_title">'+data.imageDurationData[$i].title+'<span style="float: right;" class="tiptip" title="Clicks:'+data.imageDurationData[$i].clicks+'</br>Duration:'+formatTime(data.imageDurationData[$i].duration)+'"><i class="fa fa-info-circle"></i></span></p><a class="viewed_image_details" href="'+data.imageDurationData[$i].imagepath+'"><img src="'+data.imageDurationData[$i].imagepath+'" /></a></div>'
                                                }
                                                
                                            }else{
                                                view_data += '<p >No Images Viewed</p>';
                                            }
                                            view_data += '</div></div>';
                                            
                                            
                                            //Map Viewed
                                            
                                            
                                            var mapDurationData = data.mapDurationData;
                                             
                                                
                                            if(mapDurationData !=''){
                                                view_data += '<div class="image_viewed_info" ><h4>Map Viewed</h4><div class="image_scrollable_box" >';
                                               
                                                $.each(mapDurationData, function (index, imageData) {
                                                    view_data += '<div class="image_box"><p class="image_head_title">'+imageData.title+'<span style="float: right;" class="tiptip" title="Clicks:'+imageData.clicks+'</br>Duration:'+formatTime(imageData.duration)+'"><i class="fa fa-info-circle"></i></span></p><a class="viewed_image_details" href="'+imageData.imagepath+'"><img src="'+imageData.imagepath+'" /></a></div>'
                                                });
                                                view_data += '</div></div>';
                                            }
                                            
                                            //Video Played
                                            view_data += '<div class="video_played_info" ><h4>Videos Viewed</h4><div class="video_scrollable_box" >';
                                            if(data.videoDurationData.length){
                                                
                                                for($i=0;$i<data.videoDurationData.length;$i++){
                                                    
                                                    view_data += '<div class="video_box"><p class="video_head_title">'+data.videoDurationData[$i].title+'</p><span style="float: right;margin-top: -20px;" class="tiptip" title="Clicks:'+data.videoDurationData[$i].clicks+'</br>Duration:'+formatTime(data.videoDurationData[$i].duration)+'"><i class="fa fa-info-circle"></i></span><div style="position:relative"><a class="viewed_video_details fancybox.iframe"  href="'+data.videoDurationData[$i].videopath+'"><img src="'+data.videoDurationData[$i].thumbImageURL+'" /></a><div class="track-play-overlay"><a href="javascript:void(0)" class="track-play-icon"><i class="fa fa-play-circle"></i></a></div></div></div>'


                                                }
                                                
                                               
                                                
                                            }else{
                                                view_data += '<p >No Videos Viewed</p>';
                                            }
                                            view_data += '</div></div>';
                                            
                                            //Service Link Viewed
                                            if(data.service_link_viewed){

                                                view_data += '<div class="service_link_viewed_info" ><h4>Links Viewed</h4><div>';
                                                for($i=0;$i<data.service_link_viewed.length;$i++){
                                                    //if(data.service_link_viewed[$i].duration =='-1');
                                                    view_data += '<p><a class="link_wrap_text" target="_blank" href="'+data.service_link_viewed[$i].url+'">'+data.service_link_viewed[$i].url+'</a><span class="tiptip left" title="Clicks:'+data.service_link_viewed[$i].clicks+'"><i class="fa fa-fw fa-info-circle"></i></span>';
                                                }
                                                view_data += '</div></div>';
                                            }
                                       
                                            //Signed Details
                                           
                                            if(data.signed.signed_at){
                                                view_data += '<div class="signed_info" ><p><span>Proposal Signature</span></p>';
                                                view_data += '<p><label>Name:</label> '+data.signed.full_name+'</p><p><label>Title:</label> '+data.signed.title+'</p><p><label>Date:</label> '+data.signed.signed_at+'</p>';
                                                view_data += '</div>';
                                                   
                                            }
                                            
                                            if(data.printed){
                                                console.log(data.printed.printed_at)
                                                view_data += '<div class="printed_info" ><p><span>Printed</span>';
                                                view_data += '<span class="tiptip" style="border:none" title="Last Printed at '+data.printed.printed_at+'"><i class="fa fa-fw fa-check-circle"></i></span></p>';
                                                view_data += '</div>';
                                        }

                                        

                            view_data += '</div></div></div>';
                            view_data += '<div class="proposalViewPopupMap"><div style="text-align: center;" id="loadingFrameView"><br /><br /><br /><br /><p><img src="/static/blue-loader.svg" /></p></div><iframe id="proposalViewMapIframe"   style="width:780px;height:calc(100vh - 100px)" ></iframe><div>';
                            
                            swal({
                                title: "",
                                allowOutsideClick: false,
                                showCancelButton: false,
                                showConfirmButton: false,
                                dangerMode: false,
                                reverseButtons:false,
                            
                                customClass: 'proposal-view-swal-width',
                                html: view_data,
                                onOpen:  function() {

                                    $('.swal2-select').addClass('dont-uniform');
                                    
                                }
                            });
                            initTiptip();
                            $('#proposalViewList').uniform();
                            initButtons();
                            $("a.viewed_image_details").fancybox({
                                openEffect: 'none',
                                closeEffect: 'none',
                                nextEffect: 'fade',
                                prevEffect: 'fade',
                            });

                            $("a.viewed_video_details").fancybox({
                                openEffect: 'none',
                                closeEffect: 'none',
                                nextEffect: 'fade',
                                prevEffect: 'fade',
                            });
                            
                    }
                });


        };


        $(document).on('click', ".reload_view_swal", function() {
           
            if( $(this).attr('data-type') == "link"){
                var linkId = $(this).attr('data-link-id');
                $('.proposalViewDetails[data-link-id="'+linkId+'"]').trigger('click');

            }else{
                var viewId = $(this).attr('data-view-id');
                getProposalViewDataById(viewId);            
            }
        });

        $(document).on('click', ".log_proposal_view", function() {
           
                var viewId = $(this).attr('data-proposal-preview-id');
                //if(viewId){
                    getProposalViewDataById(viewId);
                //}
        });

        $(document).on('click', ".show_service_tr", function() {
            $('.service_details_tr').show();
            $(this).removeClass('show_service_tr');
            $(this).addClass('hide_service_tr');
            $(this).find('i').removeClass('fa-chevron-down');
           $(this).find('i').addClass('fa-chevron-up');
        });

        $(document).on('click', ".hide_service_tr", function() {
            $('.service_details_tr').hide();
            $(this).addClass('show_service_tr');
            $(this).removeClass('hide_service_tr');
            $(this).find('i').addClass('fa-chevron-down');
           $(this).find('i').removeClass('fa-chevron-up');
        });
        


        $(document).on('click', ".closeProposalViewPopup", function() {
            swal.close();
        })
        $(document).on('click', ".showViewerMap", function() {
            $('.proposalViewPopupMap').show();
            $('.proposalViewPopupContentBody').hide();
            $('.closeProposalViewPopup').hide();
            $('.backToPopupContent').show();
            


            var currSrc =$(this).attr('data-url');
            

            $("#proposalViewMapIframe").hide();
            // Show the loader
            $("#loadingFrameView").show();
            // Refresh the iframe - Load event will handle showing the frame and hiding the loader

            $("#proposalViewMapIframe").attr("src", currSrc);


            var ifr = document.getElementById('proposalViewMapIframe');
                ifr.onload=function(){
                    this.style.display='block';
                    $("#loadingFrameView").hide();
                    console.log('laod the iframe')
                };
            return false;
        })




        $(document).on('click', ".backToPopupContent", function() {
            $('.proposalViewPopupMap').hide();
            $('.proposalViewPopupContentBody').show();
            $('.closeProposalViewPopup').show();
            $('.backToPopupContent').hide();
            
        })


});
