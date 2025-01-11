<!-- New Address Modal -->
<div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body c-scrollbar-light">
                    <div class="p-3">
                        <!-- Name -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('First Name')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" placeholder="{{ translate('First Name')}}" name="name" required>
                            </div>
                        </div>
                        
                        <!-- Last Name -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Last Name')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" placeholder="{{ translate('Last Name')}}" name="last_name" required>
                            </div>
                        </div>
                        
                        <!-- Country -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Country')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control aiz-selectpicker rounded-0" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country_id" id="country" required>
                                        <option value="">{{ translate('Select your country') }}</option>
                                        @foreach (get_active_countries() as $key => $country)
                                        <option value="{{ $country->id }}" data-code="{{ $country->code }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- State -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('State')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="state_id" id="state" required>
                                </select>
                            </div>
                        </div>
                        <!-- City -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('City')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="city_id" id="city" required>
                                </select>
                            </div>
                        </div>
                        <!-- City -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Area')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true"  id="area" required>
                                     <option value="">Select Area</option>
                                      <option value="Model Town">Model Town</option>
                                      <option value="Gulberg">Gulberg</option>
                                      <option value="DHA Phase 1">DHA Phase 1</option>
                                      <option value="DHA Phase 2">DHA Phase 2</option>
                                      <option value="DHA Phase 3">DHA Phase 3</option>
                                      <option value="DHA Phase 4">DHA Phase 4</option>
                                      <option value="DHA Phase 5">DHA Phase 5</option>
                                      <option value="DHA Phase 6">DHA Phase 6</option>
                                      <option value="Johar Town Phase 1">Johar Town Phase 1</option>
                                      <option value="Johar Town Phase 2">Johar Town Phase 2</option>
                                      <option value="Bahria Town Sector A">Bahria Town Sector A</option>
                                      <option value="Bahria Town Sector B">Bahria Town Sector B</option>
                                      <option value="Bahria Town Sector C">Bahria Town Sector C</option>
                                      <option value="Bahria Town Sector D">Bahria Town Sector D</option>
                                      <option value="Bahria Orchard">Bahria Orchard</option>
                                      <option value="Cantt">Cantt</option>
                                      <option value="Garden Town">Garden Town</option>
                                      <option value="Shadman">Shadman</option>
                                      <option value="Shadbagh">Shadbagh</option>
                                      <option value="Iqbal Town">Iqbal Town</option>
                                      <option value="Allama Iqbal Town">Allama Iqbal Town</option>
                                      <option value="Samanabad">Samanabad</option>
                                      <option value="Wapda Town">Wapda Town</option>
                                      <option value="Faisal Town">Faisal Town</option>
                                      <option value="Township">Township</option>
                                      <option value="Valencia Town">Valencia Town</option>
                                      <option value="Askari 10">Askari 10</option>
                                      <option value="Askari 11">Askari 11</option>
                                      <option value="Paragon City">Paragon City</option>
                                      <option value="Punjab Housing Society">Punjab Housing Society</option>
                                      <option value="Sabzazar">Sabzazar</option>
                                      <option value="Green Town">Green Town</option>
                                      <option value="Muslim Town">Muslim Town</option>
                                      <option value="Mughalpura">Mughalpura</option>
                                      <option value="Shalimar Town">Shalimar Town</option>
                                      <option value="Badami Bagh">Badami Bagh</option>
                                      <option value="Harbanspura">Harbanspura</option>
                                      <option value="Ichhra">Ichhra</option>
                                      <option value="Chungi Amar Sidhu">Chungi Amar Sidhu</option>
                                      <option value="Ravi Road">Ravi Road</option>
                                      <option value="Mall Road">Mall Road</option>
                                      <option value="Defence Road">Defence Road</option>
                                      <option value="Kot Lakhpat">Kot Lakhpat</option>
                                      <option value="Nishtar Colony">Nishtar Colony</option>
                                      <option value="Ghazi Road">Ghazi Road</option>
                                      <option value="Mian Mir Colony">Mian Mir Colony</option>
                                      <option value="Walton Road">Walton Road</option>
                                      <option value="Sundar Industrial Estate">Sundar Industrial Estate</option>
                                      <option value="Gulshan-e-Ravi">Gulshan-e-Ravi</option>
                                      <option value="Barki Road">Barki Road</option>
                                      <option value="Batapur">Batapur</option>
                                      <option value="Kala Shah Kaku">Kala Shah Kaku</option>
                                      <option value="Baghbanpura">Baghbanpura</option>
                                      <option value="Chuhng">Chuhng</option>
                                      <option value="Jallo">Jallo</option>
                                      <option value="Mohlanwal">Mohlanwal</option>
                                      <option value="EME Society">EME Society</option>
                                      <option value="Izmir Town">Izmir Town</option>
                                      <option value="LDA Avenue">LDA Avenue</option>
                                      <option value="Eden Villas">Eden Villas</option>
                                      <option value="Pak Arab Housing Society">Pak Arab Housing Society</option>
                                      <option value="Al Rehman Garden">Al Rehman Garden</option>
                                      <option value="Al Jalil Garden">Al Jalil Garden</option>
                                      <option value="Shahdara">Shahdara</option>
                                      <option value="Kot Abdul Malik">Kot Abdul Malik</option>
                                      <option value="Dharampura">Dharampura</option>
                                      <option value="China Scheme">China Scheme</option>
                                      <option value="Kala Khatai Road">Kala Khatai Road</option>
                                </select>
                                
  
                            </div>
                        </div>
                        
                         <!-- Land Mark -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Land Mark')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" placeholder="{{ translate('Famous Land Mark')}}" name="land_mark" id="land_mark" required>
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Address')}}</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control mb-3 rounded-0" placeholder="{{ translate('Your Address')}}" rows="2" name="address" id="address" required></textarea>
                            </div>
                        </div>
                        
                       
                        
                        <!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>-->
                        <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY_Bt6pCs8YpFdWLQ0PMejTJBKXkbo0UU" async defer></script>-->
                        @if (get_setting('google_map') == 1)
                        <!-- Google Map -->
                        <div class="row mt-3 mb-3">
                            <input id="searchInput" class="controls" type="text" placeholder="{{ translate('Enter a location') }}">
                            <div id="map" style="height: 400px; width: 100%;"></div>
                            <ul id="geoData">
                                <li style="display: none;">Full Address: <span id="location"></span></li>
                                <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                                <li style="display: none;">Country: <span id="country"></span></li>
                                <li style="display: none;">Latitude: <span id="lat"></span></li>
                                <li style="display: none;">Longitude: <span id="lon"></span></li>
                            </ul>
                        </div>
                        <!-- Longitude -->
                        <div class="row">
                            <div class="col-md-2">
                                <label for="longitude">{{ translate('Longitude') }}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" id="longitude" name="longitude" readonly="">
                            </div>
                        </div>
                        <!-- Latitude -->
                        <div class="row">
                            <div class="col-md-2">
                                <label for="latitude">{{ translate('Latitude') }}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" id="latitude" name="latitude" readonly="">
                            </div>
                        </div>
                        @endif

                        <!-- Postal code -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Postal code')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" placeholder="{{ translate('Your Postal Code')}}" name="postal_code" value="" required>
                            </div>
                        </div>
                        <!-- Phone -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Phone')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" placeholder="{{ translate('+')}}" name="phone" value="" required>
                            </div>
                        </div>
                        <!-- Save button -->
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary rounded-0 w-150px">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Address Modal -->
<div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body c-scrollbar-light" id="edit_modal_body">
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
    function add_new_address() {
        $('#new-address-modal').modal('show');
    }

    function edit_address(address) {
        var url = '{{ route("addresses.edit", ":id") }}';
        url = url.replace(':id', address);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'GET',
            success: function(response) {
                $('#edit_modal_body').html(response.html);
                $('#edit-address-modal').modal('show');
                AIZ.plugins.bootstrapSelect('refresh');
                @if(get_setting('google_map') == 1)
                var lat = -33.8688;
                var long = 151.2195;
                if (response.data.address_data.latitude && response.data.address_data.longitude) {
                    lat = parseFloat(response.data.address_data.latitude);
                    long = parseFloat(response.data.address_data.longitude);
                }
                initialize(lat, long, 'edit_');
                @endif
            }
        });
    }

    $(document).on('change', '[name=country_id]', function() {
        var country_id = $(this).val();
        get_states(country_id);
        
        var countryCode = $(this).find(':selected').data('code');

        $.ajax({
            url: `https://restcountries.com/v3.1/alpha/${countryCode}`,
            method: 'GET',
            success: function(response) {
                if (response && response[0] && response[0].idd && response[0].idd.root) {
                    // Extract the calling code, which may have root and suffixes
                    const rootCode = response[0].idd.root; // e.g., "+92"
                    const suffixCode = (response[0].idd.suffixes && response[0].idd.suffixes[0]) || "";
                    const fullCode = rootCode + suffixCode;
    
                    // Set the placeholder with the calling code
                    $('[name="phone"]').attr('value', fullCode);
                }
            },
            error: function() {
                console.error('Could not retrieve country calling code');
                $('[name="phone"]').attr('placeholder', ''); // Reset if API fails
            }
        });
    });
    
    $(document).on('change', '[name=state_id]', function() {
        var state_id = $(this).val();
        get_city(state_id);
    });

    function get_states(country_id) {
        $('[name="state"]').html("");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get-state')}}",
            type: 'POST',
            data: {
                country_id: country_id
            },
            success: function(response) {
                var obj = JSON.parse(response);
                if (obj != '') {
                    $('[name="state_id"]').html(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            }
        });
    }

    function get_city(state_id) {
        $('[name="city"]').html("");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get-city')}}",
            type: 'POST',
            data: {
                state_id: state_id
            },
            success: function(response) {
                var obj = JSON.parse(response);
                if (obj != '') {
                    $('[name="city_id"]').html(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            }
        });
    }
</script>
// <script>
//     let map, geocoder, marker;

//     function initMap() {
//         geocoder = new google.maps.Geocoder();
//         map = new google.maps.Map(document.getElementById('map'), {
//             zoom: 12,
//             center: {
//                 lat: 0,
//                 lng: 0
//             }
//         });
//         marker = new google.maps.Marker({
//             map: map
//         });
//         // Add listener for the search input
//         const searchInput = document.getElementById('searchInput');
//         const searchBox = new google.maps.places.SearchBox(searchInput);
//         map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchInput);
//         searchBox.addListener('places_changed', function() {
//             const places = searchBox.getPlaces();
//             if (places.length === 0) return;
//             const place = places[0];
//             const lat = place.geometry.location.lat();
//             const lng = place.geometry.location.lng();
//             // Update map and marker position
//             map.setCenter({
//                 lat,
//                 lng
//             });
//             marker.setPosition({
//                 lat,
//                 lng
//             });
//             // Display place details
//             document.getElementById('location').textContent = place.formatted_address;
//             document.getElementById('latitude').value = lat;
//             document.getElementById('longitude').value = lng;
//             // Retrieve and display additional details
//             geocoder.geocode({
//                 location: {
//                     lat,
//                     lng
//                 }
//             }, function(results, status) {
//                 if (status === 'OK' && results[0]) {
//                     const addressComponents = results[0].address_components;
//                     document.getElementById('postal_code').textContent = getAddressComponent(addressComponents, 'postal_code');
//                     document.getElementById('country').textContent = getAddressComponent(addressComponents, 'country');
//                 }
//             });
//         });
//     }

//     function getAddressComponent(components, type) {
//         const component = components.find(c => c.types.includes(type));
//         return component ? component.long_name : '';
//     }
//     document.addEventListener('DOMContentLoaded', initMap);
// </script>

<script>
    let map, geocoder, marker;
   

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






@if (get_setting('google_map') == 1)
@include('frontend.partials.google_map')
@endif
@endsection