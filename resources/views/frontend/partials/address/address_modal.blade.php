<!-- New Address Modal -->
<div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
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
                    <div class="row">
                         
                        @if(!empty($address_type))

                            @if($address_type == "personal")
                                <div class="col-6 mt-2">
                                    <label class="btn btn-light w-100">
                                        <input type="radio" class="  rounded-0" name="address_label" id="home_address_label" value="Home" {{   $address_label == "Home" ? 'checked' : '' }} required>
                                        Home
                                    </label>
                                </div>
                            
                                <div class="col-6 mt-2">
                                    <label class="btn btn-light w-100">
                                        <input type="radio" class="  rounded-0" name="address_label" id="office_address_label" value="Office" {{   $address_label == "Office" ? 'checked' : '' }} required>
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

                        <div class="col-6 mt-2">
                            <select class="form-control   rounded-0" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country_id" data-code="92" id="country" required>
                                <option value="">{{ translate('Select your country') }}</option>
                                @foreach (get_active_countries() as $key => $country)
                                    <option value="{{ $country->id }}" data-code="{{ $country->code }}">{{ $country->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-6 mt-2">
                            <select class="form-control   rounded-0" data-live-search="true" name="state_id" id="state" required>
                                <option value="">{{ translate('Select Country First') }}</option>
                            </select>
                        </div>

                        <!-- City -->
                        <div class="col-6 mt-2">
                            <select class="form-control  rounded-0" data-live-search="true" name="city_id" id="city" required>
                                <option value="">{{ translate('Select State First') }}</option>
                            </select>
                        </div>
                        <!-- City -->
                        <div class="col-6 mt-2">
                            <input type="text" class="form-control  rounded-0" placeholder="{{ translate('Area')}}" name="area" id="area" value="" required>
                        </div>
                        <!-- City -->
                        <div class="col-12 mt-2">
                            <input type="text" class="form-control  rounded-0" placeholder="{{ translate('Nearest Landmark')}}" name="landmark" id="land_mark" value="" required>
                        </div>

                        <div class="col-12 mt-2">
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
                                
                            </div>
                        @endif
                        <!-- Save button -->
                        <div class="form-group text-right mt-2">
                            <button type="submit" class="btn btn-primary rounded-2 w-100">{{translate('Save')}}</button>
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
