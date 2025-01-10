<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Allaaddin Invoice</title>
    <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
    <style media="all">
        @font-face {
            font-family: 'Roboto';
            src: url("{{ public_path('fonts/Roboto-Regular.ttf') }}") format("truetype");
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
        }/* Watermark styling */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            opacity: 0.1;
            font-size: 6rem;
            transform: translate(-50%, -50%) rotate(-45deg); /* Adjust the angle here */
            z-index: -1;
            color: rgb(167, 167, 167);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
    </style>
</head>

<body>
     <!-- Watermark for unpaid invoices -->
     <div class="watermark">Unpaid</div>
    <div>
        <div style="background: #eceff4; padding: 1.5rem;">
            <!-- Logo Section -->
            <table style="width: 100%;">
                <tr>
                    <td>
                        <img src="{{ public_path('uploads/all/alladdin.png') }}" alt="Logo" height="40" style="display: inline-block;">
                    </td>
                    <td style="text-align: right; font-size: 1.75em">
                        {{ get_setting('site_name') }}
                    </td>
                </tr>
            </table>

            <!-- Information Section -->
            <table style="width: 100%; margin-top: 0rem;">
                <tr>
                    <td colspan="2" style="font-size: 1.2rem; text-align:right;" class="strong">
                        {{ get_setting('contact_address') }}
                    </td>
                </tr>
                <tr>
                    <td class="gry-color small" style="vertical-align: top; padding: 5px; white-space: nowrap;">
                        {{ translate('Email') }}: order@allaaddin.com<br>
                        {{ translate('Phone') }}: 042 35942626-145
                    </td>
                    <td class="text-right small" style="vertical-align: top; padding: 5px; white-space: nowrap;">
                        {{ translate('Order Ref') }}: <span class="strong">*{{ $orders[0]->code }}</span><br>
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
                    <td class="gry-color small">{{ $shipping_address->address }}, {{ $shipping_address->city }}, {{ $shipping_address->country }}</td>
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
                        <th width="8%">SKIN</th>
                        <th width="12%">{{ translate('Est. Delivery') }}</th>
                        <th width="10%">{{ translate('Qty') }}</th>
                        <th width="15%">{{ translate('Unit Price') }}</th>
                        <th width="10%">{{ translate('Tax') }}</th>
                        <th width="15%" class="text-right">{{ translate('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @foreach ($orders as $order)
                    @foreach ($order->orderDetails as $key => $orderDetail)
                    <tr>
                        <td>{{ $orderDetail->product->name ?? translate('Product Unavailable') }}
                            @if ($orderDetail->combo_id != null)
                            @php
                            $combo = \App\Models\ComboProduct::findOrFail($orderDetail->combo_id);
                            echo '(' . $combo->combo_title . ')';
                            @endphp
                            @endif
                        </td>
                        <td>{{ $orderDetail->product->stocks->first()->sku }}</td>
                        <td>{{ $orderDetail->product->est_shipping_days }} days</td>
                        <td>{{ $orderDetail->quantity }}</td>
                        <td>{{ single_price($orderDetail->price / $orderDetail->quantity) }}</td>
                        <td>{{ single_price($orderDetail->tax) }}</td>
                        <td class="text-right">{{ single_price($orderDetail->price + $orderDetail->tax) }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div style="padding: 0 1.5rem;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 48%; vertical-align: top;">
                        <table class="text-left sm-padding small strong">
                            <tr>
                                <td class="payment_type">
                                    @if ($orders[0]->payment_type == 'bank_transfer')
                                    <p><b>Payment Type: Bank Transfer</b></p>
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
                        </table>
                    </td>

                    <td style="width: 48%; vertical-align: top;">
                        <table class="text-right sm-padding small strong">
                            <tr>
                                <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
                                <td>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('price'); })) }}</td>
                            </tr>
                            <tr>
                                <th class="gry-color text-left">{{ translate('Shipping Cost') }}</th>
                                <td>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('shipping_cost'); })) }}</td>
                            </tr>
                            <tr>
                                <th class="gry-color text-left">{{ translate('Total Tax') }}</th>
                                <td>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('tax'); })) }}</td>
                            </tr>
                            <tr>
                                <th class="text-left"><strong>{{ translate('Grand Total') }}</strong></th>
                                <td><strong>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('price') + $order->orderDetails->sum('tax'); })) }}</strong></td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        
    </div>
    <p style="margin-left:5px; margin-top:50px;"><strong>Note: </strong>* This is system generated invoice. Not required any stamp or signature.</p>
</body>

</html>
