@php
		$logo = get_setting('header_logo');
		$logo_url = uploaded_asset($logo);
		
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

        
        body {font-family: Helvetica, sans-serif;font-size:13px;}
        .container{max-width: 680px; margin:0 auto;}
        .logotype{background:#ededed;color:#fff;width:75px;height:75px;  line-height: 75px; text-align: center; font-size:11px; border-radius: 5px;}
        .column-title{background:#eee;text-transform:uppercase;padding:15px 5px 15px 15px;font-size:11px}
        .column-detail{border-top:1px solid #eee;border-bottom:1px solid #eee;}
        .column-header{background:#eee;text-transform:uppercase;padding: 10px 15px;font-size:11px;border-right:1px solid #eee;}
        .row{padding:7px 14px;border-left:1px solid #eee;border-right:1px solid #eee;border-bottom:1px solid #eee;}
        .alert{background: #ffd9e8;padding:20px;margin:20px 0;line-height:22px;color:#333}
        .socialmedia{background:#eee;padding:20px; display:inline-block}
                
        
        .logotype img {
            width: 100%;
            height: 100%;
           object-fit: contain;
        }
        
        @page {
            margin: 0;
        }
          .page-break {
            page-break-before: auto; /* Force new page before this element */
        }
    
        .no-break {
            break-inside: avoid; /* Prevent breaking inside this element */
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
     <!-- Watermark for unpaid invoices -->
     <!--<div class="watermark">Unpaid</div>-->
    
    <div class="container">

  <table width="100%">
    <tr>
      <td width="75px"><div class="logotype"><img src="https://allaaddin.com/public/images/1j+ojFVDOMkX9Wytexe43D6kh.png"></div></td>
      <td width="300px"><div style="background: #ffd9e8;border-left: 15px solid #fff;padding-left: 30px;font-size: 26px;font-weight: bold;letter-spacing: -1px;height: 73px;line-height: 75px; vertical-align: middle;">Invoice # {{ $main_order_id }}</div></td>
      <td>
         <div style="background: {{ $payment_status == 'paid' ? '#ffd9e8' : '#ffd692' }} ;padding: 0 30px;font-size: 22px;font-weight: bold;letter-spacing: -1px;height: 73px;line-height: 75px;border-radius: 6px !important;float:right; vertical-align: middle;">{{ strtoupper($payment_status ) }}</div>
      </td>
    </tr>
  </table> 
  <br>
    @php
        $shipping_address = json_decode($orders[0]->shipping_address);
    @endphp
  <!--<br>-->
  <!--<h3>Your contact details</h3>-->
  <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p><br>-->
  <table width="100%" style="border-collapse: collapse;">
    <tr>
      <td widdth="50%" style="background:#eee;padding:20px;">
        <strong>Date:</strong> {{ $combined_order->created_at }}<br>
        <strong>Payment type:</strong> Credit Card VISA<br>
        <strong>Delivery type:</strong> Postnord<br>
      </td>
      <td style="background:#eee;padding:20px;">
        <strong>Customer Name:</strong> {{ $shipping_address->name }}<br>
        <strong>E-mail:</strong> {{ $shipping_address->email }}<br>
        <strong>Phone:</strong> {{ $shipping_address->phone }}<br>
      </td>
    </tr>
  </table><br>
  <table width="100%">
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
                 Cash on Delivery
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table><br>
  <!--<table width="100%" style="border-top:1px solid #eee;border-bottom:1px solid #eee;padding:0 0 8px 0">-->
  <!--  <tr>-->
  <!--    <td><h3>Payment Method</h3>-->
      <!--Your checkout made by VISA Card **** **** **** 2478-->
      
  <!--    Cash on Delivery-->
  <!--    <td>-->
  <!--  </tr>-->
  <!--</table><br>-->
  <!--<div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/basic-ui-2-line/32/shopping-cart-shop-drop-trolly-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;float: left; margin-bottom: 15px;"></div> -->
  <!--<h3>Your Purchase</h3>-->

   <table width="100%" style="border-collapse: collapse;border-bottom:1px solid #eee;">
     <tr>
       <td width="30%" class="column-header">Item</td>
       <td width="15%" class="column-header">Est. Delivery</td>
       <td width="6%" class="column-header">Qty</td>
       <td width="12%" class="column-header">Price</td>
       <td width="12%" class="column-header">Tax</td>
       <td width="12%" class="column-header">Total</td>
     </tr>
    @foreach ($orders as $order)
        @foreach ($order->orderDetails as $key => $orderDetail)
        
        @php
        $brand = $orderDetail->product->brand;
        $brand_name = '';
        if($brand) {
            $brand_name = $brand->name;
        }
        
        @endphp
             <tr>
               <td class="row">
                   <span style="color:#747474;font-size:11px;font-weight: bold">{{ $brand_name }}</span>
                   <br>
                   {{ $orderDetail->product->name ?? translate('Product Unavailable') }}
                   <br>
                   <span style="color:#777;font-size:11px;">{{ $orderDetail->product->stocks->first()->sku }}</span>
               </td>
               <td class="row">{{ $orderDetail->product->est_shipping_days }} days</td>
               <td class="row">{{ $orderDetail->quantity }} </td>
               <td class="row">{{ number_format($orderDetail->price / $orderDetail->quantity) }}</td>
               <td class="row">{{ number_format($orderDetail->tax) }}</td>
               <td class="row">{{ number_format($orderDetail->price + $orderDetail->tax) }}</td>
             </tr>
        @endforeach
    @endforeach
  </table><br>
  <div class="page-break"></div> <!-- Force a page break if needed -->
<div class="no-break">
    
     <table width="100%" style="background:#eee;padding:10px; 5px " >
        <tr>
            <td style="width: 65%">
                
            </td>
          <td>
            <table style="width: 100%">
              <tr>
                <td><strong>Sub-total:</strong></td>
                <td style="text-align:right">{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('price'); })) }}</td>
              </tr>  
              <tr>
                <td><strong>Shipping Charges:</strong></td>    
                <td style="text-align:right">{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('shipping_cost'); })) }}</td>
              </tr>
              <tr>
                <td><strong>Tax:</strong></td>    
                <td style="text-align:right">{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('tax'); })) }}</td>
              </tr>
              <tr>
                <td><strong>Grand total:</strong></td>    
                <td style="text-align:right">{{ single_price($orders->sum(function($order) { return $order->orderDetails->sum('price') + $order->orderDetails->sum('tax'); })) }}</td>
              </tr>
            </table>
           </td>
        </tr>
      </table>
    
</div>
 
  <div class="alert">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.	</div>
  <div class="socialmedia">Follow us online <small>[FB] [INSTA]</small></div>
</div><!-- container -->
    
    
</body>

</html>
