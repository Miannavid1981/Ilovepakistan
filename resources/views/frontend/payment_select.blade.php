@php
    $total = 0;
    
    $carts = get_user_cart();
    if(count($carts) > 0) {
        foreach ($carts as $key => $cartItem) {
            $product = get_single_product($cartItem['product_id']);
            $category_p = $product->category_id;
            if(isset($category_p))
            $category = App\Models\Category::find($category_p);
            $total = $total + cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
        }
    }
    
    $parentCategoryId = null;
    if (isset($category)) {
        if ($category->parentCategory) {
            $parentCategoryId = $category->parentCategory->id;
        }
        if (isset($category->parentCategory->parentCategory)) {
            $parentCategoryId = $category->parentCategory->parentCategory->id;
        }
        if (isset($category->parentCategory->parentCategory->parentCategory)) {
            $parentCategoryId = $category->parentCategory->parentCategory->parentCategory->id;
        }
    }
    
@endphp
@extends('frontend.layouts.app')

@section('content')

    <!-- Steps -->
    <section class="pt-5 mb-4">
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
                        <div class="col active">
                            <div class="text-center border border-bottom-6px p-2 text-success">
                                <i class="la-3x mb-2 las la-credit-card cart-animate" style="margin-right: -100px; transition: 2s;"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('3. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2 text-success">
                                <i class="la-3x mb-2 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('4. Delivery info') }}
                                </h3>
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
    <section class="mb-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-lg-8">
                    <form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST" enctype="multipart/form-data"
                        id="checkout-form">
                        @csrf
                        <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">
                        
                        <div class="card rounded-0 border shadow-none">
                            

                            <div class="card-header p-4 border-bottom-0">
                                <h3 class="fs-16 fw-700 text-dark mb-0">
                                    {{ translate('Select a payment option') }}
                                </h3>
                            </div>
                            <!-- Payment Options -->
                                    <div class="card-body text-center px-4 pt-0">
                                        <div class="row gutters-10">
                                            @if($parentCategoryId == 16)
                                                <!-- Display Bank Transfer if total is over 25,000 -->
                                                @if($total > 25000)
                                                    <div class="col-6 col-xl-3 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="bank_transfer" class="online_payment" type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                                                <img src="{{ static_asset('assets/img/cards/pngegg.png') }}" class="img-fit mb-2" style="height: 65px;">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-600 fs-15">{{ translate('Bank Transfer') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @else
                                                <!-- Display all payment options initially -->
                                                <!-- Display COD only if total is less than or equal to 10,000 -->
                                                @if($total <= 25000)
                                                    <div class="col-6 col-xl-3 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="cash_on_delivery" class="online_payment" type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                                                <img src="{{ static_asset('assets/img/cards/cod.png') }}" class="img-fit mb-2">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-600 fs-15">{{ translate('Cash on Delivery') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                
                                                <!-- Display JazzCash for totals up to 25,000 -->
                                                @if($total <= 50000)
                                                    <div class="col-6 col-xl-3 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="jazzcash" class="online_payment" type="radio" name="payment_option" @if($total < 100000) checked @endif>
                                                            <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                                                <img src="{{ static_asset('assets/img/cards/wallet.png') }}" class="img-fit mb-2" style="height: 65px;">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-600 fs-15">{{ translate('JazzCash') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                
                                                <!-- Always display Bank Transfer as an option, but it's only available and pre-selected when total is over 25,000 -->
                                                <div class="col-6 col-xl-3 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="bank_transfer" class="online_payment" type="radio" name="payment_option" @if($total > 100000) checked @endif>
                                                        <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                                            <img src="{{ static_asset('assets/img/cards/pngegg.png') }}" class="img-fit mb-2" style="height: 65px;">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-600 fs-15">{{ translate('Bank Transfer') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Payment details sections -->
                                        <div id="bank-transfer-details" class="payment-details" style="display: none;">
                                            <p><strong>Bank </strong>: MCB</p>
                                            <p><strong>Account Name </strong>: Solar Dynamics Technologies</p>
                                            <p><strong>Account Number </strong>: 0585376961001725</p>
                                            <p>PK56 MUCB 0585 3769 6100 1725</p>
                                        </div>
                                        <div id="jazzcash-details" class="payment-details" style="display: none;">
                                            <p><strong>Bank </strong>: JazzCash Account</p>
                                            <p><strong>Account Name </strong>: Muhammad Naveed</p>
                                            <p><strong>Account Number </strong>: 0300 0322034</p>
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
                                
                                    <div class="py-4 px-4 text-center bg-soft-warning mt-4">
                                        <img src="https://allaaddin.com/public/uploads/all/1O9DMhKDQStjTVrDJM6SPP0IgJ8K6YGVEuTUmeYr.png
" alt="Logo" style="width: 150px; height: auto; margin-right: 10px;"></br>
    <div class="fs-14 mb-3 d-flex align-items-center justify-content-center">
        <!-- Logo on the left side -->
        
        
        <!-- Wallet balance text -->
        <span class="opacity-80">{{ translate('Or, Your Allaaddin wallet balance :') }}</span>
        <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
    </div>
    
    @if (Auth::user()->balance < $total)
        <button type="button" class="btn btn-secondary" disabled>
            {{ translate('Insufficient balance') }}
        </button>
    @else
        <button type="button" onclick="use_wallet()" class="btn btn-primary fs-14 fw-700 px-5 rounded-0">
            {{ translate('Pay with wallet') }}
        </button>
    @endif
</div>
                                @endif
                            </div>
                            <!-- Additional Info -->
                            <div class="card-header p-4 border-bottom-0">
                                <h3 class="fs-16 fw-700 text-dark mb-0">
                                    {{ translate('Any additional info?') }}
                                </h3>
                            </div>
                            <div class="form-group px-4">
                                <textarea name="additional_info" rows="5" class="form-control rounded-0" placeholder="{{ translate('Type your text...') }}"></textarea>
                            </div>
                            <!-- Agree Box -->
                            <div class="pt-3 px-4 fs-14">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" required id="agree_checkbox">
                                    <span class="aiz-square-check"></span>
                                    <span>{{ translate('I agree to the') }}</span>
                                </label>
                                <a href="{{ route('terms') }}" class="fw-700">{{ translate('terms and conditions') }}</a>,
                                <a href="{{ route('returnpolicy') }}" class="fw-700">{{ translate('return policy') }}</a> &
                                <a href="{{ route('privacypolicy') }}" class="fw-700">{{ translate('privacy policy') }}</a>
                            </div>

                            <div class="row align-items-center pt-3 px-4 mb-4">
                                <!-- Return to shop -->
                                <div class="col-6">
                                    <a href="{{ route('home') }}" class="btn btn-link fs-14 fw-700 px-0">
                                        <i class="las la-arrow-left fs-16"></i>
                                        {{ translate('Return to Back') }}
                                    </a>
                                </div>
                                <!-- Complete Ordert -->
                                <div class="col-6 text-right">
                                    <button type="button" onclick="submitOrder(this)"
                                        class="btn btn-primary fs-14 fw-700 rounded-0 px-4">{{ translate('Continue to Delivery') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-4 mt-lg-0 mt-4" id="cart_summary">
                    @include('frontend.partials.cart_summary')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
       <script type="text/javascript">
       
    //   function deleteCartItem(cartItemId) {
    //         if (confirm('Are you sure you want to remove this item from your cart?')) {
    //             $.ajax({
    //                 url: '{{ route("cart.delete") }}',
    //                 type: 'DELETE',
    //                 data: {
    //                     _token: '{{ csrf_token() }}',
    //                     cart_id: cartItemId
    //                 },
    //                 success: function(response) {
    //                     if (response.success) {
    //                         // Check if cart count is zero
    //                         if (response.cartCount === 0) {
    //                             // Redirect to home if cart is empty
    //                             window.location.href = '{{ route("home") }}';
    //                         } else {
    //                             // Otherwise, reload the page to update the cart view
    //                             location.reload();
    //                         }
    //                     } else {
    //                         alert('Failed to delete item from cart.');
    //                     }
    //                 },
    //                 error: function(xhr) {
    //                     console.error(xhr.responseText);
    //                     alert('An error occurred while deleting the item.');
    //                 }
    //             });
    //         }
    //     }
        $(document).ready(function() {
            // Quantity change
             $('.quantity-change').on('click', function() {
    const $button = $(this); // The clicked button
    const cartId = $button.data('cart-id'); // Unique cart ID for the item
    const type = $button.data('type'); // "plus" or "minus" type

    // Use the unique ID to select the specific input field
    const $input = $(`#quantity-${cartId}`);
    
    // Parse the current quantity and set the new quantity based on the button type
    let newQuantity = parseInt($input.val(), 10);

    // Adjust quantity based on button type
    if (type === 'plus') {
        newQuantity += 1; // Increase by 1 if "plus" button is clicked
    } else if (type === 'minus' && newQuantity > 1) {
        newQuantity -= 1; // Decrease by 1 if "minus" button is clicked and quantity > 1
    }

    const maxQuantity = parseInt($input.attr('max'), 10);

    // Check if the new quantity exceeds max quantity
    if (newQuantity <= maxQuantity) {
        // Update only the input field with the specific ID
        $input.val(newQuantity);

        // Call updateCartQuantity function for only this product's cart ID and new quantity
        updateCartQuantity(cartId, newQuantity);
    } else {
        alert('Exceeds available stock');
    }
});



        
            // AJAX call to update quantity
            function updateCartQuantity(cartId, quantity) {
                $.ajax({
                    url: '{{ route("cart.update.quantity") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_id: cartId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();  // Refresh to show updated totals
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Error updating cart quantity.');
                    }
                });
            }
        
            // Delete item
            $('.delete-item').on('click', function() {
                const cartId = $(this).data('cart-id');
        
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    $.ajax({
                        url: '{{ route("cart.delete") }}',
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            cart_id: cartId
                        },
                        success: function(response) {
                            if (response.success) {
                                if (response.cartCount === 0) {
                                    window.location.href = '{{ route("home") }}';
                                } else {
                                    location.reload();
                                }
                            } else {
                                alert(response.message || 'Failed to delete item from cart.');
                            }
                        },
                        error: function() {
                            alert('Error deleting cart item.');
                        }
                    });
                }
            });
        });


       
        $(document).ready(function () {
            $(document).on('change', '#choose_product', function () {
                let isChecked = $(this).is(':checked') ? 1 : 0;
                let cartId = $(this).data('cart-id');
                
                // console.log('Checkbox changed, new value:', isChecked);
        
                // AJAX request to update the checked status
                $.ajax({
                    url: '{{ route("checkout.updateCheckedStatus") }}',  // Laravel route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_id: cartId,
                        checked: isChecked
                    },
                    success: function (response) {
                        window.location.reload();
                        // alert(response.message);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });

       
    $(document).ready(function() {
         $('input[name="payment_option"]').on('change', function() {
        // Hide all payment details initially
        $('.payment-details').hide();

        // Check the selected payment option and show/hide corresponding details
        if($(this).val() === 'bank_transfer') {
            $('#bank-transfer-details').show();
        } else if($(this).val() === 'jazzcash') {
            $('#jazzcash-details').show();
        }
    });

    // Trigger change event on page load to show the correct details
    // for the initially selected payment option
    $('input[name="payment_option"]:checked').trigger('change');

        $(".online_payment").click(function() {
            // Hide manual payment description when an online payment option is clicked
            $('#manual_payment_description').parent().addClass('d-none');
        });

        var minimum_order_amount_check = {{ get_setting('minimum_order_amount_check') == 1 ? 1 : 0 }};
        var minimum_order_amount = {{ get_setting('minimum_order_amount_check') == 1 ? get_setting('minimum_order_amount') : 0 }};

         window.submitOrder = function(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    var offline_payment_active = '{{ addon_is_activated('offline_payment') }}';
                    if (offline_payment_active == '1' && $('.offline_payment_option').is(":checked") && $('#trx_id').val() == '') {
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

        $(document).on("click", "#coupon-apply", function() {
            var data = new FormData($('#apply-coupon-form')[0]);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
            });
        });

        $(document).on("click", "#coupon-remove", function() {
            var data = new FormData($('#remove-coupon-form')[0]);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                url: "{{ route('checkout.remove_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $("#cart_summary").html(data);
                }
            });
        });
    });
</script>
@endsection
