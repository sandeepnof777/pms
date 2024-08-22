<div id="proposalsMap"></div>

<script type="text/javascript" src="/static/js/markerclusterer.js"></script>
<script type="text/javascript" src="/static/js/MapLibrary.js"></script>
<script type="text/javascript" src="/static/js/DrawingManager.js"></script>
<script type="text/javascript">

    var mapObj = null;
    var pMap = null;
    var accountId = <?php echo $account->getAccountId(); ?>;
    var markers = {};
    var bounds;
    var watchId;
    var selectedMarkerId;
    var activityMarkerId;
    var strCoords = [];
    var markerClusterer;
    var all_proposal_ids = [];
    var AllMarkerData = [];
    var filteredProposalIds = [];
    var activityTable = null;
    var mapIcon = {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 6,
        strokeColor: '#ffffff',
        strokeWeight: 1,
        fillColor: '#1b34ff',
        fillOpacity: 1
    };
    var satelliteIcon = {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 6,
        strokeColor: '#ffffff',
        strokeWeight: 1,
        fillColor: '#ff7a14',
        fillOpacity: 1
    };

    // Default Marker Icon
    var defaultIcon = mapIcon;
    // Hover Icon
    var mapHoverIcon = {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 6,
        strokeColor: '#ffffff',
        strokeWeight: 2,
        fillColor: '#1b34ff',
        fillOpacity: 1
    };

    var satelliteHoverIcon = {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 6,
        strokeColor: '#ffffff',
        strokeWeight: 2,
        fillColor: '#ff7a14',
        fillOpacity: 1
    };

    var hoverIcon = mapHoverIcon;


    // Highlighted Marker Icon
    var highlightIcon = {
        path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
        scale: 6,
        strokeColor: '#fff',
        strokeWeight: 2,
        fillColor: '#000',
        fillOpacity: 1
    };
    // Current position icon
    var positionIcon = {
        path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
        fillColor: '#49b23b',
        fillOpacity: 1,
        scale: 6,
        strokeColor: 'white',
        strokeWeight: 1,
        optimized: false
    };
    // Position Marker
    var positionMarker = new google.maps.Marker({
        icon: positionIcon,
        optimized: false,
        zIndex: 999
    });
    var currentPositionObj;
    var centerOnPosition = true;
    var controlUI, controlUI2;
    var init = true;
//    var allBounds = new google.maps.LatLngBounds();
    var updateCount = 0;
    var lastPositions = [];
    var lastZooms = [];
    var all_overlays = [];
    var myToolbox = null;
    var shape = null;
    $(document).ready(function() {

        // Show Table
        $("#proposalMapLink").click(function() {
            // Uncheck all selects
            $(".groupSelect").attr('checked', false);
            //$("#proposalTableLink").show();
            // HIde the buttopns in the bar
            $(this).hide();
            $(".groupAction").hide();
            $("#exportFilteredProposals").hide();
            $("#addProposalLink").hide();
            $(".mapControl").show();
            $("#postcode_search").show();
            showMap();
        });

        // Show Map
        $("#proposalTableLink").click(function() {
            $("#mapInfoCheck").attr('checked', false);
            $("#proposalMapLink").show();
            $(this).hide();
            showTable();
        });

        // Hide info slider
        $("#mapInfoSliderClose").click(function() {
            hideInfoSlider();
        });

        // Send the highlighted proposal
        $("#mapSendProposal").click(function() {
            // Check the hidden checkbox so this is the only one selected
            $('#mapInfoCheck').data('proposal-id', selectedMarkerId);
            $("#mapInfoCheck").attr('checked', true);
            // Trigger the click on the group resend to open the dialog
            $("#groupResend").trigger('click');
        });

        // Send the highlighted proposal
        $("#mapPreviewProposal").click(function() {
            var proposalId = $(this).data('proposal-id');
            var previewUrl = '/proposals/edit/' + proposalId + '/preview';
            window.open(previewUrl, '_blank');
        });

        $("#closeDrawingTools").click(function() {
           $("#maptoolsdropdown").hide();
        });

        $('#mapBack').click(function() {
            //pMap.setCenter(lastPositions[0]);
            pMap.setZoom(pMap.getZoom() - 1);
            $("#mapInfoSliderClose").trigger('click');
            selectedMarkerId = null;
            // Clear any shapes
            RemoveCircle();
            RemovePloygon();
            // Clear Search
            $("#postcode_search").val('');
            $("#zipSearchButton").show();
            $("#zipCancel").hide();
            updateMap();
            return false;
        });

        $("#closeDrawingTools").click(function() {
           $("#mapToolsDropdown").hide();
        });

        $("#mapAll").click(function() {
            RemoveCircle();
            RemovePloygon();
            setTimeout(function() {
                fitFilterBounds();
            }, 500);

            return false;
        });

        $("#mapPosition").click(function() {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition)
            } else {
                swal('We are unable to access your location');
            }
            return false;
        });

        $('#postcode_search').on('search', function(){
            if(!this.value){
                all_proposal_ids = [];
                if (markerClusterer) {
                    markerClusterer.clearMarkers();
                }
                setTimeout(function(){
                    updateMap(false);
                },100);

            }
        });

        // Zip Search Button
        $("#zipSearchButton").click(function(e) {
            var zipVal = $("#postcode_search").val();
            if (/^\d{5}(-\d{4})?$/.test(zipVal)) {
                searchPostcode(e);
            } else {
                swal('Please enter a valid zip code');
            }
        });

        $("#zipCancel").click(function() {
            $("#postcode_search").val('');
            $(this).hide();
            $("#zipSearchButton").show();
            updateMap();
        });

        // Map Tools
        $("#mapTools").click(function() {
            $("#mapToolsDropdown").toggle();
        });


        initTiptip();
    });

    function showMap() {

        swal({
            html: '<p>Loading your proposals</p><p><img src="/static/loading.gif" />'
        });

        // Init the map if there isn't one
        if (!pMap) {
            initMap(true);
        }

        // Toggle the UI buttons
        $("#proposalsTableContainer").hide();
        $("#proposalsMapContainer").show();
        google.maps.event.trigger(pMap, 'resize');
    }

    function showTable() {
        $("#proposalsMapContainer").hide();
        $("#proposalsTableContainer").show();
    }

    function hideInfoSlider() {
        $("#mapInfoSlider").removeClass('slideLeft');
        if (selectedMarkerId) {
            markers[selectedMarkerId].setIcon(defaultIcon);
        }
        wideMap();
    }

    function initMap() {
        getAllMarkerData();
    }

    function hideDrawingTools() {
        $("#mapToolsDropdown").hide();
    }

    function initActualMap() {
        if (!pMap) {
            mapObj = new GetMap('proposalsMap', {
                center: {
                    lat: 41.850033,
                    lng:  -87.6500523
                }, // center to set the map
                zoom: 3,
                initMap: true, // initialize the map by default
                callback: function() { // function to run once on map idle event or map after map finish loading
                    setTimeout(function(){
                        updateMap(true);
                    }, 1000);
                },
                mapTypeId: 'roadmap',
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    mapTypeIds: ['roadmap', 'satellite'],
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER
                },
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER
                },
                fullscreenControl: false,
                gestureHandling: 'greedy'
            });
            pMap = mapObj.getMap();

            bounds = new google.maps.LatLngBounds();

            myToolbox = new DrawingManagerModule(pMap);
            myToolbox.show();

            // Map Listeners
            pMap.addListener('bounds_changed', function () {
                if(pMap.getZoom() < 14) {
                    lastPositions.unshift(pMap.getCenter());
                    lastZooms.unshift(pMap.getZoom());
                    // Reduce the arrays for memory performance
                    lastPositions.length = 2;
                    lastZooms.length = 2;
                }
            });

            pMap.addListener('maptypeid_changed', function() {

                var mapType = pMap.getMapTypeId();

                defaultIcon = mapIcon;
                hoverIcon = mapIcon;

                if (mapType == 'satellite') {
                    defaultIcon = satelliteIcon;
                    hoverIcon = satelliteHoverIcon;
                }

                for (i in markers) {
                    markers[i].setIcon(defaultIcon);
                }
            });

            // Cluster and configure options
            markerClusterer = new MarkerClusterer(pMap, [], {
                gridSize: 50,
                maxZoom: 18
            });
           /* pMap.addListener('idle', function () {
                updateMap(true);
            });*/

        } else {
            if (centerOnPosition) {
                watchPosition();
                centerOnPosition = false;
            }
        }
    }

    function clearMap() {
        for (var markerId in markers) {
            markers[markerId].setMap(null);
        }
    }

    function handleLocationError(browserHasGeolocation) {
        /*
        swal(
            'Error',
            'Could not identify your location'
        );*/
    }

    function updateMap(fitBounds) {
        createProposalMarkers(AllMarkerData, fitBounds);
    }

    function fitFilterBounds() {
        /*var filterBounds = new google.maps.LatLngBounds();
        $.each(filteredProposalIds, function(idx, array) {
           var position = new google.maps.LatLng(AllMarkerData[array].lat, AllMarkerData[array].lng);
           filterBounds.extend(position);
        });
        pMap.fitBounds(filterBounds);*/
        all_proposal_ids = [];
        if (markerClusterer) {
            markerClusterer.clearMarkers();
        }
        updateMap(true);
    }

    function getAllMarkerData() {
        var availableTags = [];
        $.ajax({
            type: 'POST',
            url: '/ajax/allProposalMapData/' + accountId,
            dataType: "json",
            success: function(data) {
                AllMarkerData = data;

                $.each(data, function(idx, array) {
                    if($.inArray(array.projectZip,availableTags) == -1){
                        availableTags.push(array.projectZip);
                    }
                });

                /*$( "#postcode_search" ).autocomplete({
                    source: availableTags,
                    select: function( event, ui ) {
                        $('#postcode_search').val(ui.item.value);
                        all_proposal_ids = [];
                        if (markerClusterer) {
                            markerClusterer.clearMarkers();
                        }
                        updateMap(true);
                    }
                });
                $('.ui-autocomplete').css({
                    'max-height': '100px',
                    'overflow-y': 'auto',
                    'overflow-x': 'hidden'
                });*/
                getFilteredProposalIds();
                initActualMap();
            }
        });
    }

    function getFilteredProposalIds() {

        $.ajax({
            type: 'POST',
            url: '/ajax/getFilteredProposalIds/' + accountId,
            dataType: "json",
            success: function(data) {

                filteredProposalIds = data;
                all_proposal_ids = [];
                if (markerClusterer) {
                    markerClusterer.clearMarkers();
                }
                if(pMap){
                    updateMap(true);
                }
            }
        });
    }
    function  searchPostcode(e){

        var inputLength = $("#postcode_search").val().length;
        if (inputLength > 0) {
            $("#zipSearchButton").show();
        } else {
            $("#zipSearchButton").hide();
        }

        var key = e.keyCode || e.which;
        if (key == 13 || key == 1){
            all_proposal_ids = [];
            if (markerClusterer) {
                markerClusterer.clearMarkers();
            }
            updateMap(true);
            $("#zipSearchButton").hide();
            $("#zipCancel").show();
        }
    }
    function createProposalMarkers(data, fitBounds) {
        strCoords =[];
        var numMarkers = Object.keys(data).length;

        var i = 0;
        var temp = [];

        var b = pMap.getBounds();

        $.each(data, function(idx, array) {

            var lat = parseFloat(array.lat);
            var lng = parseFloat(array.lng);

            var latlng = new google.maps.LatLng({lat: lat, lng: lng});
            //&& b.contains(latlng) == true

            if($.inArray(array.proposalId, all_proposal_ids) == -1 && $.inArray(array.proposalId.toString(), filteredProposalIds) > -1 && ((shape && google.maps.geometry.poly.containsLocation(latlng, shape)) || shape == null ) && ((array.projectZip == $('#postcode_search').val()) || $('#postcode_search').val() == '')){
                all_proposal_ids.push(array.proposalId);
                // Set the lat and lng with an offset check

                // Offset Check
                var latLngStr = lat + '_' + lng;

                if ($.inArray(latLngStr, strCoords) != -1) {
                    var str = offsetLatLng(lat, lng);
                    var a = str.split('_');
                    lat = a[0];
                    lng = a[1];
                }
                latLngStr = lat + '_' + lng;
                strCoords.push(latLngStr);

                // Set the position and show on the map
                array.position = new google.maps.LatLng(lat, lng);


                bounds.extend(array.position);

                // Set the icon
                array.icon = defaultIcon;
                array.proposalId = idx;
                var marker = new google.maps.Marker(array);
                marker.setMap(pMap);
                markers[idx] = marker;
                temp.push(marker);
                // Info window for hover
                var infoWindow = new google.maps.InfoWindow({
                    content: array.projectName
                });

                // Event listeners //

                // Click
                google.maps.event.addListener(marker, 'click', function() {
                    loadInfoSlider(marker);
                });

                // Hover
                google.maps.event.addListener(marker, 'mouseover', function() {
                    infoWindow.open(pMap, marker);
                    marker.setIcon(hoverIcon);
                });

                google.maps.event.addListener(marker, 'mouseout', function() {
                    infoWindow.close(pMap, marker);
                    if (marker.proposalId !== selectedMarkerId) {
                        marker.setIcon(defaultIcon);
                    }
                });
            }
            i++;
        });

        if(temp.length > 0) {
            markerClusterer.addMarkers(temp);

            setTimeout(function() {
              if(fitBounds)
                pMap.fitBounds(bounds);
                if (sweetAlert.isVisible()) {
                    sweetAlert.close()
                }
                if(bounds.isEmpty() == false){
                    bounds = null;
                    bounds = new google.maps.LatLngBounds();
                }
            }, 100);
        }
    }

    function loadInfoSlider(marker) {
        // Loading notice
        $("#infoLoading").show();
        $("#proposalData").hide();

        // Hide the send button
        $("#mapSendProposal").hide();
        // Hide the contact info
        $("#proposalMapContactInfo").hide();

        // Show the slider
        $("#mapInfoSlider").addClass('slideLeft');
        narrowMap();

        // Reset the previously selected marker to default icon
        if (selectedMarkerId) {
            markers[selectedMarkerId].setIcon(defaultIcon);
        }

        // Remember the last marker for changing color back after
        selectedMarkerId = marker.proposalId;
        // Highlight this icon
        markers[marker.proposalId].setIcon(hoverIcon);

        // Center the map on the clicked marker
        pMap.panTo(marker.position);
        pMap.setZoom(18);

        $.ajax({
            type: 'GET',
            url: '/ajax/proposalInfo/' + marker.proposalId,
            dataType: "json",
            success: function(data) {

                // Clear the services tables
                $("#proposalServicesTable tr").remove();
                // Hide the optional table. only show if needed
                $("#proposalOptionalServicesTable tr").remove();
                $("#proposalOptionalServices").hide();

                // Show/hide send button based on permission
                $("#mapSendProposal").toggle(data.proposal.permission);
                // Show/hide send button based on permission
                $("#proposalMapContactInfo").toggle(data.proposal.permission);
                // Show/hide preview button based on permission
                $("#mapPreviewProposal").toggle(data.proposal.permission);
                // Update the value of the preview
                $("#mapPreviewProposal").data('proposal-id', data.proposal.id);
                // Update Last activity Link
                $("#mapLastActivityLink").data('proposal-id', data.proposal.id);

                // Project Name
                var projectName = data.proposal.projectName || '';
                $("#projectName").text(projectName);
                // Update the activity title too
                $("#mapLastActivityLink").data('project-name', projectName);
                // Project Address
                var address = data.proposal.projectAddress + '<br />' +
                    ((data.proposal.projectCity) ? data.proposal.projectCity : '') + ' ' +
                    ((data.proposal.projectState) ? data.proposal.projectState : '') + ' ' +
                    ((data.proposal.projectZip) ? data.proposal.projectZip : '') + ' ';
                $("#projectAddress").html(address);
                // Account
                var accountName = data.clientAccount.name || '';
                $("#accountName").text(accountName);
                // Contact - Name
                var contactName = data.contact.fullName || '';
                $("#contactName").text(contactName);
                // Contact - Title
                var contactTitle = data.contact.title || '';
                $("#contactTitle").text(contactTitle);
                // Contact - Phone
                var contactOfficePhone = data.contact.phone || '';
                $("#contactOfficePhone").text(contactOfficePhone);
                $("#contactOfficePhone").attr('href', 'tel:' + contactOfficePhone);
                // Contact - Cell Phone
                var contactCellPhone = data.contact.cellPhone || '';
                $("#contactCellPhone").text(contactCellPhone);
                $("#contactCellPhone").attr('href', 'tel:' + contactCellPhone);
                // Contact - Email
                var contactEmail = data.contact.email || '';
                $("#contactEmail").text(contactEmail);
                $("#contactEmail").attr('href', 'mailto:' + contactEmail);
                // Owner - Name
                var ownerName = data.proposal.ownerName || '';
                $("#proposalOwner").text(ownerName);
                // Proposal Date
                var proposalDate = data.proposal.proposalDate || '';
                $("#proposalDate").text(proposalDate);
                // Last Activity
                var lastActivity = data.proposal.lastActivity || '';
                $("#proposalLastActivity").text(lastActivity);
                // Status
                var status = data.proposal.statusName || '';
                $("#proposalStatus").text(status);
                // Price
                var price = addCommas(data.proposal.price);
                $("#proposalPrice").text(price);
                // Services
                for (var i = 0; i < data.proposal.services.length; i++) {
                    $("#proposalServicesTable").append('' +
                        '<tr>' +
                        '<td>' + data.proposal.services[i].title + '</td>' +
                        '<td style="text-align: right;">$' + addCommas(data.proposal.services[i].price) + '</td>' +
                        '</tr>'
                    );
                }
                // Optional Services
                if (data.proposal.optionalServices.length > 0) {
                    for (var i = 0; i < data.proposal.optionalServices.length; i++) {
                        $("#proposalOptionalServicesTable").append('' +
                            '<tr>' +
                            '<td>' + data.proposal.optionalServices[i].title + '</td>' +
                            '<td style="text-align: right;">$' + addCommas(data.proposal.optionalServices[i].price) + '</td>' +
                            '</tr>'
                        );
                    }
                    $("#proposalOptionalServices").show();
                }

                //Notes
                // Clear the table
                $("#mapInfoNotes tr").remove();

                if (data.proposal.notes.length < 1) {
                    $("#mapInfoNotes").append('<tr><td colspan="2">No Notes</td></tr>');
                } else {
                    for (var i = 0; i < data.proposal.notes.length; i++) {
                        $("#mapInfoNotes").append('' +
                            '<tr>' +
                            '<td>' + data.proposal.notes[i].date + '</td>' +
                            '<td>' + data.proposal.notes[i].text + '</td>' +
                            '</tr>');
                    }
                }

                // Hide the loader and show the data
                $("#infoLoading").hide();
                $("#proposalData").show();
            }
        });
    }


    function narrowMap() {
        $("#proposalsMap").addClass('slideRight');
        refreshMap();
    }

    function wideMap() {
        $("#proposalsMap").removeClass('slideRight');
        refreshMap();
    }

    function refreshMap() {
        if (pMap) {
            var center = pMap.getCenter();
            google.maps.event.trigger(pMap, 'resize');
            pMap.setCenter(center);
        }
    }



    function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        currentPositionObj = new google.maps.LatLng(lat, lng);

        positionMarker.setPosition(currentPositionObj);
        positionMarker.setMap(pMap);

        pMap.panTo(currentPositionObj);
        pMap.setZoom(17);
    }

    function showError(error) {
        currentPositionObj = null;
        swal(
            'Error',
            'Cannot find your location: [reason: ' + error.message + ']'
        );
    }

    function offsetLatLng(lat, lng, r) {
        var lat1 = lat * Math.PI / 180.0;
        var lon1 = lng * Math.PI / 180.0;
        var d = r != undefined ? r : 0.00000008;
        var x;
        var str = '';
        var chk = 0;
        for (x = 0; x <= 360; x += 40) {
            chk = 0;
            var tc = (x / 90) * Math.PI / 2;
            var lati = Math.asin(Math.sin(lat1) * Math.cos(d) + Math.cos(lat1) * Math.sin(d) * Math.cos(tc));
            lati = 180.0 * lati / Math.PI;
            var lon;
            if (Math.cos(lat1) == 0) {
                lon = lonin; // endpoint a pole
            } else {
                lon = ((lon1 - Math.asin(Math.sin(tc) * Math.sin(d) / Math.cos(lat1)) + Math.PI) % (2 * Math.PI)) - Math.PI;
            }
            lon = 180.0 * lon / Math.PI;
            str = lati + '_' + lon;
            if ($.inArray(str, strCoords) == -1) {
                break;
            } else {
                chk = 1;
            }
        }

        if (chk == 1) {
            r = d + 0.00000008;
            str = offsetLatLng(lat, lng, r);
            return str;
        } else {
            return str;
        }
    }

    /*selection tools functions start*/

    function processCircle(e) {

      all_overlays[0] = e;
       var Lat= all_overlays[0].center.lat().toFixed(7),
           Lng= all_overlays[0].center.lng().toFixed(7),
        Radius= (all_overlays[0].getRadius()).toFixed(2);
        var latlong = buildCircle([{lat:Lat,lng:Lng}],(Radius*0.000621371));
        for(var i=0; i< latlong.length; i++){
            bounds.extend(latlong[i])
        }
        shape = new google.maps.Polygon({paths: latlong});

        all_proposal_ids = [];
        if (markerClusterer) {
            markerClusterer.clearMarkers();
        }

        updateMap(true);
    }

    function RemoveCircle()
    {
        if(all_overlays[0]){
            all_overlays[0] =null;
         }
         myToolbox.RemoveCircle();
        shape = null;
        updateMap(false);

      }

    function RemovePloygon()
    {
         if(all_overlays[1]){
             all_overlays[1].setMap(null);
             all_overlays[1] =null;
         }
          myToolbox.RemovePolygon();
        shape = null;
     updateMap(false);

    }
    function processVertex(e) {
        var latlong=[];
        $.each(e.latLngs.b[0].b, function(key, LatLongsObject){
          latlong.push({lat:LatLongsObject.lat(),lng:LatLongsObject.lng()});
          bounds.extend(LatLongsObject);
        });

        shape = new google.maps.Polygon({paths: latlong});

        all_proposal_ids = [];
        if (markerClusterer) {
            markerClusterer.clearMarkers();
        }

        updateMap(true);
    }

    function buildCircle(p, radius) {
        var latin = p[0].lat;
        var lonin = p[0].lng;

        var locs = new Array();
        var lat1 = latin * Math.PI / 180.0;
        var lon1 = lonin * Math.PI / 180.0;
        var d = radius / 3956;
        var x;
        for (x = 0; x <= 360; x += 10) {
            var tc = (x / 90) * Math.PI / 2;
            var lat = Math.asin(Math.sin(lat1) * Math.cos(d) + Math.cos(lat1) * Math.sin(d) * Math.cos(tc));
            lat = 180.0 * lat / Math.PI;
            var lon;
            if (Math.cos(lat1) == 0) {
                lon = lonin; // endpoint a pole
            } else {
                lon = ((lon1 - Math.asin(Math.sin(tc) * Math.sin(d) / Math.cos(lat1)) + Math.PI) % (2 * Math.PI)) - Math.PI;
            }
            lon = 180.0 * lon / Math.PI;
            latLng = {lat:lat,lng:lon};
            locs.push(latLng);
        }
        return locs;
    }
    /*selection tools functions end*/



    function getClickedId() {
        return activityMarkerId;
    }

</script>