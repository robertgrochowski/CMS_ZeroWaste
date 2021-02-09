<div>
    <div id="map"></div>
    <style>
        #map {
            height: 300px;
            width: 100%;
        }
    </style>

    <?php

    global $product;

    $latitude = get_post_meta($product->get_id(), 'latitude', true);
    $longitude = get_post_meta($product->get_id(), 'longitude', true);

    ?>


    <?php if ($latitude != null && $longitude != null): ?>

        <script defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgFb65StJaH_YvREznt-NzWfM1JicH0k8&callback=initMap">
        </script>

    <?php endif ?>

    <?php if (get_post_meta($product->get_id(), 'latitude', true) != null
    && get_post_meta($product->get_id(), 'longitude', true) != null): ?>
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
    <?php endif ?>
</div>
