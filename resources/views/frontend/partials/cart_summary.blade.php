<style>
 #cart_summary   th, #cart_summary  td  {
    border: unset !important
 }
</style>
<div class=" rounded-0 border-0 shadow-none">

    <div class=" pt-4 pb-1 border-bottom-0 px-0 d-flex align-items-center justify-content-between d-none">
        <h5>{{ translate('Summary') }}</h5>
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
            @if (get_setting('coupon_system') == 1)
                @php
                    $coupon_code = null;
                @endphp

                @foreach ($carts as $key => $cartItem)
                    @if ($cartItem->coupon_applied == 1)
                        @php
                            $coupon_code = $cartItem->coupon_code;
                            break;
                        @endphp
                    @endif
                @endforeach

                @php
                    $coupon_discount = $carts->sum('discount');
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
            <span class="badge badge-inline badge-secondary-base fs-12 rounded-0 px-2 text-white">
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

    <div class="">
        <!-- Products Info -->
        <table class="table d-none">
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
                @endphp
                @foreach ($carts as $key => $cartItem)
                    @php
                        $product = get_single_product($cartItem['product_id']);
                        $item_price =discount_in_percentage($product) > 0 ? home_discounted_base_price($product, false)  * $cartItem['quantity'] : home_base_price($product, false) * $cartItem['quantity'] ;
                        $subtotal += $item_price;
                        $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                        $product_shipping_cost = $cartItem['shipping_cost'];

                        $shipping += $product_shipping_cost;

                        $product_name_with_choice = $product->getTranslation('name');
                        if ($cartItem['variant'] != null) {
                            $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem['variant'];
                        }
                    @endphp
                    <tr class="cart_item">
                        <td class="product-name pl-0 fs-14 text-dark fw-400 border-top-0 border-bottom">
                            {{ $product_name_with_choice }}
                            <strong class="product-quantity">
                                × {{ $cartItem['quantity'] }}
                            </strong>
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
                    <th class="pl-0 fs-16 pt-0 pb-2 text-dark fw-300  border-top-0" style="font-family: 'Aeonik-Semibold' !important;">{{ translate('Subtotal') }}</th>
                    <td class="text-right pr-0 fs-16 pt-0 pb-2 fw-300  text-dark border-top-0">
                        <small class="fw-300">{{ currency_symbol() }}</small>
                        <span class="fw-300 " style="font-family: 'Aeonik-Semibold' !important;">{{ number_format($subtotal) }}</span>
                    </td>
                </tr>
                <!-- Tax -->
                <tr class="cart-shipping">
                    <th class="pl-0 fs-16 pt-0 pb-2 text-dark fw-300  border-top-0" style="font-family: 'Aeonik-Semibold' !important;">{{ translate('Tax') }}</th>
                    <td class="text-right pr-0 fs-16 pt-0 pb-2 fw-300  text-dark border-top-0">
                        <small class="fw-300">{{ currency_symbol() }}</small>
                        <span class="fw-300 " style="font-family: 'Aeonik-Semibold' !important;">{{ $tax }}</span>
                    </td>
                </tr>
                <!-- Total Shipping -->
                <tr class="cart-shipping">
                    <th class="pl-0 fs-16 pt-0 pb-2 text-dark fw-300  border-top-0" style="font-family: 'Aeonik-Semibold' !important;">{{ translate('Delivery Charges') }}</th>
                    <td class="text-right pr-0 fs-16 pt-0 pb-2 fw-300  text-dark border-top-0">
                        <small class="fw-300">{{ currency_symbol() }}</small>
                        <span class="fw-300 " style="font-family: 'Aeonik-Semibold' !important;">{{ number_format($shipping)}}</span>
                    </td>
                </tr>
                <!-- Redeem point -->
                @if (Session::has('club_point'))
                    <tr class="cart-shipping">
                        <th class="pl-0 fs-16 pt-0 pb-2 text-dark fw-300  border-top-0" style="font-family: 'Aeonik-Semibold' !important;">{{ translate('Redeem point') }}</th>
                        <td class="text-right pr-0 fs-16 pt-0 pb-2 fw-300  text-dark border-top-0">
                            <small class="fw-300">{{ currency_symbol() }}</small>
                            <span class="fw-300 ">{{ Session::get('club_point') }}</span>
                        </td>
                    </tr>
                @endif
                <!-- Coupon Discount -->
                @if ($coupon_discount > 0)
                    <tr class="cart-shipping">
                        <th class="pl-0 fs-16 pt-0 pb-2 text-dark fw-300  border-top-0" style="font-family: 'Aeonik-Semibold' !important;">{{ translate('Coupon Discount') }}</th>
                        <td class="text-right pr-0 fs-16 pt-0 pb-2 fw-300  text-dark border-top-0">
                            <small>{{ currency_symbol() }}</small>
                            <span class="fw-300 " style="font-family: 'Aeonik-Semibold' !important;">{{ number_format($coupon_discount) }}</span>
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
                    <th class="pl-0 fs-22 text-dark fw-600" ><span class="strong-600" style="font-family: 'Aeonik-Semibold' !important;">{{ translate('Total') }}</span></th>
                    <td class="text-right pr-0 fs-22 fw-600 text-dark">
                        <p>
                            <small class="fw-300">{{ currency_symbol() }}</small>
                            <span style="font-family: 'Aeonik-Semibold' !important;">{{ number_format($total) }}</span>
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>

        
        

    </div>
</div>
