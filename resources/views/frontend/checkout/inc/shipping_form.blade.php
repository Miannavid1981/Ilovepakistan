@if(count($addresses) ==0)
    @php
        $address_type = !empty($address_type) ?  $address_type : 'personal'; 
        $address_label = !empty($address_type) ?  $address_type : 'Home';   
    @endphp

    @if(!empty($address_type))

        @if($address_type == "personal")

            <div class="col-6">
                <label class="btn btn-light w-100">
                    <input type="radio" class="  rounded-0" name="address_label" id="address_label" value="Home" {{   $address_label == "Home" ? 'checked' : '' }} required>
                    Home
                </label>
            </div>
        
            <div class="col-6">
                <label class="btn btn-light w-100">
                    <input type="radio" class="  rounded-0" name="address_label" id="address_label" value="Office" {{   $address_label == "Office" ? 'checked' : '' }} required>
                    Office
                </label>
            </div>
        @endif

        @if($address_type == "family_friends")
{{-- 
            <div class="col-12">
             
                <input type="text" class="form-control  rounded-0 bg-light"  placeholder="{{ translate('Label your Address')}}" name="address_label" id="address_label" placeholder="Label Your Address" >
                    
                
            </div>
         --}}
            
        @endif


    @endif
    
    
    <div class="col-6">
        <select class="form-control   rounded-0" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country_id" data-code="92" id="country" required>
            <option value="">{{ translate('Select your country') }}</option>
            @foreach (get_active_countries() as $key => $country)
                <option value="{{ $country->id }}" data-code="{{ $country->code }}">{{ $country->name }}</option>
            @endforeach
        </select>

    </div>
    <div class="col-6">
        <select class="form-control   rounded-0" data-live-search="true" name="state_id" id="state" required>
            <option value="">{{ translate('Select Country First') }}</option>
        </select>
    </div>

    <!-- City -->
    <div class="col-6">
        <select class="form-control  rounded-0" data-live-search="true" name="city_id" id="city" required>
            <option value="">{{ translate('Select State First') }}</option>
        </select>
    </div>
    <!-- City -->
    <div class="col-6">
        <input type="text" class="form-control  rounded-0" placeholder="{{ translate('Area')}}" name="area" id="area" value="" required>
    </div>
    <!-- City -->
    <div class="col-12">
        <input type="text" class="form-control  rounded-0" placeholder="{{ translate('Nearest Landmark')}}" name="landmark" id="land_mark" value="" required>
    </div>

    <div class="col-12">
        <input type="text" class="form-control  rounded-0" placeholder="{{ translate('Street / Building Address')}}" id="address" name="address" value="" required>
    </div>
    @if (get_setting('google_map') == 1)

            
        <div class="col-6 d-none" id="">
            <input type="text" class="form-control rounded-0" id="longitude" name="longitude" readonly="" placeholder="Latitude">
        </div>
    
        
        <div class="col-6 d-none" id="">
            <input type="text" class="form-control rounded-0" id="latitude" name="latitude" readonly="" placeholder="Longitude">
        </div>
    
        <!-- Google Map -->
        <div class="col-12">
            <input id="searchInput" class="controls" type="text" placeholder="{{translate('Enter a location')}}" style="display: none">
            <div id="map"></div>
            {{-- <ul id="geoData">
                <li style="display: none;">Full Address: <span id="location"></span></li>
                <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                <li style="display: none;">Country: <span id="country"></span></li>
                <li style="display: none;">Latitude: <span id="lat"></span></li>
                <li style="display: none;">Longitude: <span id="lon"></span></li>
            </ul> --}}
        </div>
        <!-- Longitude -->
    
    @endif
    

@else


    <div class="col-12">
        <div class="addresses ">

            @foreach ($addresses as $key => $address)
            {{-- <div class="col-lg-4">
                <div class="border p-3 pr-5 rounded mb-3 position-relative">
                    <div>
                        <span class="w-50 fw-600">{{ translate('Address') }}:</span>
                        <span class="ml-2">{{ $address->address }}</span>
                    </div>
                    <div>
                        <span class="w-50 fw-600">{{ translate('Postal Code') }}:</span>
                        <span class="ml-2">{{ $address->postal_code }}</span>
                    </div>
                    <div>
                        <span class="w-50 fw-600">{{ translate('City') }}:</span>
                        <span class="ml-2">{{ optional($address->city)->name }}</span>
                    </div>
                    <div>
                        <span class="w-50 fw-600">{{ translate('State') }}:</span>
                        <span class="ml-2">{{ optional($address->state)->name }}</span>
                    </div>
                    <div>
                        <span class="w-50 fw-600">{{ translate('Country') }}:</span>
                        <span class="ml-2">{{ optional($address->country)->name }}</span>
                    </div>
                    <div>
                        <span class="w-50 fw-600">{{ translate('Phone') }}:</span>
                        <span class="ml-2">{{ $address->phone }}</span>
                    </div>
                    @if ($address->set_default)
                        <div class="position-absolute right-0 bottom-0 pr-2 pb-3">
                            <span class="badge badge-inline badge-primary">{{ translate('Default') }}</span>
                        </div>
                    @endif
                    <div class="dropdown position-absolute right-0 top-0">
                        <button class="btn bg-gray px-2" type="button" data-toggle="dropdown">
                            <i class="la la-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" onclick="edit_address('{{$address->id}}')">
                                {{ translate('Edit') }}
                            </a>
                            @if (!$address->set_default)
                                <a class="dropdown-item" href="{{ route('seller.addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('seller.addresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="address_item px-3 py-2">
                
                <div class="d-flex gap-2 align-items-center">
                    <div>
                        <input type="radio" name="selected_address_id" value="{{ $address->type }}">
                    </div>
                    <div>
                        <h5 class="mb-0 text-capitalize">{{ $address->type }}</h5>
                        <p class="mb-0">{{ $address->address }}</p>
                        <p class="mb-0">{{ optional($address->city)->name.", ".optional($address->state)->name.", ".optional($address->country)->name }}</p>

                    </div>
                    
                </div>
                <div class="address_action_buttons d-flex justify-content-end">
                    <button class="p-2 text-danger bg-white border-0 fs-16">
                        <i class="fa fa-trash"></i>
                        
                    </button>
                    <button class="p-2 text-dark bg-white border-0 fs-16">
                        <i class="fa fa-pen"></i>
                        
                    </button>
                </div>
            </div>
        @endforeach

        
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-primary" id="new_address_modal">
                Add New Address
            </button>
        </div>
    </div>
    
    @section('modal')
        <!-- Address Modal -->
        @include('frontend.partials.address.address_modal')
    @endsection

@endif


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
@include('frontend.partials.google_map')




    