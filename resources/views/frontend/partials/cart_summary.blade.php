<div class="card rounded-0 border shadow-none">

    <div class="card-header pt-4 pb-1 border-bottom-0">
        <h3 class="fs-16 fw-700 mb-0">{{ translate('Summary') }}</h3>
        <div class="text-right">
            <!-- Items Count -->
            <span class="badge badge-inline badge-primary fs-12 rounded-0 px-2">
                {{ count($carts) }}
                {{ translate('Items') }}
            </span>
            
            <!-- Minimum Order Amount -->
            @php
                $coupon_discount = 0;
            @endphp
            @if (Auth::check() && get_setting('coupon_system') == 1)
                @php
                    $coupon_code = null;
                @endphp

                @foreach ($carts as $key => $cartItem)
                    @php
                        $product = get_single_product($cartItem['product_id']);
                    @endphp
                    @if ($cartItem->coupon_applied == 1)
                        @php
                            $coupon_code = $cartItem->coupon_code;
                            break;
                        @endphp
                    @endif
                @endforeach

                @php
                    $coupon_discount = carts_coupon_discount($coupon_code);
                @endphp
            @endif

            @php $subtotal_for_min_order_amount = 0; @endphp
            @foreach ($carts as $key => $cartItem)
                @php $subtotal_for_min_order_amount += cart_product_price($cartItem, $cartItem->product, false, false) * $cartItem['quantity']; @endphp
            @endforeach
            @if (get_setting('minimum_order_amount_check') == 1 && $subtotal_for_min_order_amount < get_setting('minimum_order_amount'))
                <span class="badge badge-inline badge-primary fs-12 rounded-0 px-2">
                    {{ translate('Minimum Order Amount') . ' ' . single_price(get_setting('minimum_order_amount')) }}
                </span>
            @endif
            
        </div>
    </div>

    <!-- Club point -->
    @if (addon_is_activated('club_point'))
    <div class="px-4 pt-1 w-100 d-flex align-items-center justify-content-between">
        <h3 class="fs-14 fw-700 mb-0">{{ translate('Total Clubpoint') }}</h3>
        <div class="text-right">
            <span class="badge badge-inline badge-warning fs-12 rounded-0 px-2 text-white">
                @php
                    $total_point = 0;
                @endphp
                @foreach ($carts as $key => $cartItem)
                    @php
                        $product = get_single_product($cartItem['product_id']);
                        $total_point += $product->earn_point * $cartItem['quantity'];
                    @endphp
                @endforeach

                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" class="mr-2">
                    <g id="Group_23922" data-name="Group 23922" transform="translate(-973 -633)">
                      <circle id="Ellipse_39" data-name="Ellipse 39" cx="6" cy="6" r="6" transform="translate(973 633)" fill="#fff"/>
                      <g id="Group_23920" data-name="Group 23920" transform="translate(973 633)">
                        <path id="Path_28698" data-name="Path 28698" d="M7.667,3H4.333L3,5,6,9,9,5Z" transform="translate(0 0)" fill="#f3af3d"/>
                        <path id="Path_28699" data-name="Path 28699" d="M5.33,3h-1L3,5,6,9,4.331,5Z" transform="translate(0 0)" fill="#f3af3d" opacity="0.5"/>
                        <path id="Path_28700" data-name="Path 28700" d="M12.666,3h1L15,5,12,9l1.664-4Z" transform="translate(-5.995 0)" fill="#f3af3d"/>
                      </g>
                    </g>
                </svg>
                {{ $total_point }}
            </span>
        </div>
    </div>
    @endif

    <div class="card-body">
        <!-- Products Info -->
        <table class="table">
            <thead>
                <tr>
                    <th class="product-name border-top-0 border-bottom-1 pl-0 fs-12 fw-400 opacity-60">{{ translate('Product') }}</th>
                    <th class="product-total text-right border-top-0 border-bottom-1 pr-0 fs-12 fw-400 opacity-60">{{ translate('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;
                    $product_shipping_cost = 0;
                    $shipping_region = $shipping_info['city'];
                @endphp
                @foreach ($carts as $key => $cartItem)
                    @php
                        $product = get_single_product($cartItem['product_id']);
                        $product_name_with_choice = ''; // Default value for product name
                    
                        // Check if the product was found
                        if ($product) {
                            // Always set the product name with choice, even if checked != 1
                            $product_name_with_choice = $product->getTranslation('name');
                            if ($cartItem['variant'] != null) {
                                $product_name_with_choice .= ' - ' . $cartItem['variant'];
                            }
                    
                            // Only perform calculations if the cart item is checked
                            if ($cartItem['checked'] == 1) {
                                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                                $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                                $product_shipping_cost = $cartItem['shipping_cost'];
                                $shipping += $product_shipping_cost;
                            }
                        } else {
                            // Handle the case where the product does not exist
                            $product_name_with_choice = 'Product not found';
                        }
                    @endphp

                    <tr class="cart_item">
                        <td class="product-name pl-0 fs-14 text-dark fw-400 border-top-0 border-bottom">
                            <div class="form-check">
                              <!--<input class="form-check-input" type="checkbox" value="" id="choose_product" {{ $cartItem['checked'] == 1 ? 'checked' : '' }}>-->
                              <input class="form-check-input" type="checkbox" value="" id="choose_product" {{ $cartItem['checked'] == 1 ? 'checked' : '' }} data-cart-id="{{ $cartItem['id'] }}"> 
                              <label class="form-check-label" for="choose_product">
                                {{ $product_name_with_choice }}
                                <strong class="product-quantity">
                                    × {{ $cartItem['quantity'] }}
                                </strong>
                              </label>
                              <!--<div class="available-amount opacity-60">-->
                              <!--      (<span id="available-quantity-{{ $cartItem['id'] }}">{{ $product->current_stock }}</span>)-->
                              <!--  </div>-->
                            </div>
                            <div class="product-quantity d-flex align-items-center">
                                <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                    <button class="btn col-auto btn-icon btn-sm btn-light rounded-0 quantity-change" 
                                            type="button" 
                                            data-type="minus" 
                                            data-cart-id="{{ $cartItem['id'] }}">
                                        <i class="las la-minus"></i>
                                    </button>
                                
                                    <input type="number" 
                                           name="quantity" 
                                           id="quantity-{{ $cartItem['id'] }}" 
                                           class="col border-0 text-center flex-grow-1 fs-16 input-number" 
                                           placeholder="1" 
                                           value="{{ $cartItem['quantity'] }}" 
                                           min="1" 
                                           max="{{ $product->current_stock }}" 
                                           lang="en" 
                                           data-cart-id="{{ $cartItem['id'] }}">
                                
                                    <button class="btn col-auto btn-icon btn-sm btn-light rounded-0 quantity-change" 
                                            type="button" 
                                            data-type="plus" 
                                            data-cart-id="{{ $cartItem['id'] }}">
                                        <i class="las la-plus"></i>
                                    </button>
                                </div>
                                <a class="ml-2 text-danger delete-item" data-cart-id="{{ $cartItem['id'] }}" style="font-size: 18px;">
                                    <i class="las la-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                        <td class="product-total text-right pr-0 fs-14 text-primary fw-600 border-top-0 border-bottom">
                            <span
                                class="pl-4 pr-0">{{ single_price(cart_product_price($cartItem, $cartItem->product, false, false) * $cartItem['quantity']) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <input type="hidden" id="sub_total" value="{{ $subtotal }}">

        <table class="table" style="margin-top: 2rem!important;">
            <tfoot>
                <!-- Subtotal -->
                <tr class="cart-subtotal">
                    <th class="pl-0 fs-14 pt-0 pb-2 text-dark fw-600 border-top-0">{{ translate('Subtotal') }}</th>
                    <td class="text-right pr-0 fs-14 pt-0 pb-2 fw-600 text-primary border-top-0">
                        <span class="fw-600">{{ single_price($subtotal) }}</span>
                    </td>
                </tr>
                <!-- Tax -->
                <tr class="cart-shipping">
                    <th class="pl-0 fs-14 pt-0 pb-2 text-dark fw-600 border-top-0">{{ translate('Tax') }}</th>
                    <td class="text-right pr-0 fs-14 pt-0 pb-2 fw-600 text-primary border-top-0">
                        <span class="fw-600">{{ single_price($tax) }}</span>
                    </td>
                </tr>
                <!-- Total Shipping -->
                <tr class="cart-shipping">
                    <th class="pl-0 fs-14 pt-0 pb-2 text-dark fw-600 border-top-0">{{ translate('Total Shipping') }}</th>
                    <td class="text-right pr-0 fs-14 pt-0 pb-2 fw-600 text-primary border-top-0">
                        <span class="fw-600">{{ single_price($shipping) }}</span>
                    </td>
                </tr>
                <!-- Redeem point -->
                @if (Session::has('club_point'))
                    <tr class="cart-shipping">
                        <th class="pl-0 fs-14 pt-0 pb-2 text-dark fw-600 border-top-0">{{ translate('Redeem point') }}</th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 fw-600 text-primary border-top-0">
                            <span class="fw-600">{{ single_price(Session::get('club_point')) }}</span>
                        </td>
                    </tr>
                @endif
                <!-- Coupon Discount -->
                @if ($coupon_discount > 0)
                    <tr class="cart-shipping">
                        <th class="pl-0 fs-14 pt-0 pb-2 text-dark fw-600 border-top-0">{{ translate('Coupon Discount') }}</th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 fw-600 text-primary border-top-0">
                            <span class="fw-600">{{ single_price($coupon_discount) }}</span>
                        </td>
                    </tr>
                @endif

                @php
                    $total = $subtotal + $tax + $shipping;
                    if (Session::has('club_point')) {
                        $total -= Session::get('club_point');
                    }
                    if ($coupon_discount > 0) {
                        $total -= $coupon_discount;
                    }
                @endphp
                <!-- Total -->
                <tr class="cart-total">
                    <th class="pl-0 fs-14 text-dark fw-600"><span class="strong-600">{{ translate('Total') }}</span></th>
                    <td class="text-right pr-0 fs-14 fw-600 text-primary">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Remove Redeem Point -->
        @if (addon_is_activated('club_point'))
            @if (Session::has('club_point'))
                <div class="mt-3">
                    <form class="" action="{{ route('checkout.remove_club_point') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="form-control">{{ Session::get('club_point') }}</div>
                            <div class="input-group-append">
                                <button type="submit"
                                    class="btn btn-primary">{{ translate('Remove Redeem Point') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif

        <!-- Coupon System -->
        @if (Auth::check() && get_setting('coupon_system') == 1)
            @if ($coupon_discount > 0 && $coupon_code)
                <div class="mt-3">
                    <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="form-control">{{ $coupon_code }}</div>
                            <div class="input-group-append">
                                <button type="button" id="coupon-remove"
                                    class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="mt-3">
                    <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-0" name="code"
                                onkeydown="return event.key != 'Enter';"
                                placeholder="{{ translate('Have coupon code? Apply here') }}" required>
                            <div class="input-group-append">
                                <button type="button" id="coupon-apply"
                                    class="btn btn-primary rounded-0">{{ translate('Apply') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif

    </div>
</div>
