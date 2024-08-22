<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Approximate IP Location</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 10px 0;
            font-family: Arial;
            font-size: 12px;
        }

        table {
            border-top: 1px solid #ddd;
            border-left: 1px solid #ddd;
        }

        thead {
        }

        tr {
        }

        tr.even {
            background: #F9F9F9;
        }

        td {
            padding: 3px 8px;
            color: #444;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
        }

        thead tr {
            background: #f4f4f4;
        }

        thead td {
            font-weight: bold;
        }

        span.tiptip {
            border-bottom: 1px dashed #25AAE1;
            cursor: pointer;
            position: relative;
        }
    </style>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>3rdparty/tiptip/jquery.tipTip.minified.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>3rdparty/tiptip/tipTip.css" media="all">
    <script src="https://maps.googleapis.com/maps/api/js?v=3&key=<?php echo $_ENV['GOOGLE_API_KEY']; ?>"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            var map;
            var ip = $('#ip').val();
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            var latlng = new google.maps.LatLng(lat, lng);

            function initialize() {
                var mapOptions = {
                    zoom: 12,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    gestureHandling: 'greedy'
                };
                map = new google.maps.Map(document.getElementById('map-canvas'),
                    mapOptions);

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);

        });
    </script>
</head>
<body>

<h3 style="text-align: center;">Please note that IP locations are estimates, and not precise.</h3>


<input type="hidden" id="lat" value="<?php echo $latitude; ?>" />
<input type="hidden" id="lng" value="<?php echo $longitude; ?>" />

<div id="map-canvas" style="height: 450px; width: 750px; margin: auto"></div>
</body>
</html>