<script>
    let default_longtitude = '';
    let default_latitude = '';
    @if (get_setting('google_map_longtitude') != '' && get_setting('google_map_longtitude') != '')
        default_longtitude = {{ get_setting('google_map_longtitude') }};
        default_latitude = {{ get_setting('google_map_latitude') }};
    @endif
   // var map = null;
    function initialize(lat = -33.8688, lang = 151.2195, id_format = '') {
        var long = lang;
        var lat = lat;
        if (default_longtitude != '' && default_latitude != '') {
            long = default_longtitude;
            lat = default_latitude;
        }

         map = new google.maps.Map(document.getElementById(id_format + 'map'), {
            center: {
                lat: lat,
                lng: long
            },
            zoom: 13
        });

        var myLatlng = new google.maps.LatLng(lat, long);

        var input = document.getElementById(id_format + 'searchInput');
        //                console.log(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            anchorPoint: new google.maps.Point(0, -29),
            draggable: true,
        });

        map.addListener('click', function(event) {
            marker.setPosition(event.latLng);
            document.getElementById(id_format + 'latitude').value = event.latLng.lat();
            document.getElementById(id_format + 'longitude').value = event.latLng.lng();
            infowindow.setContent('Latitude: ' + event.latLng.lat() + '<br>Longitude: ' + event.latLng.lng());
            infowindow.open(map, marker);
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById(id_format + 'latitude').value = event.latLng.lat();
            document.getElementById(id_format + 'longitude').value = event.latLng.lng();
            infowindow.setContent('Latitude: ' + event.latLng.lat() + '<br>Longitude: ' + event.latLng.lng());
            infowindow.open(map, marker);
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            /*
            marker.setIcon(({
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            */
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);

            //Location details
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'country') {
                    document.getElementById('country').innerHTML = place.address_components[i].long_name;
                }
            }
            document.getElementById('location').innerHTML = place.formatted_address;
            document.getElementById(id_format + 'latitude').value = place.geometry.location.lat();
            document.getElementById(id_format + 'longitude').value = place.geometry.location.lng();
        });

    }
    
    
    
     function placeMarker(location) {
      if (marker) { 
        marker.setMap(null);
      }
      marker = new google.maps.Marker({
        position: location,
        map: map,
      });

      document.getElementById("latitude").value = location.lat().toFixed(6);
      document.getElementById("longitude").value = location.lng().toFixed(6);
    }

    function searchLocation(query, zoom=8) {
       geocoder = new google.maps.Geocoder();
      geocoder.geocode({ address: query }, function (results, status) {
          console.log(results);
        if (status === "OK") {
          map.setCenter(results[0].geometry.location);
          map.setZoom(zoom);
          placeMarker(results[0].geometry.location);
        } else {
          alert("Geocode was not successful for the following reason: " + status);
        }
      });
    }
    function get_full_address() {
        const state = $("#state").val() != "" ? $("#state option:selected").text() : ''; // Default to empty string if null/undefined
        const country = $("#country").val() != "" ? $("#country option:selected").text() : ''; // Ensure this fetches the correct country
        const city = $("#city").val() != "" ? $("#city option:selected").text() : '';
        const area = $("#area option:selected").text() || '';
        const address = $("#address").val() || '';
        const land_mark = $("#land_mark").val() || '';
        
    
        // Construct the full address, filtering out empty values
        const addressParts = [ address,land_mark, area, city, state, country].filter(part => part.trim() !== '');
        console.log(addressParts.join(', '))
            // Join the parts with a comma and return the result
            return addressParts.join(', ');
            
        }
        document.getElementById("country").addEventListener("change", function () {
          
           const fullAddress = get_full_address();
          if (country) searchLocation(fullAddress);
        });
    
        document.getElementById("state").addEventListener("change", function () {
         const fullAddress = get_full_address();
          if (state) searchLocation(fullAddress, 9);
        });
        document.getElementById("city").addEventListener("change", function () {
          const fullAddress = get_full_address();
          if (area) searchLocation(fullAddress, 11);
        });
        document.getElementById("area").addEventListener("change", function () {
          const fullAddress = get_full_address();
          if (area) searchLocation(fullAddress, 14);
        });
        document.getElementById("land_mark").addEventListener("keyup", function () {
          const fullAddress = get_full_address();
          if (address) searchLocation(fullAddress, 16);
        });
        document.getElementById("address").addEventListener("keyup", function () {
          const fullAddress = get_full_address();
          if (address) searchLocation(fullAddress, 18);
        });
</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&language=en&callback=initialize"
    async defer></script>
