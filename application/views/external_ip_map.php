<?php $this->load->view('global/header-global'); ?>
<style type="text/css">
    #signup {
        width: 1000px;
    }

    .pricing label span {
        color: #000;
    }

    .pricing {
        font-size: 14px;
    }

    #step5 .selector {
        width: 53px;
    }

    #mCC .selector span {
        width: 23px;
    }

    #mCC span {

        width: 60px;
    }

    #mEcheck .selector span {
        width: 60px;
    }

    #mEcheck .selector {
        width: 100px;
    }

    .billingState .selector {
        width: 200px !important;
    }

    .billingState .selector  span {
        width: 140px;
    }

    #wheel {
        width: 300px;
        font-weight: bold;
        font-size: 14px;
    }

    #seatsPrice {
        font-weight: bold;
        font-size: 14px;
    }

    .pricing label {
        width: 88%;

    }

    #seatsNum {
        font-weight: bold;
        color: #444444;
    }

    .pricing > span {
        font-weight: bold;
    }

    .pricing {
        line-height: 28px;
        width: 100% !important;
        text-align: left;
    }

    #totalPrice {
        width: 300px;
        font-weight: bold;
        font-size: 14px;
    }

    .part {
        width: 110px;
        float: left;
        line-height: 28px;
    }

    #ccInfo {
        width: 50%;
        float: right;
    }

    #ccName {
        width: 265px;
    }
</style>


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
                    mapTypeId: google.maps.MapTypeId.ROADMAP
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
<div style="padding: 20px 0 0;">
    <div id="signup">
        <div class="content-box">
            <div class="box-header">
                <h4>Map <a href="<?php echo site_url('/'); ?>" id="logo" title="Go back to <?php echo SITE_NAME; ?>" style="float: right;"></a></h4>
            </div>
            <div class="box-content" style="    min-height: 550px;">
            <p style="font-size: 16px;padding: 10px;text-align: center;">Please note that IP locations are estimates, and not precise.</p>

            <input type="hidden" id="ip" value="<?php echo $gp->ip; ?>" />
            <input type="hidden" id="lat" value="<?php echo $gp->latitude; ?>" />
            <input type="hidden" id="lng" value="<?php echo $gp->longitude; ?>" />

                <div id="map-canvas" style="height: 500px; width: 95%; margin: auto"></div>
            </div>
        </div>
    </div>
</div>


<!--#content-->
<?php $this->load->view('global/footer-global'); ?>