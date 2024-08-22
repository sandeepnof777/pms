<?php $this->load->view('global/header'); ?>

<div id="content" class="clearfix">
    <div class="widthfix">

        <div>
           <table>
               <tr>
                   <td>From:</td>
                   <td><input type="text" id="fromAddress" value="3814 West St Cincinnati OH" /></td>
               </tr>
               <tr>
                   <td>To:</td>
                   <td><input type="text" id="toAddress" value="100 Joe Nuxhall Way Cincinnati OH" /></td>
               </tr>
               <tr>
                   <td>Truck Length (ft):</td>
                   <td><input type="number" id="truckLength" value="30" /></td>
               </tr>
               <tr>
                   <td>Truck Height (ft):</td>
                   <td><input type="number" id="truckHeight" value="5" /></td>
               </tr>
               <tr>
                   <td>Truck Width (ft):</td>
                   <td><input type="number" id="truckWidth" value="3.5" /></td>
               </tr>
               <tr>
                   <td>Truck Weight (lbs):</td>
                   <td><input type="number" id="truckWeight" value="30000" /></td>
               </tr>
               <tr>
                   <td>Truck Axles :</td>
                   <td><input type="number" id="truckAxles" value="3" /></td>
               </tr>
               <tr>
                   <td>Trailers :</td>
                   <td><input type="number" id="truckTrailers" value="2" /></td>
               </tr>
               <tr>
                   <td>Is Semi :</td>
                   <td>
                       <select id="isSemi">
                           <option value="1" selected="selected">Yes</option>
                           <option value="0">No</option>
                       </select>
                   </td>
               </tr>
               <tr>
                   <td>Max Gradient (degrees) :</td>
                   <td><input type="number" id="truckGradient" value="10" /></td>
               </tr>
               <tr>
                   <td>Min TurnRadius (degrees) :</td>
                   <td><input type="number" id="truckMinTurnRadius" value="15"/></td>
               </tr>
               <tr>
                   <td>Avoid Crosswind :</td>
                   <td>
                       <select id="avoidCrosswind">
                           <option value="1">Yes</option>
                           <option value="0" selected="selected">No</option>
                       </select>
                   </td>
               </tr>
               <tr>
                   <td>Avoid GroundingRisk :</td>
                   <td>
                       <select id="avoidGrounding">
                           <option value="1" selected="selected">Yes</option>
                           <option value="0">No</option>
                       </select>
                   </td>
               </tr>
               <tr>
                   <td>Hazardous Materials :</td>
                   <td>
                       <select id="hazmat">
                           <option value="none" selected="selected">None</option>
                           <option value="C">Combustible</option>
                           <option value="Cr">Corrosive</option>
                           <option value="E">Explosive</option>
                           <option value="F">Flammable</option>
                       </select>
                   </td>
               </tr>
               <tr>
                   <td></td>
                   <td><a class="btn blue-button" id="calculateRoute" />Calculate</a> </td>
               </tr>
           </table>

        </div>

        <div id='printoutPanel' style="width: 400px; float: right;"></div>

        <div id='myMap' style="width: 500px; height: 600px; float: left;"></div>

    </div>
</div>

<script type='text/javascript'>
    function loadMapScenario() {

        var map;

        $(document).ready(function() {

            $("#calculateRoute").click(function() {

                if (!map) {
                    map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
                        /* No need to set credentials if already passed in URL */
                        center: new Microsoft.Maps.Location(40.418386, -80.019262),
                        zoom: 16 });
                }

                var height = $("#truckHeight").val();
                var width = $("#truckWidth").val();
                var length = $("#truckLength").val();
                var weight = $("#truckWeight").val();
                var axles = $("#truckAxles").val();
                var trailers = $("#truckTrailers").val();
                var semi = JSON.parse($("#truckTrailers").val());
                var gradient = $("#truckGradient").val();
                var radius = $("#truckMinTurnRadius").val();
                var crosswind = JSON.parse($("#avoidCrosswind").val());
                var grounding = JSON.parse($("#avoidGrounding").val());
                var hazmat = $("#hazmat").val();

                Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
                    var directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);

                    directionsManager.clearAll();
                    directionsManager.clearDisplay();

                    if (wp1) {
                        directionsManager.removeWaypoint(0);
                        directionsManager.removeWaypoint(1);
                    }

                    directionsManager.setRenderOptions({ itineraryContainer: document.getElementById('printoutPanel') });
                    directionsManager.setRequestOptions({
                        routeMode: Microsoft.Maps.Directions.RouteMode.truck,
                        vehicleSpec: {
                            dimensionUnit: 'ft',
                            weightUnit: 'lb',
                            vehicleHeight: height,
                            vehicleWidth: width,
                            vehicleLength: length,
                            vehicleWeight: weight,
                            vehicleAxles: axles,
                            vehicleTrailers: trailers,
                            vehicleSemi: semi,
                            vehicleMaxGradient: gradient,
                            vehicleMinTurnRadius: radius,
                            vehicleAvoidCrossWind: crosswind,
                            vehicleAvoidGroundingRisk: grounding,
                            vehicleHazardousMaterials: hazmat
                        }
                    });
                    var wp1 = new Microsoft.Maps.Directions.Waypoint({
                        address: $("#fromAddress").val(),
                    });
                    var wp2 = new Microsoft.Maps.Directions.Waypoint({
                        address: $("#toAddress").val(),
                    });
                    directionsManager.addWaypoint(wp1);
                    directionsManager.addWaypoint(wp2);
                    directionsManager.calculateDirections();
                });

                return false;
            });



        });




    }
</script>
<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AvhgGCWtyecSauMJHutkPO3pTSrfaj3OPNn5U7qsmHD_tZbgOq_47YDjpR7d1DcN&callback=loadMapScenario' async defer></script>

<?php $this->load->view('global/footer'); ?>