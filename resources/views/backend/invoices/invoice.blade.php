@php
    $logo = get_setting('header_logo');
    $logo_url = uploaded_asset($logo);

    $orders = $order->orders;

    $main_order_id = 'BH000'.$order->id;
    $combined_order = $order;

    $payment_status = $orders[0]->payment_status;
@endphp

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

        body {
            font-family: Helvetica, sans-serif;
            font-size: 13px;
            padding: 0 40px;
        }

        .container {
            max-width: 680px;
            margin: 0 auto;
        }

        .logotype {
            background: #ededed;
            color: #fff;
            width: 75px;
            height: 75px;
            line-height: 75px;
            text-align: center;
            font-size: 11px;
            border-radius: 5px;
        }

        .column-title {
            background: #eee;
            text-transform: uppercase;
            padding: 15px 5px 15px 15px;
            font-size: 11px;
        }

        .column-detail {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .column-header {
            background: #eee;
            text-transform: uppercase;
            padding: 10px 15px;
            font-size: 11px;
            border-right: 1px solid #eee;
        }

        .row {
            padding: 7px 14px;
            border-left: 1px solid #eee;
            border-right: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .alert {
            background: #ffd9e8;
            padding: 20px;
            margin: 20px 0;
            line-height: 22px;
            color: #333;
        }

        .socialmedia {
            background: #eee;
            padding: 20px;
            display: inline-block;
        }

        .logotype img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        @page {
            margin: 0;
        }

        .page-break {
            page-break-before: auto;
        }

        .no-break {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        /* Adjust layout for tables and printing */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td,
        table th {
            border: 1px solid #eee;
            padding: 8px;
            text-align: left;
            vertical-align: top
        }
        table:not(.page-head) td,
        table:not(.page-head) th {
            vertical-align: middle !important
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            /* background-color: #ffd9e8; */
            padding: 10px;
        }

        .status {
            padding: 10px;
            font-size: 22px;
            font-weight: bold;
            background-color: {{ $payment_status == 'paid' ? '#ffd9e8' : '#ffd692' }};
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="page-head" style=" background-color: #ffd9e8;">
            <tr>
                <td width="75px">
                    <div class="logotype"><img src="{{ $logo_url }}" alt="Logo" style="width: 50px"></div>
                </td>
                <td>
                    <div class="invoice-title">
                        Invoice # {{ $main_order_id }}
                    </div>
                    
                    <br>
                </td>
                <td class="status">
                   
                        {{ strtoupper($payment_status) }}
                   
                </td>
            </tr>
        </table>

        @php
            $shipping_address = json_decode($orders[0]->shipping_address);
        @endphp

        <table>
            <tr>
                <td width="50%">
                    <strong>Delivery type:</strong>  {{ str_replace("_", " ", $combined_order->order_type ) }}<br>
                    <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($combined_order->created_at)->format('F j, Y') }}
                  
                
                </td>
                <td width="50%">
                   
                    <strong>Payment Method:</strong>
                    <span style="text-transform:capitalize"> {{ str_replace("_", " ",$combined_order->payment_method ) }} </span><br>
                    @if($combined_order->payment_method == 'direct_bank_transfer')


                     <strong>Transfer Method:</strong> {{ str_replace("_", " ",$combined_order->payment_bank ) }} <br>
                    

                    @endif
                  
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td>
                    <strong>Shipping Address:</strong><br>
                    {{ $shipping_address->name }}<br>
                    {{ $shipping_address->address }}, {{ $shipping_address->city }}, {{ $shipping_address->country }}<br>
                    {{ $shipping_address->email }}<br>
                    {{ $shipping_address->phone }}
                </td>
                <td>
                    <strong>Customer Name:</strong> {{ $shipping_address->name }}<br>
                    <strong>E-mail:</strong> {{ $shipping_address->email }}<br>
                    <strong>Phone:</strong> {{ $shipping_address->phone }}<br>
                   
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Item</th>
                <th>Est. Delivery</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Tax</th>
                <th>Total</th>
            </tr>
            @foreach ($orders as $order)
                @foreach ($order->orderDetails as $key => $orderDetail)
                    @php
                        $brand = $orderDetail->product->brand;
                        $brand_name = '';
                        if ($brand) {
                            $brand_name = $brand->name;
                        }
                    @endphp
                    <tr>
                        <td>
                            <small><b>{{ $brand_name }}</b></small><br>
                            {{ $orderDetail->product->name ?? 'Product Unavailable' }}<br>
                            <span style="font-size: 11px;">{{ $orderDetail->item_enc_skin }}</span>
                        </td>
                        <td>{{ $orderDetail->product->est_shipping_days }} days</td>
                        <td>{{ $orderDetail->quantity }}</td>
                        <td>{{ get_system_default_currency()->code." ". number_format($orderDetail->price / $orderDetail->quantity) }}</td>
                        <td>{{ $orderDetail->tax > 0 ? get_system_default_currency()->code." ". number_format($orderDetail->tax) : 0 }}</td>
                        <td>{{ get_system_default_currency()->code." ". number_format($orderDetail->price + $orderDetail->tax) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>

        <div class="page-break"></div>

        <table>
            <tr>
                <td><strong>Sub-total:</strong></td>
                <td>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('price'); })) }}</td>
            </tr>
            <tr>
                <td><strong>Shipping Charges:</strong></td>
                <td>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('shipping_cost'); })) }}</td>
            </tr>
            <tr>
                <td><strong>Tax:</strong></td>
                <td>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('tax'); })) }}</td>
            </tr>
            <tr>
                <td><strong>Grand total:</strong></td>
                <td>{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('price') + $order->orderDetails->sum('tax'); })) }}</td>
            </tr>
        </table>

        <div class="alert">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
        <div class="socialmedia">Follow us online <small>[FB] [INSTA]</small></div>
    </div>
</body>

</html>

{{-- @dd('') --}}