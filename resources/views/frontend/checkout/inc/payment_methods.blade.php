<style>
    .payment-method-header {
        display: grid !important;
        grid-template-columns: 1fr 1fr;
    }
    @media (max-width:768px){
        .payment-method-header img {
            width: 25px !important;
            margin-left: 5px;
        }
    }
    .payment-method-header img {
        width: 24px;
        margin-left: 8px;
    }
    .payment-method-header span {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .payment-method-details {
        background-color: #f8f9fa;
        padding: 1rem;
        /* border-top: 1px solid #dedede; */
    }

    .redirect-info {
        display: flex;
        align-items: center;
        margin-top: 1rem;
    }

    .redirect-info img {
      width: 32px;
      margin-right: 10px;
    }
input[type="radio"]:not(.delivery_type input) {
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #999;
    border-radius: 50%;
    min-width: 20px;
    position: relative;
}

input[type="radio"]:not(.delivery_type input):checked::after {
    content: '';
    position: absolute;
    width: 12px;
    height: 12px;
    background: black;
    border-radius: 50%;
    /* top: 50%; */
    left: 2px;
    /* transform: translate(-50%, -50%); */
    right: 0;
    top: 2px;
    bottom: 0;
}
    .card {
        border-radius: 0 !important;
    }
    .card:not(:last-child) {
        border-bottom: unset !important;
        /* border-top: unset !important; */
    }
    .card:has( input:checked) > .card-header {
        border: 1px solid #000 !important;
        transition:  all .1s ease-in-out
    }
    .card .card-header {
        width: 100% !important
    }

    .card:not(:first-child) .card-body {
        margin: 2px 0 !important;
    }

    .bank_transfer_method {
        position: relative;
        background: #fff;
        height: 100%;
       
    }
    .bank_transfer_method input {
        position: absolute;
        top: -50px;
        left: -90px;
    }
    .bank_transfer_method:has(input:checked) {
        border: 1px solid #000 !important;
        background: #daf6ff;
    }
  </style>
    @php


        $carts = \App\Models\Cart::where('user_id', Auth::user()->id)
            ->get();
        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
             redirect()->route('home');
        }
        $shipping_info = \App\Models\Address::where('id', $carts[0]['address_id'])->first();
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;
        if ($carts && count($carts) > 0) {
            foreach ($carts as $key => $cartItem) {
                $product = \App\Models\Product::find($cartItem['product_id']);
                $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                if (get_setting('shipping_type') != 'carrier_wise_shipping' || $request['shipping_type_' . $product->user_id] == 'pickup_point') {
                    if (!empty($request) && $request['shipping_type_' . $product->user_id] == 'pickup_point') {
                        $cartItem['shipping_type'] = 'pickup_point';
                        $cartItem['pickup_point'] = $request['pickup_point_id_' . $product->user_id];
                    } else {
                        $cartItem['shipping_type'] = 'home_delivery';
                    }
                    $cartItem['shipping_cost'] = 0;
                    if ($cartItem['shipping_type'] == 'home_delivery') {
                        $cartItem['shipping_cost'] = getShippingCost($carts, $key);
                    }
                } else {
                    $cartItem['shipping_type'] = 'carrier';
                    $cartItem['carrier_id'] = $request['carrier_id_' . $product->user_id];
                    $cartItem['shipping_cost'] = getShippingCost($carts, $key, $cartItem['carrier_id']);
                }
                $shipping += $cartItem['shipping_cost'];
                
            }
            $total = $subtotal + $tax + $shipping;
        }

        $cod_method = false;
        $banktransfer = true;  
        $mobilewallet_method = false;
        $card_method = false;

        if($total <25000){

            $cod_method = true;

        }

        if($total <50000){

            $mobilewallet_method = true;

        }


        if($total <= 500000){
            $card_method = true;
        }

        if($total > 500000) {
            $cod_method = false;
        }

        $user_wallet_balance =Auth::user()->balance;


        



    @endphp
  <div class="accordion" id="paymentAccordion">


    @if($cod_method)
    <div class="card mb-0 shadow-none p-0" style="border: 1px solid #c1c1c1;">
        <div class="card-header p-0" id="cash_on_deliveryHeading">
          
            <button class="btn btn-link text-decoration-none w-100 p-0 "  type="button" data-toggle="collapse" data-target="#cash_on_delivery">
              <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                    <div class="  text-dark d-flex align-items-center mb-0 text-left" style="font-family: 'Aeonik';">
                        <input type="radio" class=" mb-0 me-2" name="payment_method" value="cash_on_delivery" checked> Cash On Delivery
                    </div>
                    <span>
                        <img src="https://cdn-icons-png.flaticon.com/512/936/936810.png" style="width: 30px; height: auto" alt="Discover">
                    </span>
              </label>
            </button>
          
        </div>
        <div id="cash_on_delivery" class="collapse show {{  $cod_method ? '' : 'd-none' }}" aria-labelledby="cash_on_deliveryHeading" data-parent="#paymentAccordion">
          <div class="card-body payment-method-details p-0 m-0">
         
          </div>
        </div>
      </div>
    @endif
    @if($card_method)
        <!-- Credit Card Option -->
        <div class="card mb-0 shadow-none p-0 " style="border: 1px solid #c1c1c1;">
            <div class="card-header p-0" id="creditCardHeading">
            
                <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#creditCard" aria-expanded="true">
                <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                    <div class="  text-dark d-flex align-items-center mb-0 text-left" style="font-family: 'Aeonik';">
                    
                    <input type="radio" class=" mb-0 me-2" name="payment_method" value="credit_card"  > Credit / Debit Card
                    </div>
                    <span>
                        <img src="{{ static_asset('assets/img/visa.png') }}"  alt="Visa">
                        <img src="{{ static_asset('assets/img/mastercard.png') }}"  alt="MasterCard">
                        <img src="{{ static_asset('assets/img/amex.png') }}"  alt="Amex">
                        <img src="{{ static_asset('assets/img/discover.png') }}"  alt="Discover">
                    </span>
                </label>
                </button>
            
            </div>
            <div id="creditCard" class="collapse {{  $card_method ? '' : 'd-none' }}" aria-labelledby="creditCardHeading" data-parent="#paymentAccordion">
                <div class="card-body payment-method-details p-4 bg-light">
                    Enter your credit card details securely to complete the payment.
                </div>
            </div>
        </div>
    @endif
    <!-- PayPal Option -->
    <div class="card mb-0 shadow-none p-0" style="border: 1px solid #c1c1c1;">
      <div class="card-header p-0" id="direct_bank_transferHeading">
        
          <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#direct_bank_transfer">
            <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                <div class="  text-dark d-flex align-items-center mb-0 text-left" style="font-family: 'Aeonik';">
                  <input type="radio" class=" mb-0 me-2" name="payment_method" value="direct_bank_transfer"> Direct Bank / Mobile Transfer
                </div>
                <span>
                    <img src="{{ static_asset('assets/img/banktransfer.png') }}" style="width: 45px; height: auto" alt="Discover">
                    @if($mobilewallet_method)
                        <img  src="{{ static_asset('assets/img/jazzcash.png') }}"  style="width: 35px; height: auto" alt="Discover">
                        <img  src="{{ static_asset('assets/img/Easypaisa.png') }}" style="width: 30px; height: auto" alt="Discover">
                    @endif
                  </span>
              </label>
          </button>
        
      </div>
      <div id="direct_bank_transfer" class="collapse" aria-labelledby="direct_bank_transferHeading" data-parent="#paymentAccordion">
        <div class="card-body payment-method-details p-4 bg-light">
            <p class="fs-15 fw-300"">
                You will receive the payment details upon order confirmation. Please complete your payment via direct bank transfer or mobile transfer and provide the transaction reference for order processing.
            </p>
            <div class="row g-2">
                <div class="col-md-4">
                    <Label class="border-1 rounded-2 p-2 text-center w-100 bank_transfer_method">
                        <div  class="mx-auto" style="width: 50px; aspect-ratio: 1/1">
                            <img src="https://crystalpng.com/wp-content/uploads/2025/01/meezan-bank-logo.png" class="w-100 h-100 object-fit-contain">
                        </div>
                        <input type="radio" name="payment_transfer_method" value="meezan_bank" >
                        <p class=" fs-15 fw-500">Meezan Bank
                        </p>
                        <b>Account Title.</b>
                        <p class="mb-0">SOLARONLINE PAKISTAN</p>
                        <b>IBAN: </b>
                        <p class="mb-0">PK39 MEZN 0002 8101 0824 5316</p>
                        <b>Account No.</b>
                        <p class="mb-0">02810108245316</p>
                    </Label>
                </div> 
                <div class="col-md-4">
                    <Label class="border-1 rounded-2 p-2 text-center w-100 bank_transfer_method">
                        <div  class="mx-auto" style="width: 50px; aspect-ratio: 1/1">
                            <img src="https://crystalpng.com/wp-content/uploads/2025/01/mcb-logo.png" class="w-100 h-100 object-fit-contain">
                        </div>
                        <input type="radio" name="payment_transfer_method" value="mcb_bank" >
                        <p class=" fs-15 fw-500">MCB Bank Ltd
                        </p>
                        <b>Account Title.</b>
                        <p class="mb-0">SOLAR DYNAMICS TECHNOLOGIES PAKISTAN</p>
                        <b>IBAN: </b>
                        <p class="mb-0">PK56 MUCB 0585 3769 6100 1725</p>
                        <b>Account No.</b>
                        <p class="mb-0">0585376961001725</p>
                    </Label>
                </div> 
                <div class="col-md-4">
                    <Label class="border-1 rounded-2 p-2 text-center w-100 bank_transfer_method">
                        <div  class="mx-auto" style="width: 50px; aspect-ratio: 1/1">
                            <img src="https://companieslogo.com/img/orig/BAHL.PK-dca414fa.png?t=1720244490" class="w-100 h-100 object-fit-contain">
                        </div>
                        <input type="radio" name="payment_transfer_method" value="bank_al_habib" >
                        <p class=" fs-15 fw-500">Bank AL Habib Ltd
                        </p>
                        <b>Account Title.</b>
                        <p class="mb-0">SOLAR DYNAMICS TECHNOLOGIES PAKISTAN</p>
                        <b>IBAN: </b>
                        <p class="mb-0">PK41 BAHL 0254 0981 0214 4301</p>
                    </Label>
                </div> 

                @if($mobilewallet_method )
                    <div class="col-md-4">
                        <Label class="border-1 rounded-2 p-2 text-center w-100 bank_transfer_method">
                            <div  class="mx-auto" style="width: 50px; aspect-ratio: 1/1">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQ2z0lPrjtW6QHUQwdNEeXkuMxsJcutkkKSQ&s" class="w-100 h-100 object-fit-contain">
                            </div>
                            <input type="radio" name="payment_transfer_method" value="jazzcash" >
                            <p class="fs-15 fw-500">JazzCash
                            </p>
                            <b>Account Title: </b>
                            <p class="mb-0"> Muhammad Naveed</p>
                            <b>Account No.</b>
                            <p class="mb-0">
                                0300 0322034 
                            </p>
                        </Label>
                    </div> 
                    <div class="col-md-4">
                        <Label class="border-1 rounded-2 p-2 text-center w-100 bank_transfer_method">
                            <div  class="mx-auto" style="width: 50px; aspect-ratio: 1/1">
                                <img src="https://www.thenews.com.pk/assets/uploads/akhbar/2024-01-27/1151682_8435733_Easypaisa_akhbar.jpg" class="w-100 h-100 object-fit-contain">
                            </div>
                            <input type="radio" name="payment_transfer_method" value="easypaisa" >
                            <p class=" fs-15 fw-500">Easypaisa
                            </p>
                            <b>IBAN: </b>
                            <p class="mb-0">PAK12392390239239023</p>
                            <b>Account No.</b>
                            <p class="mb-0">2323093232</p>
                        </Label>
                    </div>
                @endif
            </div>
        </div>
      </div>
    </div>
 
    <div class="card mb-0 shadow-none p-0 " style=" @if ($total > $user_wallet_balance)  background: #ccc; @endif border: 1px solid #c1c1c1;">
        <div class="card-header p-0" id="bighouz_walletHeading">
          
            <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#bighouz_wallet">
              <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                  <div class="  text-dark d-flex align-items-center mb-0">
                    <input type="radio" class=" mb-0 me-2" name="payment_method" value="bighouz_wallet" {{ $total >  $user_wallet_balance ? 'disabled' : '' }}> 
                        <div class="d-flex flex-column" style="font-family: 'Aeonik';">
                            Bighouz Wallet
                            @if ($total > $user_wallet_balance) 
                            <br>
                                <small class="text-danger"> Insufficient Funds </small>
                            @endif
                        </div>
                  </div>
                  <span class="d-flex gap-2 align-items-center">
                    @if ($total > $user_wallet_balance)  <a href="{{ url('/wallet') }}" class="btn btn-primary px-2 py-1 fs-12"> Recharge</a> @endif
                    <h6 class="m-0">{{ single_price(Auth::user()->balance)}}</h6>
                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}" class="ms-2" style="width: 25px; height: auto" alt="Discover">
                    </span>
                </label>
            </button>
          
        </div>
        @if ($total <= $user_wallet_balance) 
            <div id="bighouz_wallet" class="collapse" aria-labelledby="mobile_walletHeading" data-parent="#paymentAccordion">
                <div class="card-body payment-method-details p-4 bg-light">
                    You will be redirected to PayPal to complete your purchase securely.
                </div>
            </div>
        @endif
      </div>
    <div class="card mb-0 shadow-none p-0" style="border: 1px solid #c1c1c1;">
        <div class="card-header p-0" id="cash_on_counterHeading">
          
            <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#cash_on_counter">
              <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3" style="font-family: 'Aeonik';">
                  <div class="  text-dark d-flex align-items-center mb-0">
                    <input type="radio" class=" mb-0 me-2" name="payment_method" value="cash_on_counter"> Cash On Counter
                  </div>
                  <span>
                      <img src="{{ static_asset('assets/img/11-11408.png') }}" style="width: 30px; height: auto" alt="Discover">
                    </span>
                </label>
            </button>
          
        </div>
        <div id="cash_on_counter" class="collapse" aria-labelledby="cash_on_counterHeading" data-parent="#paymentAccordion">
            <div class="card-body payment-method-details p-4 bg-light fs-15 fw-300">
                We offer a Cash on Counter payment option for your convenience! Place your order online and pay when you pick it up at our store. No advance payment required—simply visit us, verify your order, and complete the payment at the counter.
                <br><br>
                <i class="fa fa-check fs-16 bg-success p-1 text-white rounded-circle me-2 mt-1"></i> Secure & Hassle-Free
                <br>
                <i class="fa fa-check fs-16 bg-success p-1 text-white rounded-circle me-2  mt-1"></i> No Online Payment Needed
                <br>
                <i class="fa fa-check fs-16 bg-success p-1 text-white rounded-circle me-2  mt-1"></i> Pay Only When You Collect
                <br>
                <br>
                Visit our store and shop with confidence! 
            </div>
        </div>
      </div>
  </div>
<script>
    $("#paymentAccordion .card-header, #pau").click(function(){
        $(this).closest("input").click()
        $(this).closest("input").prop("checked", true)
    });
</script>









<div class="payment-method d-none">
                        
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