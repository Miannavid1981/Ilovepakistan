@extends('frontend.layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer"
/>
<script>
     let map, geocoder, marker;
     let default_longtitude = '';
     let default_latitude = '';
</script>
<style>
    header, footer {
        display: none !important;
    }
    body {
        background: linear-gradient(to right, #fff 70%, #f5f5f5 0%) !important
    }
    .front-header-search {
        display: none !important
    }
    .container {
        max-width: 1350px !important;
    }
    .checkout-container {
         background-color: white;
         border-radius: 8px;
         padding: 20px;

         width: 90%;
         max-width: 1200px;
         display: grid;
         grid-template-columns: 1.1fr 1fr;
         grid-template-rows: auto 1fr;
         gap: 20px;
         margin: 20px auto;
         align-items: start;
         height: 100vh;
         
     }

     .checkout-header {
         grid-column: 1 / -1;
         text-align: center;
         padding: 10px 0;
     }

     .checkout-header h1 {
         font-size: 2rem;
         color: #000 !important;
     }

     .summary-section {
         background-color: #f5f5f5;
         border-radius: 8px;
         padding: 20px;
         height: 100%;
     }

     .payment-section {
        padding: 20px;
        position: sticky;
        top: 15px;  /* Stick 15px from the top */
        z-index: 1000;
        background-color: white;
        /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
        /* Only position: sticky is required */
        height: 100%;
    }

     .payment-section h3 {
         margin-bottom: 20px;
         font-size: 1.5em;
     }

     .payment-method {
         display: flex;
         gap: 10px;
         margin-bottom: 20px;
     }

     .payment-method button {
         display: flex;
         align-items: center;
         gap: 10px;
         padding: 10px 10px 10px 28px;
         border: 1px solid #ddd;
         border-radius: 4px;
         position: relative;
         background-color: white;
         transition: background-color 0.3s;
         cursor: pointer;
     }

     .payment-method button.selected {
         background-color: var(--primary);
         color: white;
     }

     .payment-method button .tick {
         display: none;
         position: absolute;
         left: 10px;
         font-size: 18px;
         color: white;
         font-weight: bold;
     }

     .payment-method button.selected .tick {
         display: block;
     }

     .payment-method button img {
         width: 18px;
         height: 18px;
     }

     .continue-button {
         width: 100%;
         padding: 10px;
         background-color: var(--primary);
         color: white;
         font-size: 1em;
         border: none;
         border-radius: 4px;
         margin-top: 10px;
         margin-bottom: 20px;
         cursor: pointer;
     }

     .order-summary {
         flex: 1;
         padding: 20px;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         border: 1px solid #e4e4e4;
     }

     .order-summary .summary-details p {
         display: flex;
         justify-content: space-between;
         margin: 10px 0;
     }

     .summary-cart {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-top: 30px;
}

     .cart-item {
         display: flex;
         align-items: center;
         position: relative;
         gap: 15px;
         padding: 0;
         /* background-color: #f9f9f9; */
         border-radius: 8px;
         /* border: 1px solid #e4e4e4; */
     }
     .cart-item img {
        width: 62px;
        height: 60px;
        border-radius: 2px;
        aspect-ratio: 1/1;
        object-fit: contain;
        background: transparent;
        border: 2px solid #dedede;
        max-width: 62px;
        max-height: 60px;
        height: 100%;
        min-height: 60px;
        padding: 5px;
    }
     .cart-item-info {
         flex: 1;
     }

     .cart-item-info h4 {
         margin: 0;
         font-size: 1.1rem;
         font-weight: bold;
         color: #333;
     }

     .cart-item-info p {
         margin: 5px 0;
         font-size: 0.9rem;
         color: #555;
     }

     .cart-item-info span {
         font-weight: bold;
     }

     .price {
         font-size: 1.1rem;
         font-weight: 300;
         color: #000;
     }

     .quantity-circle {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        font-size: 1rem;
        font-weight: bold;
        margin-top: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: absolute;
        right: -10px;
        /* bottom: 97px; */
        top: -20px;
    }

     /* Popup Form Styles */
     .popup {
         display: none;
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(0, 0, 0, 0.5);
         justify-content: center;
         align-items: center;
         z-index: 1001;
     }

     .popup-form {
         background-color: white;
         padding: 20px;
         border-radius: 8px;
         width: 400px;
     }

     .popup-form input {
         width: 100%;
         padding: 10px;
         margin-bottom: 10px;
         border-radius: 4px;
         border: 1px solid #ddd;
     }

     .popup-form button {
         width: 100%;
         padding: 10px;
         background-color: #004d40;
         color: white;
         font-size: 1em;
         border: none;
         border-radius: 4px;
         cursor: pointer;
     }

     .popup-close {
         position: absolute;
         top: 10px;
         right: 10px;
         font-size: 1.5em;
         color: #aaa;
         cursor: pointer;
     }

     .edit-icon {
         cursor: pointer;
         font-size: 1.2em;
         color: #004d40;
     }

     .saved-payment-info {
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 15px;
         background-color: #f9f9f9;
         border-radius: 8px;
         margin-bottom: 20px;
         border: 1px solid #e4e4e4;
     }

     .saved-payment-info p {
         margin: 0;
         font-size: 1rem;
         color: #333;
     }

     .delete-icon {
         cursor: pointer;
         font-size: 16px;
         color: #e74c3c;
     }

     .edit-icon {
         cursor: pointer;
         font-size: 16px;
         color: #004d40;
     }
     .payment_method_box {
        position: relative;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 7px;
        transition: all .3s ease-in-out;
     }
     .payment_method_box:has( input:checked) {
        background: #dbdbdb;
        color: #000 !important;
        border: 1px solid #dbdbdb;
        transition: all .3s ease-in-out;
     } 
     /* .payment_method_box input {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 999;
        width: 100%;
        height: 100%;
        opacity: 0;
     } */
.addresses {
    border-top: 1px solid #dedede;
    border-right: 1px solid #dedede;
    border-left: 1px solid #dedede;

}
.address_item {
    border-bottom: 1px solid #dedede;
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 20px;
    margin-bottom: 0;

}

@media (min-width: 768px) {
    .checkout_columns {
        padding: 0 40px !important;
        padding-top: 40px !important;
    }
}

.form-control {
    padding: 0.6rem 1rem;
    font-size: 1rem;
    height: calc(1.3125rem + 1.2rem + 2px);

    color: #333;
    /* padding: 20px !important; */
   
    border: 1px solid #dedede;
    border-radius: 0 !important;
    font-weight: 300  !important;
}
.form-control::placeholder {
    color: #898b92;
}
.form-control:not(textarea){
    height: 3.1rem !important;
}
.horizontal_line {
    display: flex;
    width: 100%;
    margin: 30px 0;
    align-items: center;
    justify-content: center;
    
}

.horizontal_line .line_text {
    position: absolute;
    background: #fff;
    padding: 0 20px;
    font-size: 15px;
    font-weight: 300;

}
.horizontal_line .line_bar {
    border-bottom: 2px solid #dedede;
    width: 100%;
}
.delivery_type {

    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap:5px;
    cursor: pointer;
    
}
.delivery_type input {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 999

}
.delivery_type:has(input:checked){
    /* background: #000;
    color: #fff */

    transform: scale(1.1) ;
    border: 1px solid #000;
    
}

.address_item:has(input:checked){
    border: 1px solid #000
}

.delivery_type_radio:has(input:checked){
    background: var(--primary);
    color: #fff
}
</style>
@php
    $auth_user_id = auth()->user()->id;
    $logo_url = uploaded_asset(get_setting('header_logo'));

    $cart = \App\Models\Cart::where('user_id', $auth_user_id)->get();
    $subtotal = 0;

    $user = auth()->user();
    $addresses = \App\Models\Address::where('user_id', $user->id)->where('address_type', 'personal')->get();  

    // dd($cart);
@endphp
<form action="{{ route('payment.checkout') }}" class="form-default m-0" role="form" method="POST" id="checkout-form" style="background: linear-gradient(to right, #fff 70%, #f5f5f5 0%);">
    @csrf
    <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">
    
    {{-- <input type="hidden" name="address_type" value="" id="address_type"> --}}
    

    <div class="container p-0 h-100" id="checkout_container" style=" height: 100vh">
        <!-- Header -->
        <div class="h-100" style="display: grid; grid-template-columns: minmax( min-content, calc(50% + calc( calc( 66rem - 52rem ) / 2 )) ) 1fr;">
            <div class="checkout_columns mb-4">
                <div class="">
                    <a href="{{  url('/') }}">
                        <img src="{{ $logo_url }}" style="width: 130px" alt="Bighouz" class="img-fluid">
                        <ul class="d-flex gap-2 list-unstyled fs-15 text-muted">
                            <li>Home</li>
                            <li><i class="fa fa-chevron-right"></i></li>
                            <li>Checkout</li>
                        </ul>
                    </a>
                    
                
                </div>
            
                <br>
                
                <div class="row g-3">
                    @php
                        $delivery_type_settings = \App\Models\DeliveryTypesSetting::first();

                        

                    @endphp

                    @if($delivery_type_settings)
                        @if($delivery_type_settings->personal)
                            <div class="col-4 m-0">
                                <div class=" py-2 w-100 delivery_type fs-16 btn-success">
                                    <input type="radio" class="form-check "  name="delivery_type" value="personal" checked>
                                        <i class="fa fa-home"></i>
                                        Personal
                                </div>
                            </div>
                        @endif
                        @if($delivery_type_settings->family_friends)
                            <div class="col-4 m-0">
                                <div class=" py-2 w-100 delivery_type fs-16 btn-warning">
                                    <input type="radio" class="form-check " name="delivery_type" value="family_friends" >
                                        <i class="fa fa-users"></i>
                                        Family & Friends
                                </div>
                            </div>
                        @endif
                        @if($delivery_type_settings->others)
                            <div class="col-4 m-0">
                                <div class=" py-2 w-100 delivery_type fs-16 btn-info">
                                    <input type="radio" class="form-check " name="delivery_type" value="others" >
                                        <i class="fa fa-box"></i>
                                        Others
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                
                {{-- <div class="horizontal_line" style="">
                    <div class="line_bar"> 
                    </div>
                    <div class="line_text">
                        OR
                    </div>
                </div> --}}

                @php
                    $fullname = auth()->user()->name;
                    $fullname = explode(" ", $fullname);

                    $firstname = $fullname[0] ?? "";
                    $lastname = $fullname[1] ?? "";
                @endphp
                
                <h5 class=" mt-4">Delivery Contact</h5>
                <p class="text-muted">This information will be used for contacting you while delivery as a courier.
                </p>
                <div class="row g-3" >
                    <div class="col-6">
                        
                        <input class="form-control " type="text" placeholder="First Name" name="first_name"  value="{{ $firstname }}" autocomplete="off" required>

                    </div>
                    <div class="col-6">
                        
                        <input class="form-control " type="text" placeholder="Last Name" name="last_name" value="{{ $lastname }}" autocomplete="off" required>
                    </div>
                
                    <div class="col-12">
                        
                        <input class="form-control " type="text" name="company_name" placeholder="Company Name (Optional)" autocomplete="off">

                    </div>
                    <div class="col-12">
                        
                        <input class="form-control " id="phone" type="text" maxlength="11" placeholder="03XXXXXXXXX" name="phone" value="{{  auth()->user()->phone }}" autocomplete="off" required>
                    </div>
                </div>
                <h5 class=" mt-4">Shipping Information</h5>
                <p class="text-muted">Please make sure your address is correct so as to reach you exactly the place.
                </p>
                <div id="shipping_preloader" class="align-items-center justify-content-center" style="display: none">
                    <img src="https://uploads.toptal.io/blog/image/122385/toptal-blog-image-1489082610696-459e0ba886e0ae4841753d626ff6ae0f.gif" style="width: 50px;height: auto;">
                </div>
                
                <div class="row g-3" id="shipping_info">
                    @include('frontend.checkout.inc.shipping_form')
                </div>

                <div class="col-12">
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
                <h5 class="mt-4">Payment Method</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        @include('frontend.checkout.inc.payment_methods')
                    </div>
                    <div class="col-12">
                        <textarea class="form-control" name="order_note" rows="3" placeholder="Order Note"></textarea>
                    </div>
                </div>
                
               

            
                <!-- Return to shop -->
               
                <div id="place_order_buttons">
                    @include('frontend.checkout.inc.place_order')
                </div>
                
            

            </div>

            <!-- Summary Section -->
            <div class="checkout_columns" style="background: #f5f5f5; border-left: 1px solid #DEDEDE;">
                <div style="position: sticky; top: 20px;">
                    <br>
                    <div class="d-flex  align-items-center">
                        <a class="px-3 py-2 bg-primary mb-0 text-white rounded-2" onclick="window.history.go(-1)" style="cursor: pointer">
                            <i class="fa fa-chevron-left fs-17 mb-0">
                            </i>
                        </a>
                        <h4 class="mb-0 ms-3">Your Purchase</h4>
                    </div>
                    <div class="summary-cart">
                        @if ($cart && $cart->count() > 0)
                            @foreach ($cart as $key => $item  )

                                @php
                                    $qty = $item->quantity;
                                    $product = \App\Models\Product::find($item->product_id);

                                    $original_skin_code = $item->skin_code ;
                                    $seller = false;
                                    $product_seller_map = false;
                                    if($original_skin_code){
                                        
                                        $product_seller_map = \App\Models\ProductSellerMap::where('original_skin', $original_skin_code )->first();
                                        //dd($product_seller_map->getAttributes());
                                        $seller = \App\Models\User::where("id", $product_seller_map->seller_id)->first();

                                    }
                                
                                @endphp

                                <div class="cart-item">
                                    <div class="position-relative"> 
                                        <img src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="Levis Men Jeans" style="">
                                        <div class="quantity-circle">{{ $qty }}</div>

                                    </div>
                                
                                    
                                    <div class="cart-item-info">
                                        <small class="mb-0 fs-13 text-dark fw-500">{{  $seller ? $seller->name : "-" }}</small>
                                        <p class="m-0 fs-17 fw-300 text-dark">{{  $product->name }}</p>
                                        <small class="mb-0 fs-13 text-muted">SKIN: {{  $product_seller_map ? $product_seller_map->encrypted_hash : "-" }}</small>
                                        
                                        
                                        
                                    </div>
                                    @if (discount_in_percentage($product) > 0)

                                        <div class="price text-muted" style="text-decoration: line-through">{{ home_base_price($product) }}</div>
                                        <div class="price">{{ home_discounted_base_price($product) }}</div>
                                        
                                    @else 
                                        <div class="price">{{ home_base_price($product) }}</div>
                                    @endif
                                    
                                </div>
                                
                            @endforeach
                        @endif


                        
                    </div>
                    <hr>
                    <div id="cart_summary">

                    
                        @include('frontend.partials.cart_summary')
                    </div>
                </div>
            </div>




        </div>



    </div>
</form>

@endsection
@php
    
    $session_country  = 'Pakistan';

    $session_country_obj = \App\Models\Country::where('name', $session_country)->first();


@endphp
@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput-jquery.min.js" integrity="sha512-QK4ymL3xaaWUlgFpAuxY+6xax7QuxPB3Ii/99nykNP/PlK3NTQa/f/UbQQnWsM4h5yjQoMjWUhCJbYgWamtL6g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Place this in your HTML before running your JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

    <script type="text/javascript">
   
    $(document).ready(function() {

        $('.select2').select2({
            minimumResultsForSearch: 0 // Always enable search
        });
        var country_code = '{{ $session_country_obj ? $session_country_obj->code : 'PK' }}';
        var country_id = {{ $session_country_obj ? $session_country_obj->id : 'null' }};

        const input = document.querySelector("#phone");
const fullPhoneInput = document.querySelector("#full_phone");

const iti = window.intlTelInput(input, {
  initialCountry: country_code, // Set your default country
  onlyCountries: ["pk"],
  separateDialCode: true,
  nationalMode: true,
//   placeholderNumberType: "MOBILE",
//   autoPlaceholder: "polite",
  formatOnDisplay: true,
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

// Utility to set placeholder based on country
function setDynamicPlaceholder() {
  const countryData = iti.getSelectedCountryData();
  if (window.intlTelInputUtils && countryData.iso2) {
    const exampleNumber = intlTelInputUtils.getExampleNumber(
      countryData.iso2.toUpperCase(),
      intlTelInputUtils.numberType.MOBILE,
      intlTelInputUtils.numberFormat.NATIONAL
    );
    input.setAttribute("placeholder", exampleNumber);
  }
}

// Utility to get max digits from placeholder
// function getMaxDigitsFromPlaceholder() {
//   return input.placeholder.replace(/\D/g, "").length;
// }

// // Set placeholder initially on page load
// window.addEventListener("load", setDynamicPlaceholder);

// // Update placeholder on country change
// input.addEventListener("countrychange", setDynamicPlaceholder);

// Restrict digits while typing


// On form submit, set hidden field to full international number
document.querySelector("form").addEventListener("submit", function () {
  fullPhoneInput.value = iti.getNumber(); // e.g., +923001112222
});

        // const input = document.querySelector("[name=phone]");

        // const iti = window.intlTelInput(input, {
        // initialCountry: country_code.toLowerCase() || "pk",
        // separateDialCode: true,
        // nationalMode: true,
        // autoPlaceholder: "polite",
        // formatOnDisplay: true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js", // Correct place
        // });

        // // Update placeholder immediately when country changes
        // input.addEventListener("countrychange", function () {
        // input.setAttribute("placeholder", iti.getPlaceholder());
        // });

        // // Limit input to number length of placeholder
        // input.addEventListener("input", function () {
        // const placeholderLength = (input.placeholder || "").replace(/\D/g, "").length;
        // let digitsOnly = input.value.replace(/\D/g, "");
        // if (digitsOnly.length > placeholderLength) {
        //     digitsOnly = digitsOnly.slice(0, placeholderLength);
        // }
        // input.value = digitsOnly;
        // });

        // // Prevent typing more digits than allowed
        // input.addEventListener("keypress", function (e) {
        // const number = input.value.replace(/\D/g, "");
        // const placeholderLength = (input.placeholder || "").replace(/\D/g, "").length;
        // if (number.length >= placeholderLength && /\d/.test(e.key)) {
        //     e.preventDefault();
        // }
        // });

        // // On submit, store full international number in hidden field
        // document.querySelector("form").addEventListener("submit", function () {
        // const fullPhone = iti.getNumber(); // +923001112222
        // document.querySelector("#full_phone").value = fullPhone;
        // });

        var $countrySelect = $("#country");
        function switch_address_type_things(){
            var delivery_type = $('input[name="delivery_type"]:checked').val();
           
            if(delivery_type == 'personal'){
                $("#address_type_personal").css("display: flex")
                $("#address_type_others").hide()
            } else {
                $("#address_type_personal").hide()
                $("#address_type_others").show()
            }
        }
        function fetch_payment_actions() {
            var delivery_type = $('input[name="delivery_type"]:checked').val();
            // alert(delivery_type)
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('checkout.refresh_payment_actions') }}",
                type: 'GET',
                data: {
                    address_type : delivery_type
                },
                success: function(response) {
                    var obj = response;
                    if (obj != '') {
                        $('#place_order_buttons').html(obj.html);
                    }
                    $(`[name="payment_method"]`).each(function () {
                        $(this).prop("checked", false); // properly uncheck the radio
                        const card = $(this).parent().parent().parent().parent().parent(); // find the closest card container
                        card.removeClass('d-none');
                        
                    });
                    
                    if (delivery_type != 'personal') {
                        $(`[name="payment_method"]`).each(function () {
                            $(this).prop("checked", false); // properly uncheck the radio
                            const card = $(this).parent().parent().parent().parent().parent(); // find the closest card container
                            card.removeClass('d-none');
                            if ($(this).val() === "cash_on_delivery") {
                                card.addClass('d-none'); // hide the card if it's cash on delivery
                            }
                        });

                        // Set 'direct_bank_transfer' as checked
                        $(`[name="payment_method"][value="direct_bank_transfer"]`).prop("checked", true);

                        
                    } 
                }
            });
        }
        // Attach a change event handler to the radio buttons
        $('.delivery_type input').click(function() {
            // alert("t"+$('input[name="delivery_type"]:checked').val())
            // Get the value of the selected radio button
            $('#shipping_info').hide();
            $("#shipping_preloader").attr("style", 'display: flex')
            var delivery_type = $('input[name="delivery_type"]:checked').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('change-address-type')}}",
                type: 'POST',
                data: {
                    address_type: delivery_type
                },
                success: function(response) {
                    var obj = response;
                    if (obj != '') {
                        $("#shipping_preloader").hide();
                        $('#shipping_info').show();
                        $('#shipping_info').html(obj.html);
                        switch_address_type_things()
                        if($('[name="selected_address_id"]').length > 0) {

                            $('[name="selected_address_id"]')[0].click();
                        }
                        fetch_payment_actions()

                        console.log(delivery_type)

                        $('[name="phone"]').val('');
                        $('[name="first_name"]').val('')
                        $('[name="last_name"]').val('')
                        if(delivery_type == 'personal'){
                            const user = obj.user;
                            const phone = user ? user.phone : null;
                            const name = user.name.split(' ');

                            const f_name = name[0] ?? '';
                            const l_name = name[1] ?? ''; 

                            $('[name="phone"]').val(phone);
                            $('[name="first_name"]').val(f_name)
                            $('[name="last_name"]').val(l_name)

                        } 
            
                    }
                   
                  
                }
            });
        });

        if($('[name="selected_address_id"]').length > 0){
            $('[name="selected_address_id"]')[0].click();
        }
        
        $(document).on('change', '[name=country_id]', function() {
            var country_id = $(this).val();
            get_states(country_id);
            
            var countryCode = country_code ?? $(this).data('code');

            $.ajax({
                url: `https://restcountries.com/v3.1/alpha/${countryCode}`,
                method: 'GET',
                success: function(response) {
                    if (response && response[0] && response[0].idd && response[0].idd.root) {
                        // Extract the calling code, which may have root and suffixes
                        const rootCode = response[0].idd.root; // e.g., "+92"
                        const suffixCode = (response[0].idd.suffixes && response[0].idd.suffixes[0]) || "";
                        const fullCode = rootCode + suffixCode;
    
                    }
                },
                error: function() {
                    console.error('Could not retrieve country calling code');
                    $('[name="phone"]').attr('placeholder', ''); // Reset if API fails
                }
            });
        });
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
                                        $("#shipping_preloader").hide();
                                        $('#shipping_info').show();
                                        $('#shipping_info').html(obj.html);
                                        fetch_payment_actions()
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
        $("#country").val(country_id).trigger('change');
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
        

        $("#new_address_modal").click(function(){
            $('#new-address-modal').modal('show')
            var delivery_type = $('input[name="delivery_type"]:checked').val();
            switch_address_type_things()
            
        });

        $(".online_payment").click(function() {
            $('#manual_payment_description').parent().addClass('d-none');
        });

        toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
    });

        var minimum_order_amount_check = {{ get_setting('minimum_order_amount_check') == 1 ? 1 : 0 }};
        var minimum_order_amount =
            {{ get_setting('minimum_order_amount_check') == 1 ? get_setting('minimum_order_amount') : 0 }};

        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            if ($('#agree_checkbox').is(":checked")) {
                ;
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    $('#checkout-form').submit();
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
            }
        }

        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    var offline_payment_active = '{{ addon_is_activated('offline_payment') }}';
                    if (offline_payment_active == '1' && $('.offline_payment_option').is(":checked") && $('#trx_id')
                        .val() == '') {
                        AIZ.plugins.notify('danger', '{{ translate('You need to put Transaction id') }}');
                        $(el).prop('disabled', false);
                    } else {
                        $('#checkout-form').submit();
                    }
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id) {
            if (typeof id != 'undefined') {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        }

        $(document).on("click", "#coupon-apply", function() {
            var data = new FormData($('#apply-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.apply_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    AIZ.plugins.notify(data.response_message.response, data.response_message.message);
                    $("#cart_summary").html(data.html);
                }
            })
        });

        $(document).on("click", "#coupon-remove", function() {
            var data = new FormData($('#remove-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.remove_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $("#cart_summary").html(data);
                }
            })
        })

       
       
    </script>

<script>
    let currentCard = null;

    function selectPayment(element) {
        document.querySelectorAll('.payment-method button').forEach(button => {
            button.classList.remove('selected');
            button.querySelector('.tick').style.display = 'none'; // Hide tick on all buttons
        });

        // Add 'selected' class and show tick on the clicked button
        element.classList.add('selected');
        element.querySelector('.tick').style.display = 'block';
    }

    function editPaymentMethod(card) {
        currentCard = card;
        document.getElementById('card-number').value = card;  // Pre-fill the card number in the popup
        openPopup();
    }

    function deletePaymentMethod(card) {
        if (confirm(`Are you sure you want to delete the card ending in ${card.slice(-4)}?`)) {
            // Here you can add logic to remove the card from your saved cards list
            alert(`Card ending in ${card.slice(-4)} has been deleted.`);
            // For now, we'll just hide the card info.
            document.querySelector('.saved-payment-info').style.display = 'none';
        }
    }

    // Open the card information popup
    function openPopup() {
        document.getElementById('popup').style.display = 'flex';
    }

    // Close the card information popup
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    // Handle form submission (for now it just closes the popup)
    function submitForm() {
        alert("Card information submitted!");
        closePopup();
    }
</script>

<script>
  



        
</script>
@endsection
