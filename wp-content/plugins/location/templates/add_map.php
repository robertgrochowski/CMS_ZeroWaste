<style>
    #map {
        height: 300px;
        width: 100%;
    }
</style>
<div class="dokan-form-group">
    <input id="latitude" name="latitude" type="hidden" value="52.232222" />
    <input id="longitude" name="longitude" type="hidden" value="21.008333" />
</div>
<div id="map"></div>
<script id="map_script" defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgFb65StJaH_YvREznt-NzWfM1JicH0k8&callback=initMap">
</script>

<script id="init_map_script">
        let pos;
        let marker;

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(52.232222, 21.008333),
                zoom: 15
            });
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        map.setCenter(pos);
                    }
                );
            }
            pos = new google.maps.LatLng(parseFloat(document.getElementById("latitude").value),
                parseFloat(document.getElementById("longitude").value));
            marker = new google.maps.Marker({
                position: pos,
                map: map
            })
            google.maps.event.addListener(map, 'click', function(event) {
                move_marker(event.latLng)
            });
        }

        function move_marker(location) {
            marker.setPosition(location);
            document.getElementById("latitude").value = location.lat();
            document.getElementById("longitude").value = location.lng();
        }
</script>
