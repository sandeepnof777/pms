<?php $this->load->view('global/header'); ?>
<?php

$prospectInfo = [];
$prospectInfoNoAddress =[];

foreach ($prospects as $prospect) {
    /* @var $prospect \models\Prospects */

    if ($prospect->isMapped()) {

        $prospectInfoObj = new stdClass();
        $prospectInfoObj->id = $prospect->getProspectId();
        $prospectInfoObj->name = $prospect->getFullName();
        $prospectInfoObj->address = $prospect->getAddress();
        $prospectInfoObj->city = $prospect->getCity();
        $prospectInfoObj->state = $prospect->getState();
        $prospectInfoObj->zip = $prospect->getZip();
        $prospectInfoObj->companyName = $prospect->getCompanyName();
        $prospectInfoObj->email = $prospect->getEmail();
        $prospectInfoObj->cellPhone = $prospect->getCellPhone();
        $prospectInfoObj->geocodeString = $prospectInfoObj->address . ' ' . $prospectInfoObj->zip;
        $prospectInfoObj->type = $prospect->getRating();
        $prospectInfoObj->readableDiff = date('m/d/Y g:i a', $prospect->getCreated(true));
        $prospectInfoObj->lat = $prospect->getLat();
        $prospectInfoObj->lng = $prospect->getLng();
        $prospectInfo[] = $prospectInfoObj;
    }
    else {
        $prospectInfoNoAddress[] = $prospect;
    }
}
?>


<div id="content" class="clearfix">
<div class="widthfix">

	<div id="mapLegend" style="padding-bottom: 30px;">

            <input type="hidden" id="group" value="<?php echo $group; ?>" />
            <input type="hidden" id="defaultUserAddress" value="<?php echo $account->getAddress() . ' ' . $account->getCity() . ' ' . $account->getState() . ' ' . $account->getZip(); ?>" />

                <div class="legendItem" style="width: 150px; float: left">
                    <div class="prospectMarkerUnknown"></div>
                    <p style="padding: 3px 0 0 30px">Unknown</p>
                </div>


                <div class="legendItem" style="width: 150px; float: left">
                    <div class="prospectMarkerSilver"></div>
                    <p style="padding: 3px 0 0 30px">Silver</p>
                </div>

                <div class="legendItem" style="width: 150px; float: left">
                    <div class="prospectMarkerGold"></div>
                    <p style="padding: 3px 0 0 30px">Gold</p>
                </div>

                <div class="legendItem" style="width: 150px; float: left">
                    <div class="prospectMarkerPlatinum"></div>
                    <p style="padding: 3px 0 0 30px">Platinium</p>
                </div>

                <div class="legendItem" style="width: 200px; float: left">
                    <select onchange="ShowFilteredRecords(this.value)">
                        <option value="all" selected="selected">All</option>
                        <option value="Unknown">Unknown</option>
                        <option value="Silver">Silver</option>
                        <option value="Gold">Gold</option>
                        <option value="Platinium">Platinium</option>
                    </select>
                </div>

            </div>
    <div id="markersLoading" style="padding: 10px; text-align: center" data-marker-total="<?php echo count($prospectInfo); ?>">
                <h3 style="text-align: center">Loading Your Prospects Now</h3>
                <hr />
                <p><span id="markersLoaded">0</span> of <?php echo count($prospectInfo); ?></p>
            </div>
            
     <div class="clearfix"></div>
  <div class="content-box">
        <div class="box-header">
            Prospects Map
        </div>
        <div class="box-content">

         <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
                    <input id="start_lat" type="hidden"><input id="start_lng" type="hidden"><input id="start_place_id" type="hidden">

            <div id="mapDiv" style="width:100%; height:600px; float:left; margin-right:1%" ></div>
            <div style="float: left; margin: 10px;" id="leads_no_address" ></div>

                    <div id="directionsContainerPanel" style="clear: both; padding: 20px; display: none;">
                        <div id="linkWrapper" style="padding: 10px;">
                            <div style="width: 30%; float: left">
                                <p><a href="#" id="navLink" target="_blank">Click for directions on Google</a></p>
                            </div>
                            <p><input type="text" id="navEmail" class="text" value="<?php echo $account->getEmail(); ?>" /><input type="button" id="sendNavigationLink" class="btn" value="Send Link" /></p>
                        </div>
						
                        <div id="DirectionsPanel"></div>
                    </div>

        </div>
    </div>


    <div class="clearfix"></div>
    <?php if (count($prospectInfoNoAddress)) { ?>

        <div class="content-box">
            <div class="box-header">Unmapped Prospects</div>
            <div class="box-content" style="padding: 15px;">

                <p style="margin-bottom: 20px;">We couldn't map some prospects due to incomplete project address data. Edit the prospect information to make them appear on the map.</p>

                <table id="prospectsNoAddressTable" class="display" width="100%">
                    <thead>
                    <tr>
                        <th>Created</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Zip</th>
                        <th>Contact</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($prospectInfoNoAddress as $unmappedProspect) {
                        /* @var $unmappedProspect \models\Prospects */
                        ?>
                        <tr>
                            <td><?php echo $unmappedProspect->getCreated(); ?></td>
                            <td><?php echo $unmappedProspect->getCompanyName(); ?></td>
                            <td><?php echo $unmappedProspect->getAddress(); ?></td>
                            <td><?php echo $unmappedProspect->getZip(); ?></td>
                            <td><?php echo $unmappedProspect->getFirstName() . ' ' . $unmappedProspect->getLastName(); ?></td>
                            <td><a href="<?php echo site_url('prospects/edit/' . $unmappedProspect->getProspectId()); ?>">Edit Prospect</a></td>
                        </tr>

                    <?php } ?>
                    </tbody>


                </table>

                <div class="clearfix"></div>
            </div>
        </div>
    <?php } ?>

</div>
</div>
<style type="text/css">
        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
            margin-top: 7px;
            height:28px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

    </style>
    <script type="text/javascript" src="/static/js/markerclusterer.js"></script>
    <script type="text/javascript" src="/static/js/MapLibrary.js"></script>

    <script type="text/javascript">


    var allPoints = <?php echo json_encode($prospectInfo); ?>;
    console.log(allPoints);
	var prospectNoAdrss = <?php echo json_encode($prospectInfoNoAddress); ?>;
    var map=null;
    var MapObj ;
    var strtMarker;
    var isPolygon = false;
    var points =[];
    var polylines =[];
    var polygons =[];
    var mouseMoveListener = null;
    var mouseClickListner= null;
    var polyMoveListener = null;
    var polyClickListner= null;
    var lineMoveListener = null;
    var lineClickListner= null;
    var UserLocListener = null;
    var routeLocListener = null;
    var eraseLocListener = null;
    var fitBoundsLocListener = null;
    var controlUI, controlUI2 , controlUI3, controlUI4 , controlUI5;
    var polygon;
    var selections=[];
    var directionsService;
    var directionsDisplay;
    var stepDisplay;
    var wayTmpPnt = new Array();
    console.log(allPoints.length);
	$(document).ready(function() {
        initialize(0); // initiate the function
		//LoadleadInfoNoAdress();
        // Load the default address
        $("#pac-input").val($('#defaultUserAddress').val());


        $("#location-limit-dialog").dialog({
            modal: true,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            width: 700
        });

        $("#start-required-dialog").dialog({
            modal: true,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            width: 700
        });

        $("#send-navlink-dialog").dialog({
            modal: true,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            width: 300
        });

        $("#markersLoading").dialog({
            modal: true,
            autoOpen: true,
            width: 400
        });

        $("#sendNavigationLink").click(function() {

            $("#send-navlink-dialog").dialog('open');

            var navEmail  = $("#navEmail").val();
            var navLink = $("#navLink").attr('href');

            $.ajax({
                type: 'POST',
                url: '/ajax/sendNavLink',
                dataType: "json",
                data: {
                    'navEmail': navEmail,
                    'navLink': navLink
                },
                success: function(data) {
                    if (data.sent == 1) {
                        $("#nav-send-status").text('Email Sent!');
                    }
                    else {
                        $("#nav-send-status").text('There was a problem sending the email. Please try again');
                    }
                }
            });
        });

        $("#prospectsNoAddressTable").dataTable({
            "aaSorting": [[ 0, 'desc']],
            "aoColumns": [
                {"sType": "date-formatted"},
                null,
                null,
                null,
                null,
                null
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop"><"#statusFilter">f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
        });

    });
	
    // function for geocode
    function initialize(i){

        var lat = allPoints[i].lat;
        var lng = allPoints[i].lng;
        var str = lat + '_' + lng;

        if ($.inArray(str, wayTmpPnt) != -1) {
            str = getOffsetLatLng(lat,lng);
            var a = str.split('_');
            lat = a[0];
            lng = a[1];
        }

        wayTmpPnt.push(str);

        if(MapObj==undefined)
        { initMap(lat,lng,i); }  // initiate the map when 1st address geocoded to set the map center
        else
        {
            createMarker(i); // create markers
            var j = ++i;
            $("#markersLoaded").text(j);

            // check the recurssive condition
            if(j < (allPoints.length)) {
                setTimeout(function(){initialize(j);}, 10); //call same function for loop
            }

        }
    }
    
	// map initialization
    function initMap(lat,lng,i)
    {
        directionsService = new google.maps.DirectionsService;
        MapObj = new GetMap('mapDiv',{
            center: {lat: parseFloat(lat), lng: parseFloat(lng)}, // center to set the map
            initMap:true,										// initialize the map by default
            callback : function(){								// function to run once on map idle event or map after map finish loading
                createMarker(i);
                var j = ++i;
                    initialize(j);
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
            }
        });
        map = MapObj.getMap();

        var controlDiv = document.createElement('div');
        controlDiv.style.background = 'white';
        controlDiv.style.padding = '2px';
        controlDiv.style.margin = '5px';
        // Set CSS for the control border
        controlUI = document.createElement('div');
        controlUI.style.float = 'left';
        controlUI.style.textAlign = 'center';
        controlUI.id = 'user-loc';
        controlUI.title = 'Click to show all map markers';
        controlUI.innerHTML = '<img class="routeHide" src="<?php echo site_url('static/images/user-loc.png'); ?>" />';
        controlDiv.appendChild(controlUI);
        //if($('#group').val()!=1){
        controlUI2 = document.createElement('div');
        controlUI2.style.float = 'left';
        controlUI2.style.textAlign = 'center';
        controlUI2.id = 'polygon';
        controlUI2.setAttribute('show','1');
        controlUI2.title = 'Click to draw the polygon';
        controlUI2.innerHTML = '<img src="<?php echo site_url('static/images/polygon.png'); ?>" />';

        controlDiv.appendChild(controlUI2);
        controlUI3 = document.createElement('div');
        controlUI3.style.float = 'left';
        controlUI3.style.textAlign = 'center';
        controlUI3.id = 'erase';
        controlUI3.title = 'Click to erase the polygon';
        controlUI3.innerHTML = '<img class="routeHide" src="<?php echo site_url('static/images/erase.png'); ?>" />';
        controlDiv.appendChild(controlUI3);
        //}
        controlUI4 = document.createElement('div');
        controlUI4.style.float = 'left';
        controlUI4.style.textAlign = 'center';
        controlUI4.title = 'Click to get best route';
        controlUI4.id = 'route';
        controlUI4.innerHTML = '<img class="routeHide" src="<?php echo site_url('static/images/route.png" />'); ?>" />';
        controlDiv.appendChild(controlUI4);

        controlUI5 = document.createElement('div');
        controlUI5.style.float = 'left';
        controlUI5.style.textAlign = 'center';
        controlUI5.title = 'Click to show current position';
        controlUI5.id = 'fit-bounds';
        controlUI5.innerHTML = '<img class="routeHide" src="<?php echo site_url('static/images/map-marker.png'); ?>" />';
        controlDiv.appendChild(controlUI5);
        controlDiv.index = 9999991;
        var input = (document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        fitBoundsLocListener = google.maps.event.addDomListener(controlUI, 'click', fitToBounds);

        google.maps.event.addDomListener(controlUI2, 'click', StartPolygon);
        eraseLocListener = google.maps.event.addDomListener(controlUI3, 'click', removePolygon);

        UserLocListener = google.maps.event.addDomListener(controlUI5, 'click', getLocation);

        routeLocListener = google.maps.event.addDomListener(controlUI4, 'click', startDrawRoute);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            //console.log(place + '1111');
            $('#start_lat').val(place.geometry.location.lat());
            $('#start_lng').val(place.geometry.location.lng());
            $('#start_place_id').val(place.place_id);
        });
        directionsDisplay = new google.maps.DirectionsRenderer({map: map,panel:document.getElementById('DirectionsPanel')});

    }
	
    // create markers
    function createMarker(i){

        if(allPoints[i].lat != undefined && allPoints[i].lng != undefined)
        {
            myLatLng = new google.maps.LatLng(allPoints[i].lat, allPoints[i].lng);

            var j = 1;
            var iconImg = '<?php echo site_url('static/images/unknown-prospect.png'); ?>';
            if (allPoints[i].type == 'Silver') {
                colorPoint =   new google.maps.Point(86, 0);
                var iconImg = '<?php echo site_url('static/images/silver-prospect.png'); ?>';
            }
            if (allPoints[i].type == 'Gold') {
                colorPoint =   new google.maps.Point(86, 0);
                var iconImg = '<?php echo site_url('static/images/gold-prospect.png'); ?>';
            }
            else if (allPoints[i].type == 'Platinium'){
                colorPoint =   new google.maps.Point(0, 0);
                var iconImg = '<?php echo site_url('static/images/platinum-prospect.png'); ?>';
            }
            var icon = new google.maps.MarkerImage(iconImg, new google.maps.Size(25,25));

            allPoints[i].position= new google.maps.LatLng(allPoints[i].lat, allPoints[i].lng);
            allPoints[i].icon=icon;    // set the icon for marker
            allPoints[i].i=i;
            allPoints[i].infowindow = true; // set infowindow parameter to true to open infowindow on click of marker

            var markerContent = '<div style="min-height: 50px; margin:auto;">';
            var markerContent = '<div style="min-height: 50px; color:#4682B4; margin:auto;">';
            markerContent += '<table>';
            markerContent += '<tr>';
            markerContent += '<td colspan="2" style="text-align: right; font-size: 0.8em;"><a href="/prospects/edit/' + allPoints[i].id + '">Edit Prospect</a></td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Prospect Name:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' +allPoints[i].name + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Company:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' +allPoints[i].companyName + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Address:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' +allPoints[i].address + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>City:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' +allPoints[i].city + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>State:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' +allPoints[i].state + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Zip:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' +allPoints[i].zip + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Email:</strong></td>';
            markerContent += '<td style="padding-left: 10px;"><a href="mailto:' + allPoints[i].email + '">' + allPoints[i].email + '</a></td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Cell Phone:</strong></td>';
            markerContent += '<td style="padding-left: 10px;"><a href="tel:'+allPoints[i].cellPhone+'">' + allPoints[i].cellPhone + '</a></td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Created:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' + allPoints[i].readableDiff + '</td>';
            markerContent += '</tr>';
            markerContent += '</table>';
            markerContent += '</div>';
            allPoints[i].infowindowContent = markerContent;  // set the content to show on infowindow
            marker = MapObj.createMarker(allPoints[i]); // call function to create single markers.

            if($('#group').val()==1)
            { selections.push(marker);
                if(allPoints.length-1 == i)
                    startDrawRoute();
            }

            if(i==allPoints.length-1)
            {
               // MapObj.setMarkerCluster();      // to set the marker cluster
                MapObj.SetBounds();
				$("#markersLoading").dialog('close');
            }

        }

    }

    
	</script>

    <div id="location-limit-dialog" title="Routing Limit Exceeded">

        <p>Routing information is limited to 8 locations (including your starting location).</p><br />

        <p>Please redraw the map to include fewer locations and we can provide you with the best route.</p>

    </div>

    <div id="start-required-dialog" title="Starting Location Required">

        <p>A start location is required to plan a route.</p><br />

        <p>Please click the crosshair to use your current location, or manually enter an address.</p>

    </div>

    <div id="send-navlink-dialog" title="Sending Email">
        <p id="nav-send-status" style="text-align: center">Sending Email...</p>
    </div>

<?php $this->load->view('global/footer'); ?>