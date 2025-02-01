@if(count($addresses) ==0)

    
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