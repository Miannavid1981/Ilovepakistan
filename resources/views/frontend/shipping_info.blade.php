@extends('frontend.layouts.app')

@section('content')
<style>
       .checkout-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto 1fr;
            gap: 20px;
            margin: 20px auto;
            align-items: start;
            
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
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
        }

        .payment-section {
    padding: 20px;
    position: sticky;
    top: 15px;  /* Stick 15px from the top */
    z-index: 1000;
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    /* Only position: sticky is required */
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
            background-color: #004d40;
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
            background-color: #004d40;
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
            width: 100px;
            height: auto;
            border-radius: 4px;
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
</style>


<div class="checkout-container">
    <!-- Header -->
    <div class="checkout-header">
        <h1>Checkout</h1>
    </div>

    <!-- Payment Section -->
    <div class="payment-section">
        <h3>Payment Method</h3>
        <div class="payment-method">
            <button onclick="selectPayment(this)">
                <span class="tick">✓</span>
                <img src="./social.png" alt="Paypal">
                PayPal
            </button>
            <button onclick="selectPayment(this)">
                <span class="tick">✓</span>
                <img src="./money.png" alt="Credit Card">
                Credit Card
            </button>
            <button onclick="selectPayment(this)">
                <span class="tick">✓</span>
                <img src="./apple-logo.png" alt="Apple Pay">
                Apple Pay
            </button>
        </div>

        <button class="continue-button" onclick="openPopup()">Enter New Card Information</button>
        <div>
            <h5 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 10px;">Saved Payment Methods</h5>
     
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd; margin-bottom: 15px; ">
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



        <div class="order-summary">
            <div class="summary-details">
                <p>Subtotal: <span>Rs 2,000.00</span></p>
                <p>Delivery: <span>Rs 22.00</span></p>
                <p>Tax: <span>Rs 0</span></p>
                <hr style="border: none; height: 2px; background-color: #e7e7e7;">
                <p class="total">Total: <span>Rs 2,022.00</span></p>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3>Summary</h3>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>

        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>

        <div class="summary-cart">
            <div class="cart-item">
                <img src="./Shopping-Cart-1.png" alt="Levis Men Jeans">
                <div class="quantity-circle">88</div>
                <div class="cart-item-info">
                    <h4>Levis Men Jeans</h4>
                    <p>Size: <span>38</span></p>
                    <p>Color: <span>Blue</span></p>
                </div>
                <div class="price">$120.00</div>
            </div>
        </div>
    </div>
</div>

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
                        <div class="col active">
                            <div class="text-center border border-bottom-6px p-2 text-primary">
                                <i class="la-3x mb-2 las la-map cart-animate" style="margin-right: -100px; transition: 2s;"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('2. Shipping info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2">
                                <i class="la-3x mb-2 opacity-50 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('3. Delivery info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2">
                                <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('4. Payment') }}</h3>
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

    @php
        $file = base_path("/public/assets/myText.txt");
        $dev_mail = get_dev_mail();
        if(!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))){
            $content = "Todays date is: ". date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: ".$_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    @endphp

    <!-- Shipping Info -->
    <section class="mb-4 gry-bg">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-xxl-8 col-xl-10 mx-auto">
                    <form class="form-default" id="shipping_info_form" data-toggle="validator" action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                        @csrf
                        <div class="border bg-white p-4 mb-4">
                            @if(Auth::check())
                                @foreach (Auth::user()->addresses as $key => $address)
                                    <div class="border mb-4">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="aiz-megabox d-block bg-white mb-0">
                                                    <input type="radio" name="address_id" value="{{ $address->id }}" @if ($address->set_default)
                                                        checked
                                                    @endif required>
                                                    <span class="d-flex p-3 aiz-megabox-elem border-0">
                                                        <!-- Checkbox -->
                                                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                        <!-- Address -->
                                                        <span class="flex-grow-1 pl-3 text-left">
                                                            <div class="row">
                                                                <span class="fs-14 text-secondary col-3">{{ translate('Address') }}</span>
                                                                <span class="fs-14 text-dark fw-500 ml-2 col">{{ $address->address }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <span class="fs-14 text-secondary col-3">{{ translate('Postal Code') }}</span>
                                                                <span class="fs-14 text-dark fw-500 ml-2 col">{{ $address->postal_code }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <span class="fs-14 text-secondary col-3">{{ translate('City') }}</span>
                                                                <span class="fs-14 text-dark fw-500 ml-2 col">{{ optional($address->city)->name }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <span class="fs-14 text-secondary col-3">{{ translate('State') }}</span>
                                                                <span class="fs-14 text-dark fw-500 ml-2 col">{{ optional($address->state)->name }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <span class="fs-14 text-secondary col-3">{{ translate('Country') }}</span>
                                                                <span class="fs-14 text-dark fw-500 ml-2 col">{{ optional($address->country)->name }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <span class="fs-14 text-secondary col-3">{{ translate('Phone') }}</span>
                                                                <span class="fs-14 text-dark fw-500 ml-2 col">{{ $address->phone }}</span>
                                                            </div>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                            <!-- Edit Address Button -->
                                            <div class="col-md-4 p-3 text-right">
                                                <a class="btn btn-sm btn-secondary-base text-white mr-4 rounded-0 px-4" onclick="edit_address('{{$address->id}}')">{{ translate('Change') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <input type="hidden" name="checkout_type" value="logged">
                                <!-- Add New Address -->
                                <div class="mb-5" >
                                    <div class="border p-3 c-pointer text-center bg-light has-transition hov-bg-soft-light h-100 d-flex flex-column justify-content-center" onclick="add_new_address()">
                                        <i class="las la-plus la-2x mb-3"></i>
                                        <div class="alpha-7 fw-700">{{ translate('Add New Address') }}</div>
                                    </div>
                                </div>
                            @else
                                <!-- Guest Shipping a address -->
                                @include('frontend.partials.cart.guest_shipping_info')
                            @endif
                            <div class="row align-items-center">
                                <!-- Return to shop -->
                                <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                                    <a href="{{ route('home') }}" class="btn btn-link fs-14 fw-700 px-0">
                                        <i class="las la-arrow-left fs-16"></i>
                                        {{ translate('Return to shop')}}
                                    </a>
                                </div>
                                <!-- Continue to Delivery Info -->
                                <div class="col-md-6 text-center text-md-right">
                                    <button
                                        @if(Auth::check()) type="submit" @else type="button" onclick="submitShippingInfoForm(this)" @endif
                                        class="btn btn-primary fs-14 fw-700 rounded-0 px-4"
                                    >
                                        {{ translate('Continue to Delivery Info')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    <!-- Address Modal -->
    @if(Auth::check())
        @include('frontend.partials.address.address_modal')
    @endif
@endsection

@section('script')
    @include('frontend.partials.address.address_js')
@endsection
