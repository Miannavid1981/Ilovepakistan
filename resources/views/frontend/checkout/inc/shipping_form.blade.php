@if(count($addresses) ==0)

    <div class="col-12">
        <div class="bg-soft-primary p-2 fs-16 text-primary rounded-2 d-flex align-items-center gap-2">
            <i class="fa fa-warning"></i> Please add a delivery address to continue placing order
        </div>
    </div>

@else


    <div class="col-12">
        <div class="addresses ">

            @foreach ($addresses as $key => $address)

                <label class="address_item px-3 py-2">
                    
                    <div class="d-flex gap-2 align-items-center">
                        <div>
                            <input type="radio" name="selected_address_id" value="{{ $address->id }}">
                        </div>
                        <div>
                            <h5 class="mb-0 text-capitalize">{{ $address->address_label }}</h5>
                            <p class="mb-0">{{ $address->address }},</p>
                            <p class="mb-0"> Near {{ $address->landmark ?? '' }}, {{$address->area ?? '' }} </p>
                            <p class="mb-0">{{ optional($address->city)->name.", ".optional($address->state)->name.", ".optional($address->country)->name }}</p>
                            <p class="mb-0">{{ $address->postal_code}} </p>
                        </div>
                        
                    </div>
                    <div class="address_action_buttons d-flex justify-content-end">
                        <button data-id="{{ $address->id }}" type="button" class="delete-address p-2 text-danger bg-white border-0 fs-16">
                            <i class="fa fa-trash"></i>
                            
                        </button>
                        {{-- <button type="button" class="p-2 text-dark bg-white border-0 fs-16">
                            <i class="fa fa-pen"></i>
                            
                        </button> --}}
                    </div>
                </label>
            @endforeach
        
        </div>
        
    </div>
    
    

@endif

<script>
   
   

    function initMap() {
        // Initialize the Geocoder
        geocoder = new google.maps.Geocoder();

        // Default location for map center (Lahore, Pakistan) in case geolocation is denied
        const defaultCenter = { lat: 31.5497, lng: 74.3436 };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: defaultCenter,
        });

        // Initialize a marker at the default location
        marker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
        });

        // Try to access the user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    console.log("User's current location:", currentLocation);

                    // Update map center and marker position to user's location
                    map.setCenter(currentLocation);
                    marker.setPosition(currentLocation);
                    updateLocationDetails(currentLocation);
                },
                function(error) {
                    console.warn("Geolocation permission denied or unavailable. Using default location.");
                    updateLocationDetails(defaultCenter); // Use default location if access is denied
                },
                { timeout: 10000 } // Timeout after 10 seconds if no response
            );
        } else {
            console.warn("Geolocation not supported by this browser. Using default location.");
            updateLocationDetails(defaultCenter);
        }

        // Set up search box for user-entered location
        setupSearchBox();
    }

    function setupSearchBox() {
        const searchInput = document.getElementById('searchInput');
        const searchBox = new google.maps.places.SearchBox(searchInput);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchInput);

        // Listen for search box location selection
        searchBox.addListener('places_changed', function() {
            const places = searchBox.getPlaces();
            if (places.length === 0) return;

            const place = places[0];
            if (!place.geometry) {
                console.warn("Selected place has no geometry data.");
                return;
            }
            const latLng = place.geometry.location;
            console.log("Selected place location:", latLng.toJSON());

            // Update map and marker to the searched place
            map.setCenter(latLng);
            marker.setPosition(latLng);
            updateLocationDetails({
                lat: latLng.lat(),
                lng: latLng.lng()
            }, place);
        });
    }

    function updateLocationDetails(location, place = null) {
        // Update HTML elements with location data
        if (place && place.formatted_address) {
            document.getElementById('location').textContent = place.formatted_address;
        }
        document.getElementById('lat').textContent = location.lat;
        document.getElementById('lon').textContent = location.lng;

        // Geocode location to get additional details
        geocoder.geocode({ location: { lat: location.lat, lng: location.lng } }, function(results, status) {
            if (status === 'OK' && results[0]) {
                const addressComponents = results[0].address_components || [];
                document.getElementById('postal_code').textContent = getAddressComponent(addressComponents, 'postal_code');
                document.getElementById('country').textContent = getAddressComponent(addressComponents, 'country');
                console.log("Geocoded address components:", addressComponents);
            } else {
                console.warn("Geocode failed due to:", status);
            }
        });
    }

    // Utility function to get specific address components by type
    function getAddressComponent(components, type) {
        const component = components.find(c => c.types && c.types.includes(type));
        return component ? component.long_name : '';
    }

    // Ensure initMap is globally available
    window.initMap = initMap;
    
</script>





    
<script>
 
    @if (get_setting('google_map_longtitude') != '' && get_setting('google_map_longtitude') != '')
        default_longtitude = {{ 69.3451 ?? get_setting('google_map_longtitude') }};
        default_latitude = {{ 30.3753 ?? get_setting('google_map_latitude') }};
    @endif
    function initialize(lat = 30.3753, lang =69.3451, id_format = '') {
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
            zoom: 5
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
                //  alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
    function get_full_address() {
        const state = $("#state").val() != "" ? $("#state option:selected").text() : ''; // Default to empty string if null/undefined
        const country = $("#country").val() != "" ? $("#country option:selected").text() : ''; // Ensure this fetches the correct country
        const city = $("#city").val() != "" ? $("#city option:selected").text() : '';
        const area = $("#area").val() || '';
        const address = $("#address").val() || '';
        const land_mark = $("#land_mark").val() ?  'Near '+ $("#land_mark").val() : '';
        const addressParts = [ address,land_mark, area, city, state, country].filter(part => part.trim() !== '');
        return addressParts.join(', ');
    }


    $(document).on("change", "#country", function () { 
        const fullAddress = get_full_address();
        if (country) searchLocation(fullAddress);
    });

    $(document).on("change", "#state", function () {
        const fullAddress = get_full_address();
        if (state) searchLocation(fullAddress, 9);
    });

    $(document).on("change", "#city", function () {
        const fullAddress = get_full_address();
        if (area) searchLocation(fullAddress, 11);
    });

    $(document).on("change", "#area", function () {
        const fullAddress = get_full_address();
        if (area) searchLocation(fullAddress, 14);
    });

    $(document).on("change", "#land_mark", function () {
        const fullAddress = get_full_address();
        if (address) searchLocation(fullAddress, 16);
    });

    $(document).on("change", "#address", function () {
        const fullAddress = get_full_address();
        if (address) searchLocation(fullAddress, 18);
    });

    
   

   
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&language=en&callback=initialize"
    async defer></script>