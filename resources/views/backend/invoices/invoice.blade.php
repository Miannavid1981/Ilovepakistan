@php
    use Illuminate\Support\Facades\URL;
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
    <title>Bighouz Invoice</title>
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
            padding: 10px 20px;
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
            aspec-ratio: 1/1 
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
            padding: 10px 20px;
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

        table.noborder > tr >  th ,  table.noborder  > tr >  td {
            border: unset !important;
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
            aspect-ratio: 1 / 1;
            vertical-align: middle !important
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
    <div class="watermark">{{ strtoupper($payment_status) }}</div>
    <div class="container">
        <table class="page-head" >
            <tr>
                <td>
                   <img src="{{ $logo_url }}" alt="Logo" style="width: 100px">
                   <br>
                  


                   <b> Bighouz E-Business (pvt) Ltd. </b>
                   <br>
                    <span style="text-align: left">
                        M-42-43, Zainab Towers. Link Road, Model Town.
                        <br> 
                        Lahore 54700
                        <br>
                        04235942626-145
                    </span>
                </td>
                <td style="text-align:end; ">
                    <h3 style="text-align: end">
                       SALES INVOICE
                    </h3>
                    <br>
                    <strong  style="text-align: end">Invoice #:</strong>  {{ $main_order_id }} </span><br>
                   
                </td>
                <td style="width: 90px">
                   <div style="aspec-ratio: 1 / 1">
                    @php
                    $removedXML = '<?xml version="1.0" encoding="UTF-8"?>';
                    @endphp
                    {!! str_replace($removedXML, '', QrCode::size(100)->generate($order->id)) !!}
                   </div>
                </td>
            </tr>
        </table>
        <div class="alert">
            Thank you for your order. This invoice reflects the purchased products/services as per your order details, including applicable taxes and fees.
        </div>
        @php
            $shipping_address = json_decode($orders[0]->shipping_address);
        @endphp

        <table>
            <tr>
                <td width="50%">
                   
                    <strong>Delivery type:</strong> <span style="text-transform:capitalize"> {{ str_replace("_", " ", $combined_order->order_type ) }} </span><br>
                    <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($combined_order->created_at)->format('F j, Y \a\t h:i A') }}<br>
                    <strong>Print Date:</strong> {{ \Carbon\Carbon::now()->format('F j, Y \a\t h:i A') }}

                </td>
                <td width="50%">
                    
                  
                    <strong>Customer Name:</strong> {{ $order->user->name }}<br>
                    <strong>E-mail:</strong> {{ $order->user->email }}<br>
                    <strong>Phone:</strong> {{ $order->user->phone }}<br>
                </td>
            </tr>
        </table>

        <table class="noborder" >
            <tr>
                <td style="vertical-align:top">
                    <table>
                      <tr>
                        <td style="vertical-align: text-top;">
                          <div style="background: #ffd9e8 url(https://cdn0.iconfinder.com/data/icons/commerce-line-1/512/comerce_delivery_shop_business-07-128.png);width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 42px;"></div>   
                        </td>
                      
                            
                        <td>
                          <strong>Shipping Address</strong><br>
                          {{ $shipping_address->name }}<br>
                          {{ $shipping_address->address }}, {{ $shipping_address->city }}, {{ $shipping_address->country }}<br>
                          {{ $shipping_address->email }}<br>
                          {{ $shipping_address->phone }}
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td style="vertical-align:top">
                    <table>
                      <tr>
                        <td style="vertical-align: text-top;">
                          <div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/app-custom-ui-1/48/Check_circle-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;"></div>   
                        </td>
                        <td style="vertical-align:top">
                          <strong>Payment Method</strong><br>
                           <!--Your checkout made by VISA Card <br>**** **** **** 2478<br>-->
                           <span style="text-transform:capitalize"> {{ str_replace("_", " ",$combined_order->payment_method ) }} </span><br>
                           @if($combined_order->payment_method == 'direct_bank_transfer')
                            <strong>Transfer Method:</strong> {{ str_replace("_", " ",$combined_order->payment_bank ) }} <br>
                           @endif
                        </td>
                      </tr>
                    </table>
                  </td>
               
               
            </tr>
        </table>

        <table style="margin-top: 20px">
            <tr>
                <th>Item</th>
                <th style="min-width: 100px">Est. Delivery</th>
                <th>Qty</th>
                <th style="min-width: 50px">Price</th>
                <th style="min-width: 50px">Tax</th>
                <th style="min-width: 50px">Total</th>
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
                            <span style="font-size: 11px;">SKIN: {{ $orderDetail->item_enc_skin }}</span>
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

        <table style="margin-top: 20px">
            <tr>
                <td ><strong>Sub-total:</strong></td>
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
                <td><h3 style="margin: 0">Grand total:</h3></td>
                <td><h3 style="margin: 0">{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('price') + $order->orderDetails->sum('tax'); })) }}</h3></td>
            </tr>
        </table>

        
        <div class="socialmedia" style="margin-top: 20px">Follow us online <small>[FB] [INSTA]</small></div>


        <p>
            This is system generated Invoice not Required any Stamp or Signature
        </p>
        <hr>
        <p>{{ url()->full() }}</p>
    </div>
</body>

</html>

