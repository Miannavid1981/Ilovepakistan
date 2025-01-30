@extends('frontend.layouts.app')

@section('content')
<style>
    header, footer {
        display: none !important;
    }
    body {
        background: linear-gradient(to left, #fff 50%, #f5f5f5 50%);
    }
    .front-header-search {
        display: none !important
    }
    .checkout-container {
         background-color: white;
         border-radius: 8px;
         padding: 20px;

         width: 90%;
         max-width: 1200px;
         display: grid;
         grid-template-columns: 1.3fr 1fr;
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
         gap: 15px;
     }

     .cart-item {
         display: flex;
         align-items: center;
         position: relative;
         gap: 15px;
         padding: 15px;
         background-color: #f9f9f9;
         border-radius: 8px;
         border: 1px solid #e4e4e4;
     }

     .cart-item img {
        width: 50px;
        height: auto;
        border-radius: 4px;
        aspect-ratio: 1/1;
        object-fit: contain;
        background: #fff;
        border: 1px solid #ccc;
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
         font-size: 1rem;
         font-weight: bold;
         color: #004d40;
     }

     .quantity-circle {
         display: flex;
         justify-content: center;
         align-items: center;
         width: 30px;
         height: 30px;
         border-radius: 50%;
         background-color: #004d40;
         color: white;
         font-size: 1rem;
         font-weight: bold;
         margin-top: 10px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         position: absolute;
         left: 2px;
         bottom: 97px;
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
    border-top: 1px solid #dfdfdf;
    border-right: 1px solid #dfdfdf;
    border-left: 1px solid #dfdfdf;

}
.address_item {
    border-bottom: 1px solid #dfdfdf;
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 20px;

}

@media (min-width: 768px) {
    .checkout_columns {
        padding: 0 40px !important;
        padding-top: 40px !important;
    }
}

</style>
@php
    $auth_user_id = auth()->user()->id;
    

    $cart = \App\Models\Cart::where('user_id', $auth_user_id)->get();
    $subtotal = 0;
    // dd($cart);
@endphp
<form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST" id="checkout-form" style="background: linear-gradient(to right, #fff 70%, #f5f5f5 0%);">
    @csrf
    <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">

    <div class="container pt-4" style=" height: 100vh">
        <!-- Header -->
        <div class="row h-100">
          


        <div class="col-md-7 checkout_columns">
            <img src="https://allaaddin.com/public/images/1j+ojFVDOMkX9Wytexe43D6kh.png" style="width: 100px" alt="Bighouz" class="img-fluid">
            <ul class="d-flex gap-2 list-unstyled fs-13 text-muted">
                <li>Home</li>
                <li><i class="fa fa-chevron-right"></i></li>
                <li>Checkout</li>
            </ul>
           
            
            <div>
                <h5 class="">Addresses</h5>
                <div class="addresses  mb-3">
                    <div class="address_item p-3">
                        <div>
                            <h5 class="mb-0">Address title</h5>
                            <p class="mb-0">Address title</p>
                        </div>
                        <div class="address_action_buttons d-flex justify-content-end">
                            <button class="p-2 text-danger bg-white border-0 fs-16">
                                <i class="fa fa-trash"></i>
                                Remove
                            </button>
                            <button class="p-2 text-dark bg-white border-0 fs-16">
                                <i class="fa fa-pen"></i>
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
        
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd; margin-bottom: 15px; display: none">
                    <!-- Table Header -->
                    <thead style="background-color: #f4f4f4;">
                        <tr>
                            <th style="padding: 10px; font-size: 1rem; color: #333; text-align: left;">Card Payment</th>
                            <th style="padding: 10px; text-align: right;">Action</th>
                        </tr>
                    </thead>
            
                    <!-- Table Body (List of Saved Cards) -->
                    <tbody>
                        <!-- Saved Card Row 1 -->
                        <tr>
                            <td style="padding: 10px; font-size: 1rem; color: #333;">
                                <input type="radio" name="payment-method" value="Visa ending in 1234" onclick="selectPaymentMethod('Visa ending in 1234')">
                                <span>Visa ending in 1234</span>
                            </td>
                            <td style="padding: 10px; text-align: right;">
                                <span class="delete-icon" onclick="deletePaymentMethod('Visa ending in 1234')" style="cursor: pointer; font-size: 16px; color: #e74c3c;">🗑️ Delete</span>
                                <span class="edit-icon" onclick="editPaymentMethod('Visa ending in 1234')" style="cursor: pointer; font-size: 16px; color: #004d40;">✎ Edit</span>
                            </td>
                        </tr>
            
                        <!-- Saved Card Row 2 -->
                        <tr>
                            <td style="padding: 10px; font-size: 1rem; color: #333;">
                                <input type="radio" name="payment-method" value="MasterCard ending in 5678" onclick="selectPaymentMethod('MasterCard ending in 5678')">
                                <span>MasterCard ending in 5678</span>
                            </td>
                            <td style="padding: 10px; text-align: right;">
                                <span class="delete-icon" onclick="deletePaymentMethod('MasterCard ending in 5678')" style="cursor: pointer; font-size: 16px; color: #e74c3c;">🗑️ Delete</span>
                                <span class="edit-icon" onclick="editPaymentMethod('MasterCard ending in 5678')" style="cursor: pointer; font-size: 16px; color: #004d40;">✎ Edit</span>
                            </td>
                        </tr>
            
                        <!-- More Saved Card Rows can be added here -->
                    </tbody>
                </table>
            </div>


       
            <h3>Payment Method</h3>
            <div class="payment-method">
                

                <!-- Paypal -->
                @if (get_setting('paypal_payment') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="paypal" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/paypal.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span class="d-block fw-600 fs-15">{{ translate('Paypal') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!--Stripe -->
                @if (get_setting('stripe_payment') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="stripe" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/stripe.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span class="d-block fw-600 fs-15">{{ translate('Stripe') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- Mercadopago -->
                @if (get_setting('mercadopago_payment') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="mercadopago" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/mercadopago.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Mercadopago') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- sslcommerz -->
                @if (get_setting('sslcommerz_payment') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="sslcommerz" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/sslcommerz.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('sslcommerz') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- instamojo -->
                @if (get_setting('instamojo_payment') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="instamojo" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/instamojo.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Instamojo') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- razorpay -->
                @if (get_setting('razorpay') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="razorpay" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/rozarpay.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Razorpay') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- paystack -->
                @if (get_setting('paystack') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="paystack" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/paystack.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Paystack') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- voguepay -->
                @if (get_setting('voguepay') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="voguepay" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/vogue.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('VoguePay') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- payhere -->
                @if (get_setting('payhere') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="payhere" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/payhere.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('payhere') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- ngenius -->
                @if (get_setting('ngenius') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="ngenius" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/ngenius.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('ngenius') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- iyzico -->
                @if (get_setting('iyzico') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="iyzico" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/iyzico.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Iyzico') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- nagad -->
                @if (get_setting('nagad') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="nagad" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/nagad.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span class="d-block fw-600 fs-15">{{ translate('Nagad') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- bkash -->
                @if (get_setting('bkash') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="bkash" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/bkash.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span class="d-block fw-600 fs-15">{{ translate('Bkash') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- aamarpay -->
                @if (get_setting('aamarpay') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="aamarpay" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/aamarpay.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Aamarpay') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- authorizenet -->
                @if (get_setting('authorizenet') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="authorizenet" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/authorizenet.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Authorize Net') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- payku -->
                @if (get_setting('payku') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="payku" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                <img src="{{ static_asset('assets/img/cards/payku.png') }}"
                                    class="img-fit mb-2">
                                <span class="d-block text-center">
                                    <span class="d-block fw-600 fs-15">{{ translate('Payku') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- African Payment Getaway -->
                @if (addon_is_activated('african_pg'))
                    <!-- flutterwave -->
                    @if (get_setting('flutterwave') == 1)
                        <div class="col-6 col-xl-3 col-md-4">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="flutterwave" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                    <img src="{{ static_asset('assets/img/cards/flutterwave.png') }}"
                                        class="img-fit mb-2">
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('flutterwave') }}</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    @endif
                    <!-- payfast -->
                    @if (get_setting('payfast') == 1)
                        <div class="col-6 col-xl-3 col-md-4">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="payfast" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                    <img src="{{ static_asset('assets/img/cards/payfast.png') }}"
                                        class="img-fit mb-2">
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('payfast') }}</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    @endif
                @endif
                {{-- Asian Payment gateways --}}
                <!--paytm -->
                @if (addon_is_activated('paytm'))
                    @if (get_setting('paytm_payment') == 1)
                        <div class="col-6 col-xl-3 col-md-4">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="paytm" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                    <img src="{{ static_asset('assets/img/cards/paytm.png') }}"
                                        class="img-fit mb-2">
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('Paytm') }}</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    @endif
                    <!-- toyyibpay -->
                    @if (get_setting('toyyibpay_payment') == 1)
                        <div class="col-6 col-xl-3 col-md-4">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="toyyibpay" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                    <img src="{{ static_asset('assets/img/cards/toyyibpay.png') }}"
                                        class="img-fit mb-2">
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('ToyyibPay') }}</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    @endif
                    <!-- myfatoorah -->
                    @if (get_setting('myfatoorah') == 1)
                        <div class="col-6 col-xl-3 col-md-4">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="myfatoorah" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                    <img src="{{ static_asset('assets/img/cards/myfatoorah.png') }}"
                                        class="img-fit mb-2">
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('MyFatoorah') }}</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    @endif
                    <!-- khalti -->
                    @if (get_setting('khalti_payment') == 1)
                        <div class="col-6 col-xl-3 col-md-4">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="Khalti" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-block aiz-megabox-elem p-3">
                                    <img src="{{ static_asset('assets/img/cards/khalti.png') }}"
                                        class="img-fluid mb-2">
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('Khalti') }}</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    @endif
                    <!-- phonepe -->
                    @if (get_setting('phonepe_payment') == 1)
                        <div class="col-6 col-xl-3 col-md-4">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="phonepe" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-block aiz-megabox-elem p-3">
                                    <img src="{{ static_asset('assets/img/cards/phonepe.png') }}"
                                        class="img-fluid mb-2">
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('Phonepe') }}</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    @endif
                @endif


                <!-- Paymob -->
                @if (get_setting('paymob_payment') == 1)
                    <div class="col-6 col-xl-3 col-md-4">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="paymob" class="online_payment" type="radio"
                                name="payment_option" checked>
                            <span class="d-block aiz-megabox-elem p-3">
                                <img src="{{ static_asset('assets/img/cards/paymob.png') }}"
                                    class="img-fluid mb-2">
                                <span class="d-block text-center">
                                    <span
                                        class="d-block fw-600 fs-15">{{ translate('Paymob') }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif
                <!-- Cash Payment -->
                @if (get_setting('cash_payment') == 1)
                    @php
                        $digital = 0;
                        $cod_on = 1;
                        foreach ($carts as $cartItem) {
                            $product = get_single_product($cartItem['product_id']);
                            if ($product['digital'] == 1) {
                                $digital = 1;
                            }
                            if ($product['cash_on_delivery'] == 0) {
                                $cod_on = 0;
                            }
                        }
                    @endphp
                    @if ($digital != 1 && $cod_on == 1)
                        
                            <label class="payment_method_box d-flex align-items-center gap-2 mb-3">
                                <input value="cash_on_delivery" class="online_payment" type="radio"
                                    name="payment_option" checked>
                                <span class="d-flex align-items-center gap-2 rounded-2 p-1">
                                        <i class="fa fa-truck fs-18"></i>
                                    <span class="d-block text-center">
                                        <span
                                            class="d-block fw-600 fs-15">{{ translate('Cash on Delivery') }}</span>
                                    </span>
                                </span>
                            </label>
                        
                    @endif
                @endif
                @if (Auth::check())
                    <!-- Offline Payment -->
                    @if (addon_is_activated('offline_payment'))
                        @foreach (get_all_manual_payment_methods() as $method)
                            <div class="col-6 col-xl-3 col-md-4">
                                <label class="aiz-megabox d-block mb-3">
                                    <input value="{{ $method->heading }}" type="radio"
                                        name="payment_option" class="offline_payment_option"
                                        onchange="toggleManualPaymentData({{ $method->id }})"
                                        data-id="{{ $method->id }}" checked>
                                    <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                        <img src="{{ uploaded_asset($method->photo) }}"
                                            class="img-fit mb-2">
                                        <span class="d-block text-center">
                                            <span
                                                class="d-block fw-600 fs-15">{{ $method->heading }}</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endforeach

                        @foreach (get_all_manual_payment_methods() as $method)
                            <div id="manual_payment_info_{{ $method->id }}" class="d-none">
                                @php echo $method->description @endphp
                                @if ($method->bank_info != null)
                                    <ul>
                                        @foreach (json_decode($method->bank_info) as $key => $info)
                                            <li>{{ translate('Bank Name') }} -
                                                {{ $info->bank_name }},
                                                {{ translate('Account Name') }} -
                                                {{ $info->account_name }},
                                                {{ translate('Account Number') }} -
                                                {{ $info->account_number }},
                                                {{ translate('Routing Number') }} -
                                                {{ $info->routing_number }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
                
            <!-- Agree Box -->
            <div class="">
                <label class="aiz-checkbox">
                    <input type="checkbox" required id="agree_checkbox">
                    <span class="aiz-square-check"></span>
                    <span>{{ translate('I agree to the') }}</span>
                </label>
                <a href="{{ route('terms') }}"
                    class="fw-700">{{ translate('terms and conditions') }}</a>,
                <a href="{{ route('returnpolicy') }}"
                    class="fw-700">{{ translate('return policy') }}</a> &
                <a href="{{ route('privacypolicy') }}"
                    class="fw-700">{{ translate('privacy policy') }}</a>
            </div>

        
                <!-- Return to shop -->
               
                <button type="button" onclick="submitOrder(this)"  class="w-100 btn btn-lg btn-primary fs-16 fw-700 rounded-0 px-4 py-2">{{ translate('Complete Order') }}</button>
       
                    <a href="{{ route('home') }}" class="btn btn-link fs-14 fw-700 px-0 mt-2">
                        <i class="las la-arrow-left fs-16"></i>
                        {{ translate('Return to shop') }}
                    </a>
               
        

        </div>

        <!-- Summary Section -->
        <div class="col-md-5 checkout_columns" style="background: #f5f5f5">
            <h3>Your Purchase</h3>
            <div class="summary-cart">
                @if ($cart && $cart->count() > 0)
                    @foreach ($cart as $key => $item  )

                    @php
                        $qty = $item->quantity;
                        $product = \App\Models\Product::find($item->product_id);
                        // $item_total = discount_in_percentage($product) > 0 ? ($qty * home_discounted_base_price($product, false)) : ($qty * home_base_price($product, false));
                        // $item->subtotal = format_price($item_total);
                        // $total += $item_total;
                        // $items_subtotal = $qty * home_base_price($product, false);
                        // $subtotal += $items_subtotal;
                        // $discount_amount = discount_in_percentage($product) > 0 ? home_base_price($product, false) - home_discounted_base_price($product, false) : 0;
                        // $items_discount += ($qty * $discount_amount);
                
                        // // Assigning cart item keys with the correct values
                        // $item->product_id = $product->id;
                        // $item->name = $product->name;
                        // $item->price = home_base_price($product);
                        // $item->price_int = home_base_price($product, false);
                        // $item->image = $product->thumbnail ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg');
                        // $item->quantity = $qty;
                        // $item->discounted_price = home_discounted_base_price($product);
                        // $item->discounted_price_int = home_discounted_base_price($product, false);
                        // $item->subtotal = format_price($subtotal);
                        // $item->discount = discount_in_percentage($product) > 0;
                        // $item->discounted_percentage = discount_in_percentage($product);
                        // $item->user_id = $userId;
                        // $item->temp_user_id = $tempUserId;
                    @endphp

                        <div class="cart-item">
                            <img src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="Levis Men Jeans" style="">
                            <div class="quantity-circle">{{ $qty }}</div>
                            <div class="cart-item-info">
                                <h4>{{  $product->name }}</h4>
                                <p>Size: <span>38</span></p>
                                <p>Color: <span>Blue</span></p>
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

            <div id="cart_summary">

            
                @include('frontend.partials.cart_summary')
            </div>
            
        </div>




    </div>



    </div>
</form>

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
    <!-- Steps -->
    <section class="pt-5 mb-4 d-none">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row gutters-5 sm-gutters-10">
                        <div class="col done">
                            <div class="text-center border border-bottom-6px p-2 text-success">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col done">
                            <div class="text-center border border-bottom-6px p-2 text-success">
                                <i class="la-3x mb-2 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('2. Shipping info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col done">
                            <div class="text-center border border-bottom-6px p-2 text-success">
                                <i class="la-3x mb-2 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('3. Delivery info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center border border-bottom-6px p-2 text-primary">
                                <i class="la-3x mb-2 las la-credit-card cart-animate"
                                    style="margin-right: -100px; transition: 2s;"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('4. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('5. Confirmation') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Info -->
    <section class="mb-4 d-none">
        <div class="container text-left">
            <div class="row">
                <div class="col-lg-8">
                  
                        <div class="card rounded-0 border shadow-none">
                            <!-- Additional Info -->
                            <div class="card-header p-4 border-bottom-0">
                                <h3 class="fs-16 fw-700 text-dark mb-0">
                                    {{ translate('Any additional info?') }}
                                </h3>
                            </div>
                            <div class="form-group px-4">
                                <textarea name="additional_info" rows="5" class="form-control rounded-0"
                                    placeholder="{{ translate('Type your text...') }}"></textarea>
                            </div>

                            <div class="card-header p-4 border-bottom-0">
                                <h3 class="fs-16 fw-700 text-dark mb-0">
                                    {{ translate('Select a payment option') }}
                                </h3>
                            </div>
                            <!-- Payment Options -->
                            <div class="card-body text-center px-4 pt-0">
                                <div class="row gutters-10">
                                    
                                    @if (Auth::check())
                                        <!-- Offline Payment -->
                                        @if (addon_is_activated('offline_payment'))
                                            @foreach (get_all_manual_payment_methods() as $method)
                                                <div class="col-6 col-xl-3 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="{{ $method->heading }}" type="radio"
                                                            name="payment_option" class="offline_payment_option"
                                                            onchange="toggleManualPaymentData({{ $method->id }})"
                                                            data-id="{{ $method->id }}" checked>
                                                        <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                                            <img src="{{ uploaded_asset($method->photo) }}"
                                                                class="img-fit mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ $method->heading }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endforeach

                                            @foreach (get_all_manual_payment_methods() as $method)
                                                <div id="manual_payment_info_{{ $method->id }}" class="d-none">
                                                    @php echo $method->description @endphp
                                                    @if ($method->bank_info != null)
                                                        <ul>
                                                            @foreach (json_decode($method->bank_info) as $key => $info)
                                                                <li>{{ translate('Bank Name') }} -
                                                                    {{ $info->bank_name }},
                                                                    {{ translate('Account Name') }} -
                                                                    {{ $info->account_name }},
                                                                    {{ translate('Account Number') }} -
                                                                    {{ $info->account_number }},
                                                                    {{ translate('Routing Number') }} -
                                                                    {{ $info->routing_number }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>

                                <!-- Offline Payment Fields -->
                                @if (addon_is_activated('offline_payment'))
                                    <div class="d-none mb-3 rounded border bg-white p-3 text-left">
                                        <div id="manual_payment_description">

                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>{{ translate('Transaction ID') }} <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control mb-3" name="trx_id"
                                                    id="trx_id" placeholder="{{ translate('Transaction ID') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{ translate('Photo') }}</label>
                                            <div class="col-md-9">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose image') }}
                                                    </div>
                                                    <input type="hidden" name="photo" class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Wallet Payment -->
                                @if (Auth::check() && get_setting('wallet_system') == 1)
                                    <div class="py-4 px-4 text-center bg-soft-secondary-base mt-4">
                                        <div class="fs-14 mb-3">
                                            <span class="opacity-80">{{ translate('Or, Your wallet balance :') }}</span>
                                            <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
                                        </div>
                                        @if (Auth::user()->balance < $total)
                                            <button type="button" class="btn btn-secondary" disabled>
                                                {{ translate('Insufficient balance') }}
                                            </button>
                                        @else
                                            <button type="button" onclick="use_wallet()"
                                                class="btn btn-primary fs-14 fw-700 px-5 rounded-0">
                                                {{ translate('Pay with wallet') }}
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>

                           
                        </div>
                    
                </div>

                <!-- Cart Summary -->
             
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
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
@endsection
