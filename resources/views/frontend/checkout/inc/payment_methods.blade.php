<style>
    .payment-method-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .payment-method-header img {
      width: 24px;
      margin-left: 8px;
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

    input[type="radio"] {

        appearance: none;

        width: 20px;

        height: 20px;

        border: 2px solid #999;

        border-radius: 50%;

        position: relative;

    }

    input[type="radio"]:checked::after {

        content: '';

        position: absolute;

        width: 12px;

        height: 12px;

        background: black;

        border-radius: 50%;

        top: 50%;

        left: 50%;

        transform: translate(-50%, -50%);

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

  </style>
@php

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
    



@endphp
  <div class="accordion" id="paymentAccordion">


    
    <div class="card mb-0 shadow-none p-0 {{  $cod_method ? 'd-block' : 'd-none' }}" style="border: 1px solid #c1c1c1;">
        <div class="card-header p-0" id="cash_on_deliveryHeading">
          
            <button class="btn btn-link text-decoration-none w-100 p-0 "  type="button" data-toggle="collapse" data-target="#cash_on_delivery">
              <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                  <div class="  text-dark d-flex align-items-center mb-0">
                    <input type="radio" class=" mb-0 me-2" name="payment_method" value="cash_on_delivery" checked> Cash On Delivery
                  </div>
                  <span>
                      <img src="https://cdn-icons-png.flaticon.com/512/936/936810.png" style="width: 35px; height: auto" alt="Discover">
                  </span>
              </label>
            </button>
          
        </div>
        <div id="cash_on_delivery" class="collapse show {{  $cod_method ? '' : 'd-none' }}" aria-labelledby="cash_on_deliveryHeading" data-parent="#paymentAccordion">
          <div class="card-body payment-method-details p-0 m-0">
         
          </div>
        </div>
      </div>
      <div class="card mb-0 shadow-none p-0 {{  $mobilewallet_method ? 'd-block' : 'd-none' }}" style="border: 1px solid #c1c1c1;">
        <div class="card-header p-0" id="mobile_walletHeading">
          
            <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#mobile_wallet">
              <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                  <div class="  text-dark d-flex align-items-center mb-0">
                    <input type="radio" class=" mb-0 me-2" name="payment_method" value="mobile_wallet"> Mobile Wallet
                  </div>
                  <span>
                      <img src="https://cdn-icons-png.flaticon.com/512/1796/1796819.png" style="width: 35px; height: auto" alt="Discover">
                    </span>
                </label>
            </button>
          
        </div>
        <div id="mobile_wallet" class="collapse {{  $mobilewallet_method ? '' : 'd-none' }}" aria-labelledby="mobile_walletHeading" data-parent="#paymentAccordion">
          <div class="card-body payment-method-details p-4 bg-light">
            You will be redirected to PayPal to complete your purchase securely.
          </div>
        </div>
      </div>

      <!-- Credit Card Option -->
 <div class="card mb-0 shadow-none p-0 {{  $card_method ? 'd-block' : 'd-none' }}" style="border: 1px solid #c1c1c1;">
    <div class="card-header p-0" id="creditCardHeading">
      
        <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#creditCard" aria-expanded="true">
          <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
            <div class="  text-dark d-flex align-items-center mb-0">
            
              <input type="radio" class=" mb-0 me-2" name="payment_method" value="credit_card"  > Credit / Debit Card
            </div>
            <span>
              <img src="https://img.icons8.com/color/48/visa.png" alt="Visa">
              <img src="https://img.icons8.com/color/48/mastercard.png" alt="MasterCard">
              <img src="https://img.icons8.com/color/48/amex.png" alt="Amex">
              <img src="https://img.icons8.com/color/48/discover.png" alt="Discover">
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
    <!-- PayPal Option -->
    <div class="card mb-0 shadow-none p-0" style="border: 1px solid #c1c1c1;">
      <div class="card-header p-0" id="direct_bank_transferHeading">
        
          <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#direct_bank_transfer">
            <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                <div class="  text-dark d-flex align-items-center mb-0">
                  <input type="radio" class=" mb-0 me-2" name="payment_method" value="direct_bank_transfer"> Direct Bank Transfer
                </div>
                <span>
                    <img src="https://dogmovers.com.au/app/uploads/2021/03/Bank-transfer-logo-250x160-1.png" style="width: 45px; height: auto" alt="Discover">
                  </span>
              </label>
          </button>
        
      </div>
      <div id="direct_bank_transfer" class="collapse" aria-labelledby="direct_bank_transferHeading" data-parent="#paymentAccordion">
        <div class="card-body payment-method-details p-4 bg-light">
          You will be redirected to PayPal to complete your purchase securely.
        </div>
      </div>
    </div>
 
    <div class="card mb-0 shadow-none p-0" style="border: 1px solid #c1c1c1;">
        <div class="card-header p-0" id="bighouz_walletHeading">
          
            <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#bighouz_wallet">
              <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                  <div class="  text-dark d-flex align-items-center mb-0">
                    <input type="radio" class=" mb-0 me-2" name="payment_method" value="bighouz_wallet"> Bighouz Wallet
                  </div>
                  <span>
                      <img src="{{ asset('/public/assets/img/main-lamp-pic.jpeg') }}" style="width: 45px; height: auto" alt="Discover">
                    </span>
                </label>
            </button>
          
        </div>
        <div id="bighouz_wallet" class="collapse" aria-labelledby="mobile_walletHeading" data-parent="#paymentAccordion">
          <div class="card-body payment-method-details p-4 bg-light">
            You will be redirected to PayPal to complete your purchase securely.
          </div>
        </div>
      </div>
    <div class="card mb-0 shadow-none p-0" style="border: 1px solid #c1c1c1;">
        <div class="card-header p-0" id="cash_on_counterHeading">
          
            <button class="btn btn-link text-decoration-none w-100 p-0 collapsed" type="button" data-toggle="collapse" data-target="#cash_on_counter">
              <label class="payment-method-header d-flex justify-content-between w-100 mb-0 p-2 px-3">
                  <div class="  text-dark d-flex align-items-center mb-0">
                    <input type="radio" class=" mb-0 me-2" name="payment_method" value="cash_on_counter"> Cash On Counter
                  </div>
                  <span>
                      <img src="https://www.pngkey.com/png/full/11-114087_cash-in-hand-icon.png" style="width: 45px; height: auto" alt="Discover">
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