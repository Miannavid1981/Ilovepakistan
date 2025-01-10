<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Invoice</title>
    <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
    <style media="all">
        @font-face {
            font-family: 'Roboto';
            src: url("{{ static_asset('fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: 'Roboto', sans-serif;
            color: #333542;
        }

        body {
            font-size: .875rem;
        }

        .gry-color,
        .gry-color * {
            color: #878f9c;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
        }

        .payment_type p {
            text-align: left;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            opacity: 0.1;
            font-size: 6rem;
            transform: translate(-50%, -50%) rotate(-45deg);
            /* Adjust the angle here */
            z-index: -1;
            color: rgb(167, 167, 167);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- <div class="watermark">Unpaid</div> -->
    <div>
        @php
            $logo = get_setting('header_logo');
            $domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        @endphp
        <div style="background: #eceff4; padding: 1.5rem;">
            <!-- Logo Section -->
            <table style="width: 100%;">
                <tr>
                    <td>
                        {{-- @if ($logo != null)
                        <img loading="lazy" src="{{ uploaded_asset($logo) }}" height="40" style="display: inline-block;">
                        @else
                        <img loading="lazy" src="{{ static_asset('assets/img/logo.png') }}" height="40" style="display: inline-block;">
                        @endif --}}
                        <img src="{{ $domain }}/public/uploads/all/alladdin.png" alt="Logo" height="40"
                            style="display: inline-block;">
                    </td>

                </tr>
            </table>

            <!-- Information Section -->
            <table style="width: 100%; margin-top: 1rem;">
                <!-- Site Name Row -->
                <tr>
                    <td colspan="2" style="font-size: 1.2rem; text-align:right;" class="strong">
                        {{ get_setting('site_name') }}
                    </td>
                </tr>

                <!-- Address and Order Details Row -->
                <tr>
                    <td class="gry-color small" style="vertical-align: top; padding: 5px;">
                        {{ get_setting('contact_address') }}
                    </td>

                </tr>

                <!-- Email, Phone, and Order Info Row -->
                <tr>
                    <td class="gry-color small" style="vertical-align: top; padding: 5px;">
                        {{ translate('Email') }}: order@allaaddin.com<br>
                        {{ translate('Phone') }}: 042 35942626-145
                    </td>
                    <td class="text-right small" style="vertical-align: top; padding: 5px; white-space: nowrap;">
                        {{ translate('Order ID') }}: <span class="strong">{{ $orders[0]->code }}</span><br>
                        {{ translate('Order Date') }}: <span class="strong">{{ date('d-m-Y', $orders[0]->date) }}</span>
                    </td>
                </tr>
            </table>

        </div>


        <!-- Shipping Address -->
        <div style="padding: 1.5rem; padding-bottom: 0;">
            <table>
                @php
                    $shipping_address = json_decode($orders[0]->shipping_address);
                @endphp
                <tr>
                    <td class="strong small gry-color">{{ translate('Bill to') }}:</td>
                </tr>
                <tr>
                    <td class="strong">{{ $shipping_address->name }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ $shipping_address->address }}, {{ $shipping_address->city }},
                        {{ $shipping_address->country }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ translate('Email') }}: {{ $shipping_address->email }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ translate('Phone') }}: {{ $shipping_address->phone }}</td>
                </tr>
                <tr>
                    @if (isset($orders[1]))
                        <td class="gry-color small">
                            Delivery Type :{{ $orders[1]->orderDetails()->first()->shipping_type ?? 'Home Delivery' }}
                        </td>
                        @else
                        <td class="gry-color small">
                            Delivery Type :{{ $orders[0]->orderDetails()->first()->shipping_type ?? 'Home Delivery' }}
                        </td>
                    @endif

                </tr>

            </table>
        </div>

        <div style="padding: 1.5rem;">
            <table class="padding text-left small border-bottom">
                <thead>
                    <tr class="gry-color" style="background: #eceff4;">
                        <th width="30%">{{ translate('Product Name') }}</th>
                        <th width="8%">SKU</th>
                        <th width="12%">{{ translate('Est. Delivery(Days)') }}</th>
                        <th width="10%">{{ translate('Qty') }}</th>
                        <th width="15%">{{ translate('Unit Price') }}</th>
                        <th width="10%">{{ translate('Tax') }}</th>
                        <th width="15%" class="text-right">{{ translate('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @php
                        $deliverytype = $orders[0]->orderDetails->value('shipping_type');
                    @endphp
                    @foreach ($orders as $order)
                        @foreach ($order->orderDetails as $key => $orderDetail)
                            <tr>
                                <td class="items">
                                    {{ $orderDetail->product ? $orderDetail->product->getTranslation('name') : translate('Product Unavailable') }}
                                    @if ($orderDetail->combo_id != null)
                                        @php
                                            $combo = \App\ComboProduct::findOrFail($orderDetail->combo_id);
                                            echo '(' . $combo->combo_title . ')';
                                        @endphp
                                    @endif
                                </td>
                                <td>{{ $orderDetail->product->stocks->first()->sku }} {{ $orderDetail->product->id }}
                                </td>
                                <td>{{ $orderDetail->product->est_shipping_days }} days</td>
                                <td class="gry-color">{{ $orderDetail->quantity }}</td>
                                <td class="gry-color currency">
                                    {{ single_price($orderDetail->price / $orderDetail->quantity) }}</td>
                                <td class="gry-color currency">{{ single_price($orderDetail->tax) }}</td>
                                <td class="text-right currency">
                                    {{ single_price($orderDetail->price + $orderDetail->tax) }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div style="padding: 0 1.5rem; display: flex; justify-content: space-between; flex-wrap: wrap;">
            <div style="width: 48%; padding-right: 1rem;" class="text-right sm-padding small strong">
                <table style="width: 100%;" class="text-right sm-padding small strong">
                    <tbody>
                        <tr>
                            <td class="currency payment_type">
                                @if ($orders[0]->payment_type == 'bank_transfer')
                                    <p><b>Payment Type:Bank Transfer</b></p>
                                    <p><b>Bank:</b> MCB</p>
                                    <p><b>Account Name:</b> Solar Dynamics Technologies</p>
                                    <p><b>Account Number:</b> 0585376961001725</p>
                                    <p><b>IBAN:</b> PK56 MUCB 0585 3769 6100 1725</p>
                                @elseif ($orders[0]->payment_type == 'jazzcash')
                                    <p><b>Payment Type:</b> JazzCash</p>
                                    <p><b>Account Name:</b> Muhammad Naveed</p>
                                    <p><b>Account Number:</b> 0300 0322034</p>
                                @else
                                    <p><b>Payment Type:</b> Cash on Delivery</p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="width: 48%;" class="text-right sm-padding small strong">
                <table style="width: 100%;" class="text-right sm-padding small strong">
                    <tbody>
                        <tr>
                            <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
                            <td class="currency">
                                {{ single_price($orders->sum(function ($order) {return $order->orderDetails->sum('price');})) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="gry-color text-left">{{ translate('Shipping Cost') }}</th>
                            <td class="currency">
                                {{ single_price($orders->sum(function ($order) {return $order->orderDetails->sum('shipping_cost');})) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="gry-color text-left">{{ translate('Total Tax') }}</th>
                            <td class="currency">
                                {{ single_price($orders->sum(function ($order) {return $order->orderDetails->sum('tax');})) }}
                            </td>
                        </tr>
                        @if ($orders->first()->coupon_discount > 0)
                            <tr class="border-bottom">
                                <th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
                                <td class="currency">{{ single_price($orders->first()->coupon_discount) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th class="text-left strong">{{ translate('Grand Total') }}</th>
                            <td class="currency">
                                {{ single_price($orders->sum(function ($order) {return $order->grand_total;})) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



    </div>
</body>

</html>
