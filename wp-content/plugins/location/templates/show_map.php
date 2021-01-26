<div>
    <div id="map"></div>
    <script defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgFb65StJaH_YvREznt-NzWfM1JicH0k8&callback=initMap">
    </script>

    <style>
        #map {
            height: 300px;
            width: 100%;
        }
    </style>

    <?php

    $latitude = get_post_meta($product->get_id(), 'latitude', true);
    $longitude = get_post_meta($product->get_id(), 'longitude', true);

    ?>

    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(<?php echo $latitude?>,
                    <?php echo $longitude?>),
                zoom: 15
            });

            var point = new google.maps.LatLng(<?php echo $latitude?>,
                <?php echo $longitude?>);

            var marker = new google.maps.Marker({
                map: map,
                position: point
            });
        }
    </script>
</div>
