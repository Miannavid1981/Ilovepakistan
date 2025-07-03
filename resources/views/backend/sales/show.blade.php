@extends('backend.layouts.app')

@section('content')
<style>
    .hover-popover {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    .hover-popover .popover-content {
        visibility: hidden;
        opacity: 0;
        width: 250px;
        background-color: #fff;
        color: #333;
        text-align: left;
        border-radius: 8px;
        padding: 10px;
        position: absolute;
        z-index: 999;
        bottom: -220%;
        left: 0;
        /* transform: translateX(-50%); */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
    }
    .hover-popover:hover .popover-content {
        visibility: visible;
        opacity: 1;
        bottom: 120%;
    }

    .popover-content::before {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 8px;
        border-style: solid;
        border-color: #fff transparent transparent transparent;
    }
</style>
@php
    $order = $combined_order->orders->first();
@endphp
    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
        </div>
        <div class="card-body">
            <div class="row gutters-5">
                <div class="col text-md-left text-center">
                </div>
                @php
                    $delivery_status = $order->delivery_status;
                    $payment_status = $order->payment_status;
                    $admin_user_id = get_admin()->id;
                    
                @endphp
                {{-- @if ($order->seller_id == $admin_user_id || get_setting('product_manage_by_admin') == 1) --}}

                    <!--Assign Delivery Boy-->
                    @if (addon_is_activated('delivery_boy'))
                        <div class="col-md-3 ml-auto">
                            <label for="assign_deliver_boy">{{ translate('Assign Deliver Boy') }}</label>
                            @if (($delivery_status == 'pending' || $delivery_status == 'confirmed' || $delivery_status == 'picked_up') && auth()->user()->can('assign_delivery_boy_for_orders'))
                                <select class="form-control aiz-selectpicker" data-live-search="true"
                                    data-minimum-results-for-search="Infinity" id="assign_deliver_boy">
                                    <option value="">{{ translate('Select Delivery Boy') }}</option>
                                    @foreach ($delivery_boys as $delivery_boy)
                                        <option value="{{ $delivery_boy->id }}"
                                            @if ($order->assign_delivery_boy == $delivery_boy->id) selected @endif>
                                            {{ $delivery_boy->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" class="form-control" value="{{ optional($order->delivery_boy)->name }}"
                                    disabled>
                            @endif
                        </div>
                    @endif

                    <div class="col-md-2 ml-auto">
                        <label for="update_payment_status">{{ translate('Payment Status') }}</label>
                        @if (auth()->user()->can('update_order_payment_status') && $payment_status == 'unpaid')
                            {{-- <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity" id="update_payment_status"> --}}
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity" id="update_payment_status" onchange="confirm_payment_status()">
                                <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>
                                    {{ translate('Unpaid') }}
                                </option>
                                <option value="paid" @if ($payment_status == 'paid') selected @endif>
                                    {{ translate('Paid') }}
                                </option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ ucfirst($payment_status) }}" disabled>
                        @endif
                    </div>
                    <div class="col-md-2 ml-auto">
                        <label for="update_delivery_status">{{ translate('Delivery Status') }}</label>
                        @if (auth()->user()->can('update_order_delivery_status') && $delivery_status != 'delivered' && $delivery_status != 'cancelled')
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_delivery_status">
                                <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                    {{ translate('Pending') }}
                                </option>
                                <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                    {{ translate('Confirmed') }}
                                </option>
                                <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                    {{ translate('Picked Up') }}
                                </option>
                                <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>
                                    {{ translate('On The Way') }}
                                </option>
                                <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                    {{ translate('Delivered') }}
                                </option>
                                <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                    {{ translate('Cancel') }}
                                </option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ $delivery_status }}" disabled>
                        @endif
                    </div>
                    {{-- <div class="col-md-3 ml-auto">
                        <label for="update_tracking_code">
                            {{ translate('Tracking Code (optional)') }}
                        </label>
                        <input type="text" class="form-control" id="update_tracking_code"
                            value="{{ $order->tracking_code }}">
                    </div> --}}
                {{-- @endif --}}
            </div>
            
            <div class="row gutters-5">
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
                        <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank">
                            <img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt=""
                                height="100">
                        </a>
                    @endif
                </div>
                <div class="col-md-4">
                    
                    <table class="ml-auto">
                        <tbody>
                            <tr>
                                <td class="text-main text-bold"></td>
                                <td class="text-info text-bold text-right"> <div class="my-3 ml-auto">
                                    @php
                                        $removedXML = '<?xml version="1.0" encoding="UTF-8"?>';
                                    @endphp
                                    {!! str_replace($removedXML, '', QrCode::size(100)->generate('BH000'.$order->id)) !!}
                                </div></td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                <td class="text-info text-bold text-right"> BH000{{ $combined_order->id }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Status') }}</td>
                                <td class="text-right">
                                    @if ($delivery_status == 'delivered')
                                        <span class="badge badge-inline badge-success">
                                            {{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}
                                        </span>
                                    @else
                                        <span class="badge badge-inline badge-info">
                                            {{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Date') }} </td>
                                <td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
                            </tr>
                            {{-- <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Total amount') }}
                                </td>
                                <td class="text-right">
                                    {{ single_price($order->grand_total) }}
                                </td>
                            </tr> --}}
                            <tr>
                                <td class="text-main text-bold">{{ translate('Payment method') }}</td>
                                <td class="text-right">
                                    {{ translate(ucfirst(str_replace('_', ' ', $combined_order->payment_method))) }}</td>
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
                                <th data-breakpoints="lg" class="min-col">#</th>
                                
                                <th class="text-uppercase">{{ translate('Product') }}</th>
                                
                                <th class="text-uppercase">{{ translate('Seller') }}</th>
                                <th class="text-uppercase">{{ translate('Importer') }}</th>
                                <th data-breakpoints="lg" class="text-uppercase">{{ translate(' Commission') }}</th>
                          
                                
                                <th  data-breakpoints="lg" class="text-uppercase d-none">{{ translate('Delivery Type') }}</th>
                                <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                                    {{ translate('Qty') }}
                                </th>
                                <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                                    {{ translate('Price') }}</th>
                                <th data-breakpoints="lg" class="min-col text-uppercase text-right">
                                    {{ translate('Total') }}</th>
                                <th class="text-uppercase">{{ translate('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $child_orders = $combined_order->orders;    
                            @endphp
                            @foreach ($child_orders as $order)
                                
                                
                                @foreach ($order->orderDetails as $key => $orderDetail)

                                @php
                                    $sold_by_seller_id = $orderDetail->source_seller_id != $orderDetail->seller_id ? $orderDetail->seller_id : $orderDetail->source_seller_id;
                                    $brand_sold_seller = \App\Models\User::where('id', $orderDetail->source_seller_id)->first();
                                    $sold_by_seller = \App\Models\User::find($sold_by_seller_id);

                                    $popover_seller =   $brand_sold_seller;
                                @endphp
                                
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td style="width: 400px">
                                            <div style="display: grid; grid-template-columns: 1fr 3fr">
                                                <div>
                                                    @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                                        <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">
                                                            <img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
                                                        </a>
                                                    @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                                        <a href="{{ route('auction-product', $orderDetail->product->slug) }}" target="_blank">
                                                            <img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
                                                        </a>
                                                    @else
                                                        <strong>{{ translate('N/A') }}</strong>
                                                    @endif
                                                </div>
                                                <div> 
                                                @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                                    <strong>
                                                        <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank"
                                                            class="text-muted">
                                                            {{ $orderDetail->product->getTranslation('name') }}
                                                        </a>
                                                    </strong>
                                                    <small>
                                                        {{ $orderDetail->variation }}
                                                    </small>
                                                    <br>
                                                    @if($popover_seller)
                                                    <!-- Hover Target -->
                                                    <span class="hover-popover">
                                                        <small class="fs-13 font-weight-bold">
                                                            @php
                                                                $product_stock = $orderDetail->product->stocks->where('variant', $orderDetail->variation)->first();
                                                            @endphp
                                                            {{ $orderDetail->item_skin ?? '' }}

                                                        </small>
                                                    
                                                        <!-- Popover Content -->
                                                        <div class="popover-content">
                                                           

                                                            <div class="d-flex align-items-center " style="gap: 10px">
                                                                <div class="w-40px h-40px ">
                                                                    <img src="{{ uploaded_asset($popover_seller->avatar_original) }}" class="w-100 h-100 object-cover rounded-3 ">
                                                                </div>
                                                                <div>
                                                                    <p class="mb-0 ">{{ $popover_seller->name }}</p>
                                                                    <span class="badge badge-dark text-uppercase w-auto">{{ str_replace('_', ' ', $popover_seller->seller_type) }}</span>
                                                                </div>
                                                                
                                                            </div>
                                                            <br>
                                                            @if ($orderDetail->source_seller_id != $orderDetail->seller_id)
                                                                <a class="text-dark fs-14 text-decoration-none" href="javascript:void(0);"><i class="las la-hash"></i>&nbsp;</strong> {{ get_product_full_skin_no($brand_sold_seller, $orderDetail->product) }}<a>
                                                                <br>
                                                            @endif
                                                            <a class="text-dark fs-14 text-decoration-none" href="mailto:{{ $popover_seller->email ?? '' }}"><i class="las la-envelope"></i>&nbsp;</strong> {{ $popover_seller->email ?? '' }}<a>
                                                            <br>
                                                            <a class="text-dark fs-14 text-decoration-none" href="tel:{{ $popover_seller->phone ?? '' }}"><i class="las la-phone"></i>&nbsp;</strong> {{ $popover_seller->phone ?? '' }}<a>
                                                            
                                                        </div>
                                                    </span>
                                                    @endif
                                                    
                                                @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                                    <strong>
                                                        <a href="{{ route('auction-product', $orderDetail->product->slug) }}" target="_blank"
                                                            class="text-muted">
                                                            {{ $orderDetail->product->getTranslation('name') }}
                                                        </a>
                                                    </strong>
                                                @else
                                                    <strong>{{ translate('Product Unavailable') }}</strong>
                                                @endif
                                                </div>
                                            </div>
                                          
                                            
                                            
                                            
                                        </td>
                                        <td>
                                            
                                            
                                            @if($brand_sold_seller)
                                            <div class="d-flex flex-column align-items-center ">
                                                <div class="w-40px h-40px ">
                                                    <img src="{{ uploaded_asset($brand_sold_seller->avatar_original) }}" class="w-100 h-100 object-cover rounded-3 ">
                                                </div>
                                            
                                                    <p class="mb-0 ">{{ $brand_sold_seller->name }}</p>
                                                
                                            
                                                
                                            </div>
                                            @endif

                                        </td>

                                        <td>
                                            @if($orderDetail->source_seller_id != $orderDetail->seller_id) 

                                                @php
                                                    $import_seller = \App\Models\User::where('id', $orderDetail->seller_id)->first();
                                                @endphp

                                            
                                                <div class="d-flex flex-column align-items-center ">
                                                    <div class="w-40px h-40px ">
                                                        <img src="{{ uploaded_asset($import_seller->avatar_original) }}" class="w-100 h-100 object-cover rounded-3 ">
                                                    </div>
                                                    
                                                    <p class="mb-0 ">{{ $import_seller->name }}</p>
                                                    
                                                
                                                    
                                                </div>
                                            
                                                
                                            @else

                                                -
                                                
                                            @endif
                                        </td>
                                    
                                        <td>
                                            
                                        
                                        
                                            @if($brand_sold_seller)
                                                <b>{{ $brand_sold_seller->name }}</b>: <span class="text-success">+ PKR {{ number_format($orderDetail->source_seller_profit_amount) }}</span>
                                            @else
                                                Seller not found.
                                            @endif
                                            <br>
                                            @if($orderDetail->source_seller_id != $orderDetail->seller_id) 
                                                @if(!empty($sold_by_seller))
                                                    <b> {{ $sold_by_seller->name }} </b> <span class="text-success">+ PKR {{ number_format($orderDetail->seller_profit_amount) }}</span> @if ($orderDetail->seller_profit_per) Profit Margin: <span class="text-success">{{ $orderDetail->seller_profit_per }}%</span> @endif
                                                @else
                                                    Seller not found.
                                                @endif
                                            @endif
                                            <br>
                                        Platform Fee <span class="text-success">+ PKR {{ number_format($orderDetail->admin_profit_amount) }} </span>  @if ($orderDetail->admin_profit_per)  — Profit Margin: <span class="text-success">{{ $orderDetail->admin_profit_per }}%</span> @endif
                                        </td>
                                        {{-- <td>
                                            {{  $orderDetail->source_seller_id == $orderDetail->seller_id ? $brand_sold_seller->name : ( !empty($sold_by_seller) ? $sold_by_seller->name : '') }}
                                        </td> --}}
                                        <td class="d-none">
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
                                        </td>
                                        <td class="text-center">
                                            {{ $orderDetail->quantity }}
                                        </td>
                                        <td class="text-center">
                                            {{ single_price($orderDetail->price / $orderDetail->quantity) }}
                                        </td>
                                        <td class="text-center">
                                            {{ single_price($orderDetail->price) }}
                                        </td>
                                        <td>
                                            <span class="badge badge-primary w-auto text-uppercase"> {{ $order->delivery_status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix float-left">
                @php                   
                    // dd(json_decode($order->payment_receipts));
                    $receipts = json_decode($combined_order->payment_receipts) ?? null;
                @endphp
                @if(!empty($receipts) && count($receipts) > 0)
                    <h4>Payment Receipts</h4>
                    <div style="display: flex; flex-wrap: wrap">
                    @foreach($receipts as $receipt)
                        <a href="{{ static_asset('storage/' . $receipt) }}" target="_blank"><img src="{{ static_asset('storage/' . $receipt) }}" style="width: 300px;"></a>
                        
                    @endforeach
                    </div>
                @endif
            </div>
            <div class="clearfix float-right">
                @php
    $all_order_details = collect();
    foreach ($combined_order->orders as $order) {
        $all_order_details = $all_order_details->merge($order->orderDetails);
    }

    $total_price = $all_order_details->sum('price');
    $total_tax = $all_order_details->sum('tax');
    $total_shipping = $all_order_details->sum('shipping_cost');
@endphp
                <table class="table">
                    <tbody>
                        <tr>
                            <td><strong class="text-muted">{{ translate('Sub Total') }} :</strong></td>
                            <td>{{ single_price($total_price) }}</td>
                        </tr>
                        <tr>
                            <td><strong class="text-muted">{{ translate('Tax') }} :</strong></td>
                            <td>{{ single_price($total_tax) }}</td>
                        </tr>
                        <tr>
                            <td><strong class="text-muted">{{ translate('Shipping') }} :</strong></td>
                            <td>{{ single_price($total_shipping) }}</td>
                        </tr>
                        <tr>
                            <td><strong class="text-muted">{{ translate('Coupon') }} :</strong></td>
                            <td>{{ single_price($combined_order->orders->sum('coupon_discount')) }}</td>
                        </tr>
                        <tr>
                            <td><strong class="text-muted">{{ translate('TOTAL') }} :</strong></td>
                            <td class="text-muted h5">
                                {{ single_price($total_price + $total_tax + $total_shipping - $combined_order->orders->sum('coupon_discount')) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="no-print text-right">
                    <a href="{{ route('invoice.download', $order->id) }}" type="button" class="btn btn-icon btn-light"><i
                            class="las la-print"></i></a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('modal')

    <!-- confirm payment Status Modal -->
    <div id="confirm-payment-status" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered" style="max-width: 540px;">
            <div class="modal-content p-2rem">
                <div class="modal-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="64" viewBox="0 0 72 64">
                        <g id="Octicons" transform="translate(-0.14 -1.02)">
                          <g id="alert" transform="translate(0.14 1.02)">
                            <path id="Shape" d="M40.159,3.309a4.623,4.623,0,0,0-7.981,0L.759,58.153a4.54,4.54,0,0,0,0,4.578A4.718,4.718,0,0,0,4.75,65.02H67.587a4.476,4.476,0,0,0,3.945-2.289,4.773,4.773,0,0,0,.046-4.578Zm.6,52.555H31.582V46.708h9.173Zm0-13.734H31.582V23.818h9.173Z" transform="translate(-0.14 -1.02)" fill="#ffc700" fill-rule="evenodd"/>
                          </g>
                        </g>
                    </svg>
                    <p class="mt-3 mb-3 fs-16 fw-700">{{translate('Are you sure you want to change the payment status?')}}</p>
                    <button type="button" class="btn btn-light rounded-2 mt-2 fs-13 fw-700 w-150px" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <button type="button" onclick="update_payment_status()" class="btn btn-success rounded-2 mt-2 fs-13 fw-700 w-150px">{{translate('Confirm')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function() {
            var order_id = {{ $order->id }};
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('{{ route('orders.delivery-boy-assign') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                delivery_boy: delivery_boy
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Delivery boy has been assigned') }}');
            });
        });
        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
                location.reload();
            });
        });

        // Payment Status Update
        function confirm_payment_status(value){
            $('#confirm-payment-status').modal('show');
        }

        function update_payment_status(){
            $('#confirm-payment-status').modal('hide');
            var order_id = {{ $order->id }};
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: 'paid'
            }, function(data) {
                $('#update_payment_status').prop('disabled', true);
                AIZ.plugins.bootstrapSelect('refresh');
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
                location.reload();
            });
        }

        $('#update_tracking_code').on('change', function() {
            var order_id = {{ $order->id }};
            var tracking_code = $('#update_tracking_code').val();
            $.post('{{ route('orders.update_tracking_code') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                tracking_code: tracking_code
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Order tracking code has been updated') }}');
            });
        });
    </script>
@endsection
