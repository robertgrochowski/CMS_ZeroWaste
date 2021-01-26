<script id="map_script" defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgFb65StJaH_YvREznt-NzWfM1JicH0k8&callback=initMap">
</script>

<script id="init_map_script">
    let pos;
    let marker;

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(52.230235863036796, 21.011824142345844),
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
