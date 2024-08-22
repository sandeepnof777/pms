<?php $this->load->view('global/header'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">

        <div class="content-box">

            <?php
                // $leads is the array of lead objects. I'll use the functions of an object here to get the address
                // I'll loop through 5 of these as an example

            ?>
			Start Address: <input type="text" name="Start point" id="start_point"  placeholder="Enter start address"/>
            <input type="button" value="Get Optimized list" onclick="optimizePoints();" />
            <h2>Lead Info</h2>
			<div id="lead_info">
            <?php
			$allPoints = 'var allPoints= new Array();'; // initiate a js array to have all leads in global array
                for ($i = 0; $i < 5; $i++) {
                    $lead = $leads[$i];
                    /* @var $lead models\Leads */
					
					$allPoints .= 'allPoints.push({
					Name:"'.$lead->getFirstName() .' '. $lead->getLastName().'",
					Address:"'.$lead->getAddress().'",
					State:"'.$lead->getCity() .' , '. $lead->getState().'",
					Zip:"'.$lead->getZip().'"
					});'; // push js object in js array
            ?>

            <ul style="margin:10px;">
                <li><strong><?php echo $lead->getFirstName() .' '. $lead->getLastName(); ?></strong></li>
               	<li><?php echo $lead->getAddress(); ?></li>
                <li><?php echo $lead->getCity() .' , '. $lead->getState(); ?></li>
                <li><?php echo $lead->getZip(); ?></li>
            </ul>

            <?php } ?>
			</div>
			<p>This is an edit testing the permissions.</p>

        </div>

        <div class="content-box">
            <div class="box-header">Leads Map</div>

            <div class="box-content">

                <p>Please map the leads here</p>

                <ul>
                    <li>Each lead is a marker on the map</li>
                    <li>Info window to load on click with the lead info</li>
                    <li>Make some markers different colors</li>
                </ul>
			<div id="MapDIv" style="width:600px; height:600px;" ></div>

            </div>

        </div>

    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript">
<?php echo $allPoints;?>
var map=null;
var markers=[];
var infowindow;
var bounds;
  $(document).ready(function() {
		initialize(0); // initiate the function
        });
// function for geocode		
function initialize(i){
	if(i<allPoints.length){ // check the recurssive condition
		var add = allPoints[i].Address+' , '+allPoints[i].State;
		
		// using rest service to geocode
		try {
		var url ="https://maps.googleapis.com/maps/api/geocode/json?address="+add;
		$.ajax({
			type: 'GET',
			url: url,
			dataType: "json",
			success: function(data) {
				if(data.status=='OK'){
					var lat =data.results[0].geometry.location.lat;
					var lng = data.results[0].geometry.location.lng;
					allPoints[i].lat =lat;
					allPoints[i].lng =lng;
					if(map==null)
						initMap(lat,lng); // initiate the map when 1st address geocoded to set the map center
					}
					var j = ++i;
					initialize(j);
				
			}
			});
		}
		catch(err) {
    console.log(err);
	var j = ++i;
					setTimeout(function(){initialize(j);},200);	
}
		}
	else{
	createMarker(); // create markers after all address are geocoded.
	}
	
}	
// map initialization	
function initMap(lat,lng) 
{
	bounds = new google.maps.LatLngBounds();
    map = new google.maps.Map(document.getElementById('MapDIv'), {
    zoom: 8,
    center: {lat: parseFloat(lat), lng: parseFloat(lng)}
  });
}
// create markers
function createMarker(){
		if(markers.length>0)
		{
			clearMarkers();
		}
		 for(var i =0 ;i<allPoints.length;i++)
				{
			myLatLng = new google.maps.LatLng(allPoints[i].lat, allPoints[i].lng);
			var icon = new google.maps.MarkerImage("<?php echo site_url('application/views/leads/map-assets.png'); ?>",
									 new google.maps.Size(20,20), new google.maps.Point(22*i,2)); // get the randon marker icon from spirite image
			marker = new google.maps.Marker({ 
        		position: myLatLng,
				icon:icon,
				i:i
			}); 
			marker.setMap(map); // set marker on map
			bounds.extend(myLatLng); // extend map bounds
			markers[i] = markers[i] || []; 
			infoWindow =new google.maps.InfoWindow(); // create infowindow instant
			// add marker click event
			google.maps.event.addListener(marker, 'click', (function(e) {
			showInfowindow(this.i);
			}));
			markers[i]=marker; // save marker in global array markers
						
			}
				map.fitBounds(bounds); // fit the map to show all markers on map

}
function showInfowindow(i){
		
				var pos = new google.maps.LatLng(allPoints[i].lat, allPoints[i].lng);
				markerContent = '<div style="min-height: 50px;text-align:center;margin:auto;">';
				markerContent += '<div style="color:#4682B4;"><b>'+allPoints[i].Name+'</div>';
				markerContent += '<div style="color:#4682B4;"><b>'+allPoints[i].Address+'</div>';
				markerContent += '<div style="color:#4682B4;"><b>'+allPoints[i].Zip+'</div>';
                markerContent += '</div>';
				infoWindow.setPosition(pos); // set the position of infowindow
				infoWindow.setContent(markerContent); // set the content of infowindow
				infoWindow.open(map, markers[i]); // open the infowindow
            
		}
function clearMarkers() 
	{
   		 if (markers)
		 { 
			for (var i = 0; i < markers.length; i++ ) 
			{
	  			markers[i].setMap(null);
			}
			this.markers = new Array();
  		 }
	}
	
function optimizePoints(){

var strt = $('#start_point').val(); // get the start location value
if(strt =='')
{
alert('Please enter a start location.');
return false;
}
// geocode the start location
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
	console.log(sortArr);
	displaySortArr(sortArr); // display the sorted leads
}
function displaySortArr(sortArr){
var html ='';
var url ='https://www.google.com/maps/dir/'+sortArr[0].Name;
for(var i =1; i<sortArr.length;i++)
{
html +=' <ul style="margin:10px;"><li><strong>'+sortArr[i].Name+'</strong></li><li>'+sortArr[i].Address+'</li><li>'+sortArr[i].State+'</li><li>'+sortArr[i].Zip+'</li></ul>';
url +='/'+sortArr[i].Address+','+sortArr[i].State;
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

<?php $this->load->view('global/footer'); ?>