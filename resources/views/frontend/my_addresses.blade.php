@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card shadow-none rounded-0 border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('My Addresses') }}</h5>
        </div>
    <div class="card-body table-responsive">
            <table class="table aiz-table mb-0">
                <thead class="text-gray fs-12">
                    <tr>
                        <th class="pl-0">{{ translate('Sr #')}}</th>
                        <th >{{ translate('Label')}}</th>
                        <th> {{ translate('Type')}}</th>
                        <th> {{ translate('Street / Building')}}</th>
                        <th >{{ translate('Nearest Landmark')}}</th>
                        <th >{{ translate('Area')}}</th>
                        <th >{{ translate('City')}}</th>
                        <th >{{ translate('State')}}</th>
                        <th >{{ translate('Country')}}</th>
                        <th class="text-right pr-0">{{ translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody class="fs-14">
                    @foreach ($addresses as $key => $address)
                        @php
                            $state = \App\Models\State::where("id", $address->state_id)->first();
                            $country = \App\Models\Country::where("id",$address->country_id)->first();
                            $city = \App\Models\City::where('id', $address->city_id)->first();
                        @endphp
                        <tr>
                            <!-- Date -->
                            <td class="text-secondary">
                                {{ $key+1 }}
                            </td>
                            <!-- Amount -->
                            <td >
                                {{ $address->address_label }}
                            </td>
                            <td >
                               <span class="badge badge-success text-uppercase w-auto"> {{ str_replace("_", " ",  $address->address_type) }}</span>
                            </td>
                            <td >
                                {{ $address->address }}
                            </td>
                            <td>
                                {{ $address->landmark }}
                            </td>
                            <td>
                                {{ $address->area }}
                            </td>
                            <!-- Delivery Status -->
                            <td>
                                {{ $city->name }}
                            </td>
                            <!-- Payment Status -->
                            <td>
                                {{ $state->name }}
                            </td>
                            <td>
                                {{ $country->name }}
                            </td>

                            <!-- Options -->
                            <td class="text-right pr-0">
                                <div class="d-flex flex-column flex-sm-row justify-content-end align-items-center">
                                    
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash">
                                        </i>
                                    </button>
                                  
                                </div>
                            </td>

                        </tr>
                        @php 
                            $key++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="aiz-pagination mt-2">
                {{-- {{ $addresses->links() }} --}}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Delete modal -->
    @include('modals.delete_modal')

<!-- Address Modal -->
@include('frontend.partials.address.address_modal')
@endsection

@section('script')
    <script>
            $(document).on('click', '#add_address', function() {
            var country_id = $('[name="country_id"]').val();
            var city_id = $('[name="city_id"]').val();
            var state_id = $('[name="state_id"]').val();
            var latitude = $('[name="latitude"]').val();
            var longitude = $('[name="longitude"]').val();
            var landmark = $('[name="landmark"]').val();
            var address = $('[name="address"]').val();
            var area = $('[name="area"]').val();
            var postal_code = $('[name="postal_code"]').val();
           
            var delivery_type = $('input[name="delivery_type"]:checked').val();
            var address_label = $("#address_label").val()
            var personal_address_label = $('input[name="personal_address_label"]:checked').val();
            $.ajax({
                url: `{{ url('/addresses') }}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    country_id, 
                    city_id,
                    state_id,
                    address,
                    latitude, 
                    longitude, 
                    address_type: delivery_type,
                    address_label,
                    personal_address_label,
                    area,
                    landmark,
                    postal_code
                },
                dataType: 'json', // Ensure response is treated as JSON
                success: function(response) {
                    if (response) {
                        $('#shipping_info').html(response.html);
                        $('#new-address-modal').modal('hide');
                        fetch_payment_actions();
                    } else {
                        console.error('Invalid response format', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error, xhr.responseText);
                }
            });

        });
                
        function delete_address(addressId) {

            var delivery_type = $('input[name="delivery_type"]:checked').val();
            $("#shipping_preloader").show();
            $('#shipping_info').hide();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = `{{ url('/addresses/destroy') }}/${addressId}`; 
                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: 'POST', 
                        data: {
                            address_type: delivery_type
                        },
                        success: function(response) {
                            if (response.success) {
                            
                                    var obj = response;
                                    if (obj != '') {
                                        window.location.reload
                                    }
                            
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message || 'Failed to delete the address. Please try again.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.fire(
                                'Error!',
                                `Failed to delete the address. Please try again. (Status: ${xhr.status})`,
                                'error'
                            );
                        }
                    });
                }
            });
        }
        $(document).on('click', '.delete-address', function(){
            var id = $(this).data('id');

            delete_address(id)
            
            
        });
    </script>
@endsection
