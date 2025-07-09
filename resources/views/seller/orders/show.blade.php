@extends('seller.layouts.app')

@section('panel_content')
  

                
    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
        </div>

        <div class="card-body">
            <div class="row gutters-5 mb-3">
                <div class="col text-md-left text-center">
                </div>
                @php
                    $orderDetail = $order->orderDetails[0];
                    $delivery_status = $order->delivery_status;
                    $payment_status = $order->payment_status;
                    $this_order_detail = $orderDetail;

                  var_dump($orderDetail->toArray());
                    
                @endphp
                @if (get_setting('product_manage_by_admin') == 0)
                    <div class="col-md-3 ml-auto">
                        <label for="update_payment_status">{{ translate('Payment Status') }}</label>
                        @if (($order->payment_type == 'cash_on_delivery' || (addon_is_activated('offline_payment') == 1 && $order->manual_payment == 1)) && $payment_status == 'unpaid')
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_payment_status">
                                <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>
                                    {{ translate('Unpaid') }}</option>
                                <option value="paid" @if ($payment_status == 'paid') selected @endif>
                                    {{ translate('Paid') }}</option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ translate($payment_status) }}" disabled>
                        @endif
                    </div>
                    <div class="col-md-3 ml-auto">
                        <label for="update_delivery_status">{{ translate('Delivery Status') }}</label>
                        @if (
                            $delivery_status != 'delivered' &&
                            $delivery_status != 'cancelled' &&
                            !($order->combinedOrder->payment_method == 'direct_bank_transfer' && $order->combinedOrder->payment_status == 'unpaid')
                        )
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_delivery_status">
                                <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                    {{ translate('Pending') }}</option>
                                <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                    {{ translate('Confirmed') }}</option>
                                <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                    {{ translate('Picked Up') }}</option>
                                <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>
                                    {{ translate('On The Way') }}</option>
                                <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                    {{ translate('Delivered') }}</option>
                                <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                    {{ translate('Cancel') }}</option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}" disabled>
                        @endif
                    </div>
                    <div class="col-md-3 ml-auto">
                        <label for="update_tracking_code">
                            {{ translate('Tracking Code (optional)') }}
                        </label>
                        <input type="text" class="form-control" id="update_tracking_code"
                            value="{{ $order->tracking_code }}">
                    </div>
                @endif
            </div>
            <div class="row gutters-5 mt-2">
                <div class="col text-md-left text-center">
                    @if(json_decode($order->shipping_address))
                        <address>
                            <strong class="text-main">
                                {{ json_decode($order->shipping_address)->name }}
                            </strong><br>
                            {{ json_decode($order->shipping_address)->email }}<br>
                            {{ json_decode($order->shipping_address)->phone }}<br>
                            {{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, @if(isset(json_decode($order->shipping_address)->state)) {{ json_decode($order->shipping_address)->state }} - @endif {{ json_decode($order->shipping_address)->postal_code }}<br>
                            {{ json_decode($order->shipping_address)->country }}
                        </address>
                    @else
                        <address>
                            <strong class="text-main">
                                {{ $order->user->name }}
                            </strong><br>
                            {{ $order->user->email }}<br>
                            {{ $order->user->phone }}<br>
                        </address>
                    @endif
                    @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                        <br>
                        <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                        {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }},
                        {{ translate('Amount') }}:
                        {{ single_price(json_decode($order->manual_payment_data)->amount) }},
                        {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                        <br>
                        <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                            target="_blank"><img
                                src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt=""
                                height="100"></a>
                    @endif
                </div>
                <div class="col-md-4">
                    <table class="ml-auto">
                        <tbody>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                <td class="text-info text-bold text-right">BHP000{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Status') }}</td>
                                <td class="text-right">
                                    @if ($delivery_status == 'delivered')
                                        <span class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                    @else
                                        <span class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Date') }}</td>
                                <td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Total amount') }}</td>
                                <td class="text-right">
                                    {{ single_price($order->grand_total) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Payment method') }}</td>
                                <td class="text-right">
                                    {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                            </tr>

                            <tr>
                                <td class="text-main text-bold">{{ translate('Additional Info') }}</td>
                                <td class="text-right">{{ $order->additional_info }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                  
                    <table class="table-bordered aiz-table invoice-summary table">
                        <thead>
                            <tr class="bg-trans-dark">
                                <th class="min-col">#</th>
                                <th width="10%">{{ translate('Photo') }}</th>
                                <th class="text-uppercase">{{ translate('Description') }}</th>
                                {{-- <th class="text-uppercase">{{ translate('Delivery Type') }}</th> --}}
                              
                                <th class="min-col text-uppercase text-center">
                                    {{ translate('Original Unit Price') }}</th>
                                <th class="min-col text-uppercase text-center">
                                        {{ translate('Platform Fee') }}</th>
                                @if(auth()->user()->id == $orderDetail->source_seller_id ) 
                                    <th class="min-col text-uppercase text-center">
                                    
                                            {{ translate('Sale') }}
                                    
                                    </th>
                                @endif
                                <th  class="min-col text-uppercase text-center">
                                    {{ translate('Qty') }}
                                </th>
                                @if(auth()->user()->seller_type != 'store_partner' )
                                    <th class="min-col text-uppercase text-center">
                                    {{ translate('Total Sale') }}</th>
                                @endif
                                @if(auth()->user()->seller_type != 'brand_partner' )
                                    <th class="min-col text-uppercase text-center">
                                    {{ translate('Profit') }}</th>
                                @endif
                                <th class="min-col text-uppercase text-right">
                                    {{ translate('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $overall_sale = 0;


                                
                            @endphp
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                @php
                                    $row_sale = 0;
                                    $profit = 0;


                                    if (auth()->user()->seller_type == 'store_partner' ) {
                                        if($orderDetail->seller_id != $orderDetail->source_seller_id){
                                            $profit = $orderDetail->seller_profit_amount * $orderDetail->quantity;

                                        }
                                       
                                    }


                                   
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                            <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                target="_blank"><img height="50"
                                                    src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                                        @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                            <a href="{{ route('auction-product', $orderDetail->product->slug) }}"
                                                target="_blank"><img height="50"
                                                    src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                                        @else
                                            <strong>{{ translate('N/A') }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                            <strong><a href="{{ route('product', $orderDetail->product->slug) }}"
                                                    target="_blank"
                                                    class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                            <small>{{ $orderDetail->variation }}</small>
                                        @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                            <strong><a href="{{ route('auction-product', $orderDetail->product->slug) }}"
                                                    target="_blank"
                                                    class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                        @else
                                            <strong>{{ translate('Product Unavailable') }}</strong>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if ($order->shipping_type != null && $order->shipping_type == 'home_delivery')
                                            {{ translate('Home Delivery') }}
                                        @elseif ($order->shipping_type == 'pickup_point')
                                            @if ($order->pickup_point != null)
                                                {{ $order->pickup_point->getTranslation('name') }}
                                                ({{ translate('Pickup Point') }})
                                            @else
                                                {{ translate('Pickup Point') }}
                                            @endif
                                        @elseif($order->shipping_type == 'carrier')
                                            @if ($order->carrier != null)
                                                {{ $order->carrier->name }} ({{ translate('Carrier') }})
                                                <br>
                                                {{ translate('Transit Time').' - '.$order->carrier->transit_time }}
                                            @else
                                                {{ translate('Carrier') }}
                                            @endif
                                        @endif
                                    </td> --}}
                                    <td class="text-center">
                                        {{ single_price($orderDetail->price / $orderDetail->quantity) }}</td>
                                        <td class="text-center">
                                            @if(auth()->user()->id == $orderDetail->source_seller_id)
                                                - {{ single_price($orderDetail->admin_profit_amount) }}
                                                <br>
                                                @if (!empty($orderDetail->admin_profit_per)) 
                                                    {{  '('.$orderDetail->admin_profit_per.'% )' }}   
                                                @endif
                                            @elseif( auth()->user()->seller_type != 'store_partner'  )
                                                @if(empty($orderDetail->seller_profit_amount))
                                                    - {{ single_price($orderDetail->admin_profit_amount) }}
                                                    <br>
                                                    @if (!empty($orderDetail->admin_profit_per)) 
                                                    
                                                        {{  '('.$orderDetail->admin_profit_per.'% )' }}   
                                                    
                                                    @endif

                                                @else 
                                                    -
                                                @endif
                                            

                                            @endif
                                        </td> 
                                     @if(auth()->user()->seller_type != 'store_partner' )
                                        <td class="text-center">

                                            @if(auth()->user()->seller_type == 'brand_partner' )

                                                {{  single_price($orderDetail->source_seller_profit_amount)  }}
                                                @php $row_sale = $orderDetail->source_seller_profit_amount; @endphp
                                            @elseif ( auth()->user()->seller_type == 'seller_partner' )  
                                                @if(empty($orderDetail->seller_profit_amount) )
                                                    {{  single_price($orderDetail->source_seller_profit_amount)  }}
                                                    @php $row_sale = $orderDetail->source_seller_profit_amount; @endphp
                                                @else 
                                                    -
                                                @endif
                                                
                                            @else
                                                -
                                            @endif
                                            
                                        </td>
                                    @endif
                                        
                                    <td class="text-center">{{ $orderDetail->quantity }}</td>
                                    @if(auth()->user()->seller_type != 'store_partner' )
                                    <td class="text-center">{{ single_price($row_sale ) }}</td>
                                    @endif
                                    @if(auth()->user()->seller_type != 'brand_partner' )
                                    <td>
                                        {{ $profit ?? 0 }}
                                    </td>
                                    @endif
                                    <td>
                                        {{ $profit ?? 0 }}
                                    </td>
                                </tr>
                                @php

                                

                                
                                $row_sale += $profit;
                                $overall_sale += $row_sale; 
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix float-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('Sub Total') }} :</strong>
                            </td>
                            <td>
                                {{ single_price($overall_sale) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('Tax') }} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('tax')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('Shipping') }} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('Coupon') }} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->coupon_discount) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('TOTAL') }} :</strong>
                            </td>
                            <td class="text-muted h5">
                                {{ single_price($overall_sale) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="no-print text-right">
                    <a href="{{ route('seller.invoice.download', $order->id) }}" type="button"
                        class="btn btn-icon btn-light"><i class="las la-print"></i></a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('seller.orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                $('#order_details').modal('hide');
                AIZ.plugins.notify('success', '{{ translate('Order status has been updated') }}');
                location.reload().setTimeOut(500);
            });
        });

        $('#update_payment_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('seller.orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                $('#order_details').modal('hide');
                //console.log(data);
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
                location.reload().setTimeOut(500);
            });
        });
    </script>
@endsection
