  <?php $this->load->view('global/header'); ?>

<?php

$leadInfo = [];
$leadInfoNoAddress =[];

foreach ($leads as $lead) {

    //$lead = $leadArray[0];

    /* @var $lead models\Leads */

    if ($lead->isMapped()) {
        $leadInfoObj = new stdClass();
        $leadInfoObj->id = $lead->getLeadId();
        $leadInfoObj->companyName = $lead->getCompanyName();
        $leadInfoObj->name = $lead->getFirstName() . ' ' . $lead->getLastName();
        $leadInfoObj->address = $lead->getProjectAddress();
        $leadInfoObj->city = $lead->getProjectCity();
        $leadInfoObj->state = $lead->getProjectState();
        $leadInfoObj->zip = $lead->getProjectZip();
        $leadInfoObj->status = $lead->getStatus();
        $leadInfoObj->email = $lead->getEmail();
        $leadInfoObj->businessPhone = $lead->getBusinessPhone(true);
        $leadInfoObj->cellPhone = $lead->getCellPhone();
        $leadInfoObj->created = $lead->getCreated(true);
        $leadInfoObj->geocodeString = $leadInfoObj->address . ' ' . $leadInfoObj->zip;
        $diff = time()-$lead->getCreated(true);
        $datediff = floor($diff/86400);
        $leadInfoObj->diff = $datediff;
        $leadInfoObj->readableDiff = date('m/d/Y g:i a', $lead->getCreated(true));
        $leadTimeStamp = $lead->getCreated(true);
        $leadInfoObj->lat = $lead->getLat();
        $leadInfoObj->lng = $lead->getLng();
        $leadInfo[] = $leadInfoObj;
    }
    else {
        $leadInfoNoAddress[] = $lead;
    }

}
?>


    <div id="content" class="clearfix">
        <div class="widthfix">

            <input type="hidden" id="group" value="<?php echo $group; ?>" />
            <input type="hidden" id="defaultUserAddress" value="<?php echo $account->getAddress() . ' ' . $account->getCity() . ' ' . $account->getState() . ' ' . $account->getZip(); ?>" />

            <div id="mapLegend" style="padding-bottom: 30px;">
                <div class="legendItem" style="width: 200px; float: left">
                    <div class="leadMapMarkerNew"></div>
                    <p style="padding: 3px 0 0 30px">New Leads (< 2 days old)</p>
                </div>

                <div class="legendItem" style="width: 200px; float: left">
                    <div class="leadMapMarkerCurrent"></div>
                    <p style="padding: 3px 0 0 30px">Current Leads (2-7 days old)</p>
                </div>

                <div class="legendItem" style="width: 200px; float: left">
                    <div class="leadMapMarkerOld"></div>
                    <p style="padding: 3px 0 0 30px">Old Leads (7+ days old)</p>
                </div>

                <div class="legendItem" style="width: 200px; float: left">
                    <select onchange="ShowFilteredRecords(this.value)">
                        <option value="all" selected="selected">All</option>
                        <option value="new">New</option>
                        <option value="current">Current</option>
                        <option value="old">Old</option>
                    </select>
                </div>

            </div>
            <div id="markersLoading" style="padding: 10px; text-align: center" data-marker-total="<?php echo count($leadInfo); ?>">
                <h3 style="text-align: center">Loading Your Leads Now</h3>
                <hr />
                <p><span id="markersLoaded">0</span> of <?php echo count($leadInfo); ?></p>
            </div>
            <div class="clearfix"></div>

            <div class="content-box" id="mapContentBox">
                <div class="box-header">
                    Leads Map
                    <a class="box-action tiptip" href="<?php echo ($group) ? site_url('leads/group') : site_url('leads/'); ?>" title="Return to Leads page">Back</a>
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
            <?php if (count($leadInfoNoAddress)) { ?>

                <div class="content-box">
                    <div class="box-header">Unmapped Leads</div>
                    <div class="box-content" style="padding: 15px;">

                        <p style="margin-bottom: 20px;">We couldn't map some leads due to incomplete project address data. Edit the lead information to make them appear on the map.</p>

                            <table id="leadsNoAddressTable" class="display" width="100%">
                                <thead>
                                <tr>
                                    <th>Created</th>
                                    <th>Project Name</th>
                                    <th>Project Address</th>
                                    <th>Project Zip</th>
                                    <th>Contact</th>
                                    <th>Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($leadInfoNoAddress as $unmappedLead) {
                                    /* @var $unmappedLead \models\Leads */
                                    ?>
                                    <tr>
                                        <td><?php echo $unmappedLead->getCreated(); ?></td>
                                        <td><?php echo $unmappedLead->getProjectName(); ?></td>
                                        <td><?php echo $unmappedLead->getProjectAddress(); ?></td>
                                        <td><?php echo $unmappedLead->getProjectZip(); ?></td>
                                        <td><?php echo $unmappedLead->getFirstName() . ' ' . $unmappedLead->getLastName(); ?></td>
                                        <td><a href="<?php echo site_url('leads/edit/' . $unmappedLead->getLeadId()); ?>">Edit Lead</a></td>
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

    var allPoints = <?php echo json_encode($leadInfo); ?>;
	var leadsNoAdrss = <?php echo json_encode($leadInfoNoAddress); ?>;
	//console.log(allPoints);
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
    //console.log(allPoints.length);

    $(document).ready(function() {

        $("#markersLoading").dialog({
            modal: true,
            autoOpen: false,
            width: 400
        });


        initialize(0); // initiate the function
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
            width: 350
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

        $("#leadsNoAddressTable").dataTable({
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
    
	function initialize(i){

	    if (!allPoints.length) {
	        swal({
	            html: '<p style="font-size: 14px:">You do not have any leads mapped!</p><br /><p style="font-size: 14px:">Make sure you add accurate address information for each lead to enable mapping.</p>'
            });
	        $("#mapContentBox").hide();
	        return false;
        }

        $("#markersLoading").dialog('open');

        var lat = allPoints[i].lat;
        var lng = allPoints[i].lng;
        var str = lat + '_' + lng;

        if ($.inArray(str, wayTmpPnt) != -1) {
            str = getOffsetLatLng(lat,lng);
            var a = str.split('_');
            lat = a[0];
            lng = a[1];
        }

        allPoints[i].lat = lat;
        allPoints[i].lng = lng;

        wayTmpPnt.push(str);

        if(MapObj==undefined)
        { initMap(lat,lng,i); }  // initiate the map when 1st address geocoded to set the map center
        else
        {
            createMarker(i); // create markers
            var j = ++i;
            $("#markersLoaded").text(j);

            // check the recurssive condition
            if(j<allPoints.length) {
                setTimeout(function(){initialize(j);},100); //call same function for loop
            }

        }

    }
	
	// map initialization
    function initMap(lat,lng,i)
    {
        directionsService = new google.maps.DirectionsService;
        MapObj = new GetMap('mapDiv',{
            gestureHandling: 'greedy',
            center: {lat: parseFloat(lat), lng: parseFloat(lng)}, // center to set the map
            initMap:true,										// initialize the map by default
            callback : function(){								// function to run once on map idle event or map after map finish loading
                createMarker(i);
                var j = ++i;
                if(j<allPoints.length) // check the recurssive condition
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
        controlUI4.innerHTML = '<img class="routeHide" src="<?php echo site_url('static/images/route.png'); ?>" />';
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
            var iconImg = '<?php echo site_url('static/images/lead-new.png'); ?>';
			allPoints[i].type = 'new';
            if (allPoints[i].diff>=2 && allPoints[i].diff <= 7) {
                colorPoint =   new google.maps.Point(86, 0);
                allPoints[i].type = 'current';
                iconImg = '<?php echo site_url('static/images/lead-current.png'); ?>'
            }
            else if (allPoints[i].diff > 7){
                colorPoint =   new google.maps.Point(0, 0);
                allPoints[i].type = 'old';
                iconImg = '<?php echo site_url('static/images/lead-old.png'); ?>'
            }
            var icon = new google.maps.MarkerImage(iconImg, new google.maps.Size(25,25));

            allPoints[i].position= new google.maps.LatLng(allPoints[i].lat, allPoints[i].lng);
            allPoints[i].icon=icon;    // set the icon for marker
            allPoints[i].i=i;
            allPoints[i].infowindow = true; // set infowindow parameter to true to open infowindow on click of marker

            var markerContent = '<div style="min-height: 50px; color:#4682B4; margin:auto;">';
            markerContent += '<table>';
            markerContent += '<tr>';
            markerContent += '<td colspan="2" style="text-align: right; font-size: 0.8em;"><a href="/leads/edit/' + allPoints[i].id + '">Edit Lead</a></td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Lead Name:</strong></td>';
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
                //MapObj.setMarkerCluster();      // to set the marker cluster
                MapObj.SetBounds();
				$("#markersLoading").dialog('close');
            }

        }

    }

    
    // get the optimize list
    function optimizePoints(){

        var strt = $('#pac-input').val(); // get the start location value
        if(strt =='')
        {
            $('#start-required-dialog').dialog('open');
            return false;
        }
// geocode the start locations
        var url ="https://maps.googleapis.com/maps/api/geocode/json?address="+strt;
        $.ajax({
            type: 'GET',
            url: url,
            dataType: "json",
            success: function(data) {
                if(data.status=='OK'){
                    var lat =data.results[0].geometry.location.lat;
                    var lng = data.results[0].geometry.location.lng;
                    var obj = {Name:strt,lat:lat,lng:lng}
                    var arr = new Array();
                    arr.push(obj); // add start location in array
                    $.merge(arr,allPoints);
                    distanceWithSorting(arr);	// call function to sort the array
                }
            }
        });

    }
    // function to calculate the distance of all leads from start location and sort the leads
    function distanceWithSorting(waypointObjArrGeo) {
        var lastindex = waypointObjArrGeo.length;
        var newwaypointObjArrGeo = new Array();
        for (var i = 0; i < waypointObjArrGeo.length; i++) {
            newwaypointObjArrGeo.push(waypointObjArrGeo[i]);
        }
        var tmpArr = newwaypointObjArrGeo;
        var sortArr = new Array();
        var cPoint = newwaypointObjArrGeo[0];
        sortArr.push(cPoint);
        var cPointIndex = 0;
        var chkDist = -1;
        var lat1, lat2, lon1, lon2;
        var tmpArr2 = new Array();
        for (var i = 1; i < newwaypointObjArrGeo.length; i++) {
            if (newwaypointObjArrGeo[i].lat != '' && newwaypointObjArrGeo[i].lat != 'undefined' && newwaypointObjArrGeo[i].lat != 0 && typeof(newwaypointObjArrGeo[i].lat) != 'undefined' && newwaypointObjArrGeo[i].lat != null) {
                lat1 = cPoint.lat;
                lon1 = cPoint.lng;
                chkDist = -1;
                tmpArr2 = [];

                for (var k = 0; k < tmpArr.length; k++) {

                    if (cPointIndex != k) {
                        tmpArr2.push(tmpArr[k]);
                    }
                }
                tmpArr = [];

                tmpArr = tmpArr2;
                for (var j = 0; j < tmpArr.length; j++) {

                    if (tmpArr[j].lat != '' && tmpArr[j].lat != 'undefined' && tmpArr[j].lat != 0 && typeof(tmpArr[j].lat) != 'undefined' && tmpArr[j].lat != null) {
                        lat2 = tmpArr[j].lat;
                        lon2 = tmpArr[j].lng;

                        var d = getDistance(lat1, lon1, lat2, lon2);

                        if (chkDist == -1) {
                            chkDist = d;
                            cPointIndex = j;
                            cPoint = tmpArr[j];
                        } else if (chkDist > d) {
                            cPoint = tmpArr[j];
                            chkDist = d;
                            cPointIndex = j;
                        }
                    }
                }

                sortArr.push(cPoint);
            }
        }
        //console.log(sortArr);
        displaySortArr(sortArr); // display the sorted leads
    }
    function displaySortArr(sortArr){
        var html ='';
        var url ='https://www.google.com/maps/dir/'+sortArr[0].name;
        for(var i =1; i<sortArr.length;i++)
        {
            html +=' <ul style="margin:10px;"><li><strong>'+sortArr[i].name+'</strong></li><li>'+sortArr[i].address+'</li><li>'+sortArr[i].state+'</li><li>'+sortArr[i].zip+'</li></ul>';
            url +='/'+sortArr[i].address+','+sortArr[i].state;
        }
        html += '<a target="_blank" href="'+url+'"> Get Route </a>';
        $('#lead_info').html(html);
    }
    function getDistance(lat1, lon1, lat2, lon2) {
        var R = 6371;
        var dLat = toRad((lat2 - lat1));
        var dLon = toRad((lon2 - lon1));
        var lat1 = toRad(lat1);
        var lat2 = toRad(lat2);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        return d;
    }
    function toRad(Value) {

        return Value * Math.PI / 180;
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
        <p id="nav-send-status" style="text-align: center; margin-top: ">Sending Email...</p>
    </div>



<?php $this->load->view('global/footer'); ?>