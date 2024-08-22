// Create by Preeti
// This library is for common features of google map api.
// Here is an example for how to use this library
// var MapObj = new GetMap('mapDiv',{
//								center: {lat: 39.0757883, lng: -84.17496540000002}, // center to set the map
//								initMap:true,										// initialize the map by default
//								callback : function(){								// function to run once on map idle event or map after map finish loading
//										// some statements
//								}
//


var GetMap = function(mapDiv, options){
    var _map;
    var _markers =[];
    var _marker;
    var _infoWindow = new google.maps.InfoWindow();
    var _bounds = new google.maps.LatLngBounds();
    var _geocoder = new google.maps.Geocoder;
    var _markerCluster;
    var _userLocMarker;
    var _mcOptions = {gridSize: 50, maxZoom: 15};
    var _options = {
        mapDiv : mapDiv,
        mapOptions: {
            center:{lat: 39.0757883, lng: -84.17496540000002},
            zoom:8,
            gestureControl: 'greedy'
        }
    };

    if (options) {
        _LoadOptions(options);
    }

    function _Init(_options){
        _map = new google.maps.Map(document.getElementById(_options.mapDiv));
        _map.setOptions(_options.mapOptions);
        if(_options.mapOptions.callback != undefined)
        {
            google.maps.event.addListenerOnce(_map, 'idle', function(){
                if(typeof _options.mapOptions.callback == 'function')
                    _options.mapOptions.callback.call();
            });

        }
        if(_options.mapOptions.Geolocation)
            _Geolocation({
                MapCenter :true,   // set true to set the map center to user's current location
                Marker:false,		// set true to create marker at user's current location
                SetAddress:'',     // pass id of input/div to show address
                SetLatLng: '', 		//  pass id of input/div to show comma separated lat lng
                callback:'' // pass the callback function
            });
    }

    function _LoadOptions(options) {
        for (optionName in options) {
            _options.mapOptions[optionName] = options[optionName];
        }
        if(options.initMap)
            _Init(_options);
    }

    function _Geolocation(options){
        if(_userLocMarker)
        {_userLocMarker.setMap(null);
            _userLocMarker=null;
			//_userLocMarker=undefined;
        }
        else
        {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    if(options.MapCenter)
                        _map.setCenter(pos);

                    if(options.Marker){
                        _userLocMarker = new google.maps.Marker({ position:pos, map:_map});
						_bounds.extend(pos);
                        google.maps.event.addDomListener(_userLocMarker, 'click', (function(e) {
                            //_userLocMarker.setMap(null);
                        }));
                    }

                    if(options.SetAddress !='' && options.SetAddress != undefined)
                        _geocodeLatLng(position.coords.latitude, position.coords.longitude,options.SetAddress, options.callback);

                }, function(position) {
                    console.log(position);
                });
            } else {
                console.log('Failed');
            }
        }
    }
    function _geocodeLatLng() {

        var arr = arguments;
        var latlng = {lat: arr[0], lng: arr[1]};
        _geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    $('#'+arr[2]).val(results[1].formatted_address);
                    var a = new Array({marker:_userLocMarker, adress:results[1].formatted_address, lat: arr[0], lng: arr[1] ,results: results[1]});
                    if(arr[3] != undefined && typeof arr[3] == 'function' )
                        arr[3].apply(null,a);
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    }
    function _createSingleMarker(data){
        _marker = new google.maps.Marker(data);
        _marker.data = data;
        _marker.setMap(_map);
        _markers.push(_marker);
        _bounds.extend(data.position);
        if(data.infowindow){
            google.maps.event.addDomListener(_marker, 'click', (function(e) {
                _infoWindow.setPosition(this.position); // set the position of infowindow
                _infoWindow.setContent(this.infowindowContent); // set the content of infowindow
                _infoWindow.open(_map, this); // open the infowindow
            }));
        }
        return _marker;
    }
    function _clearMarkers(){
        //clearMarkers();
        var temp = _markers;
        var len = temp.length;
        if(_markerCluster)
            _markerCluster.clearMarkers();
        for(var i = 0 ; i < len; i++)
            _clearMarker(i);
        _markers =[];
    }

    function _clearMarker(i){
        if(_markers[i] != undefined)
            _markers[i].setMap(null);
    }
//-----------------------Public Function----------------------------  


    this.getMap = function(){
        return _map;
    }

    this.initMap = function(){
        _Init(_options);
    }

    this.setOptions = function(option){
        _map.setOptions(option);
    }

    this.geoLocation = function(options,callBack){
        _Geolocation(options,callBack);

    }

    this.createMarker = function(data){
        var marker = '';
        if(data.length == undefined)
        {marker = _createSingleMarker(data);}
        else
        {
            for(var i =0; i<data.length; i++){
                if(data[i] != undefined)
                    _createSingleMarker(data[i]);
            }
        }
        return marker;
    };

    this.FilterMarkers = function(allPoints,type, val,mc){
        var temp = allPoints;
        var len = temp.length;
        _clearMarkers();
        for(var i =0; i< len;i++){
            if(temp[i][type]==val)
                _createSingleMarker(temp[i]);
        }
        if(_markerCluster && mc==1)
            _markerCluster = new MarkerClusterer(_map, _markers, _mcOptions);
    }
    this.GetMarkers = function(){
        return _markers;
    }
    this.GetBounds = function(){
        return _bounds;
    }
    this.SetBounds = function(){
		var bounds = new google.maps.LatLngBounds();
		if(_userLocMarker)
		bounds.extend(_userLocMarker.getPosition());
		for(var i =0; i <_markers.length;i++){
			bounds.extend(_markers[i].getPosition());
			}
			
        _map.fitBounds(bounds);
    };
    this.setMarkerCluster = function(){

        var temp = new Array();
        for (var i in markers) {
            temp.push(markers[i]);
        }
        _markerCluster = new MarkerClusterer(_map, temp, _mcOptions);
    };
	this.boundsReset = function(){
		_bounds =null;
		_bounds = new google.maps.LatLngBounds();
		console.log(_userLocMarker);
		if(_userLocMarker)
		_bounds.extend(_userLocMarker.getPosition());
		}
}

// common functions for leads and prospects map

function getOffsetLatLng(lat,lng,r){
    var lat1 = lat * Math.PI / 180.0;
    var lon1 = lng * Math.PI / 180.0;
    var d = r != undefined ? r : 0.0000004;
    var x;
	var str='';
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
		if ($.inArray(str, wayTmpPnt) == -1)	
				break;
		else
			chk = 1;		
				
    }
			//console.log('Offestting position: ' + str);
			if(chk ==1){
				r = d+0.0000004;
				str = getOffsetLatLng(lat,lng, r);
				return str;
				}
			else{
			return str;
			}
	}
	
	// function for geocode
	
    function mailto(Email) {
        window.location = 'mailto:' + Email;
    }

    // get the user's current location
    function getLocation() {
        MapObj.geoLocation({
            MapCenter :true,   // set true to set the map center to user's current location
            Marker:true,		// set true to create marker at user's current location
            SetAddress:'pac-input',     // pass id of input/div to show address
            callback:function(a){   // pass the callback function
                $('#start_lat').val('');
            }
        });
    }

    // initiate the polygon drawing
    function StartPolygon(){
       
	   changeIcons('disable');
        if($('#polygon').attr('show') == 1){
            $('#polygon').html('<img src="'+SITE_URL+'/static/images/hand.png" />');
            $('#polygon').attr('show','2')
        }else{
            stopDrawing();
            removePolygon();
        }
        //clearAllMarkers(); // clear all markers
        clearAllPolylines();

        map.setOptions({ // change map cursor
            draggableCursor:'crosshair',
            draggingCurosr: 'crosshair'
        });

        mouseClickListner = google.maps.event.addListener(map, 'click', function(e){
            if(points.length==0)
            {
                points = [];
                isPolygon = true;
                points[0] =e.latLng;
                strtMarker = new google.maps.Marker({
                    position: e.latLng,
                    icon : SITE_URL+'/static/images/Complete_Symbol-20.png'
                });
                strtMarker.setMap(map); // set marker on map
                google.maps.event.addListener(strtMarker, 'click', stopDrawing);
            }
            else{
                if(isPolygon){
                    var that = this;
                    startDrawing(e, that);
                }
            }
        });

    }



    function changeIcons(ty){
        var icons = [
            { id : 'user-loc',
                func:''},
            { id : 'erase',
                func:''},
            { id : 'route',
                func:''},
            { id :'fit-bounds',
                func:''}
        ];

        if(ty=='disable'){
            if(UserLocListener)
                google.maps.event.removeListener(UserLocListener);
            if(routeLocListener)
                google.maps.event.removeListener(routeLocListener);
            if(eraseLocListener)
                google.maps.event.removeListener(eraseLocListener );
            if(fitBoundsLocListener)
                google.maps.event.removeListener(fitBoundsLocListener );
        }
        else
        {
            fitBoundsLocListener = google.maps.event.addDomListener(controlUI, 'click', fitToBounds);
			eraseLocListener = google.maps.event.addDomListener(controlUI3, 'click', removePolygon);
            UserLocListener = google.maps.event.addDomListener(controlUI5, 'click', getLocation);
            routeLocListener = google.maps.event.addDomListener(controlUI4, 'click', startDrawRoute);
            
        }
        for(var i = 0 ; i<icons.length; i++){
            if(ty=='disable')
                $(".routeHide").hide();
            
            else
                $(".routeHide").show();
            
        }

    }
	
    function fitToBounds(){
        MapObj.SetBounds();
    }
	
    function startDrawing(e , that){

        if(isPolygon){
            points.push(e.latLng);
            drawLine();
        }
    }
	
    function stopDrawing(){

        if($('#polygon').attr('show') == 2){
            $('#polygon').html('<img src="'+SITE_URL+'/static/images/polygon.png" />');
            $('#polygon').attr('show','1');
        }
        changeIcons('enable');
        isPolygon = false;
        RemoveAllListner();
		if(strtMarker)
        strtMarker.setMap(null);
        map.setOptions({ // change map cursor
            draggableCursor: "default",
            draggingCursor: "default"
        });
        clearAllPolylines();
        if(polygon)
            polygon.setMap(null);
        var poly = new google.maps.Polygon({
            paths: points,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
        });
        poly.setMap(map);
        polygons.push({poly:poly, path:points});
        points =[];
        filterRecords(1);
    }

    function RemoveAllListner(){
        if(mouseMoveListener)
            google.maps.event.removeListener(mouseMoveListener);
        if(mouseClickListner)
            google.maps.event.removeListener(mouseClickListner);
        if(polyMoveListener)
            google.maps.event.removeListener(polyMoveListener );
        if(polyClickListner)
            google.maps.event.removeListener(polyClickListner);
        if(lineClickListner)
            google.maps.event.removeListener(lineClickListner);

    }
	
    // draw shape
    function drawLine(){
        var path = [];
        path.push(points[points.length-2]);
        path.push(points[points.length-1]);
        var polyline = new google.maps.Polyline({
            path: path,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2,
            cursor:  "crosshair"
        });
        polyline.setMap(map);
        polylines.push(polyline);
        lineClickListner= google.maps.event.addListener(polyline,'click', function(e){
            var that = this.getMap();
            startDrawing(e, that);
        });

        if(polygon)
            polygon.setMap(null);
        polygon = new google.maps.Polygon({
            paths: points,
            strokeColor: '#FF0000',
            strokeOpacity: 0.0,
            strokeWeight: 0,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            cursor:  "crosshair"
        });
        polygon.setMap(map);
        polyMoveListener = google.maps.event.addListener(polygon, 'click', function(e){
            var that = this.getMap();
            startDrawing(e, that);
        });
        //polyClickListner = google.maps.event.addListener(polygon, 'click', stopDrawing);
    }

    //clear all map markers
    function clearAllPolylines(){
        var l = polylines.length;
        for(var i =0 ; i<l; i++)
        {
            if(typeof(polylines[i]) !='undefined' && polylines[i] != undefined)
            {
                //console.log(polylines[i]);
                polylines[i].setMap(null);
            }
        }
        polylines =[];
    }

    // remove last drawn polygon
    function removePolygon(){
        var len = polygons.length;
        var temp = polygons;
        polygons =[];
        if(len>0)
        {
            if(temp[len-1])
                temp[len-1].poly.setMap(null);
        }
        for(var i =0; i<temp.length-1; i++)
            polygons.push(temp[i]);
        directionsDisplay.setMap(null);
        $('#DirectionsPanel').html('');
        filterRecords(1);
    }

    function filterRecords(mc){
        var len = polygons.length;
        var PolyPath =[];
        selections =[];
        for(var j =0; j < len ; j++){

            var path = polygons[j].path;
            var pLen = path.length;
            var temp = [];
            for(var k =0; k < pLen; k++)
            {
                temp.push({
                    x: path[k].lat(),
                    y: path[k].lng()
                });
            }
            PolyPath[j] = temp;
        }
        var l = allPoints.length;
        for(var i =0 ; i<l; i++){
            if(allPoints[i].lat != undefined && allPoints[i].lng != undefined){
                allPoints[i].markerVisible = false;
                if(len==0)
                    allPoints[i].markerVisible = true;
                var p = {
                    x: allPoints[i].lat,
                    y: allPoints[i].lng
                }
                for(var j = 0 ;j <len;j++){
                    var status = isPointInPoly(PolyPath[j], p) ? 1 : 0;
                    if(status == 1)
                        allPoints[i].markerVisible = true;
                }

            }

        }
        MapObj.FilterMarkers(allPoints,'markerVisible' , true,mc);
    }
	
    // check points wihin shape
    var isPointInPoly = function(poly, pt) {

        for (var c = false, i = -1, l = poly.length, j = l - 1; ++i < l; j = i)
            ((poly[i].y <= pt.y && pt.y < poly[j].y) || (poly[j].y <= pt.y && pt.y < poly[i].y)) && (pt.x < (poly[j].x - poly[i].x) * (pt.y - poly[i].y) / (poly[j].y - poly[i].y) + poly[i].x) && (c = !c);
        return c;
    };
    // filter all leads

    function ShowFilteredRecords(val){
        var l = allPoints.length;
		MapObj.boundsReset();
        for(var i =0 ; i<l; i++){
            if(allPoints[i].lat != undefined && allPoints[i].lng != undefined){
                allPoints[i].markerVisible = false;
                if(allPoints[i].type==val || val =='all')
                    allPoints[i].markerVisible = true;
            }

        }
		console.log(allPoints);
        MapObj.FilterMarkers(allPoints,'markerVisible' , true,1);
    }
    // draw route
    function startDrawRoute(){

        $("#directionsContainerPanel").show();
        var strt = $('#pac-input').val();
        //console.log(strt);
        directionsDisplay.setMap(map);

        if(strt !=''){
            var midPoints= [];
            selections= MapObj.GetMarkers();
            if(selections.length>0){
                //console.log(selections[0].getPosition().lat());
                var url ='https://www.google.com/maps/dir/'+strt;
                for(var i =0; i<selections.length-1;i++){

                    url +='/'+selections[i].geocodeString;
                    midPoints.push({
                        location: selections[i].geocodeString,
                        stopover: true
                    });
                }
                url +='/'+selections[selections.length-1].geocodeString;
                $('#navLink').attr('href',url);
                //return false;
                //console.log(midPoints);
                if(midPoints.length>7)
                {
                    $("#location-limit-dialog").dialog('open');
                }
                else
                {
                    var origin =strt;
                    if($('#start_lat').val() !=''){
                        origin ={
                            location: {lat:$('#start_lat').val(),lng:$('#start_lng').val()},
                            placeId: $('#start_place_id').val()
                        };
                    }

                    directionsService.route({
                        origin: $('#pac-input').val() ,
                        destination:selections[selections.length-1].geocodeString,
                        waypoints: midPoints,
                        optimizeWaypoints:true,
                        travelMode: google.maps.TravelMode.DRIVING
                    }, function(response, status) {
                        if (status === google.maps.DirectionsStatus.OK) {
                            filterRecords(0);
                            directionsDisplay.setDirections(response);
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });
                }
            }
            else
            {
                alert('Please select points to draw route.')
            }
        }
        else
        {
            $('#start-required-dialog').dialog('open');
        }
    }
	