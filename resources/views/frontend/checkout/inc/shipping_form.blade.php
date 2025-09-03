@if(count($addresses) ==0)

    <div class="col-12">
        <div class="bg-soft-primary p-2 fs-16 text-primary rounded-2 d-flex align-items-center gap-2" style="font-family: 'Aeonik-Semibold';">
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
