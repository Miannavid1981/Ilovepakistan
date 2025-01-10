<style>
    .watermark-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-30deg);
        z-index: 1;
        pointer-events: none;
    }

    .watermark {
        color: rgba(255, 0, 0, 0.15);
        /* Soft red color for visibility */
        font-size: 6em;
        /* Larger size for emphasis */
        font-weight: 700;
        /* Bold text */
        font-family: 'Arial', sans-serif;
        letter-spacing: 5px;
        /* Add spacing between letters */
    }
</style>
@extends('frontend.layouts.app')
<link rel="stylesheet" href="{{ static_asset('assets/css/pdf.css') }}">
@section('content')
<!-- Steps -->
<section class="pt-5 mb-0">
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
                    <div class="col done">
                        <div class="text-center border border-bottom-6px p-2 text-success">
                            <i class="la-3x mb-2 las la-truck"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('3. Delivery info') }}
                            </h3>
                        </div>
                    </div>
                    <div class="col done">
                        <div class="text-center border border-bottom-6px p-2 text-success">
                            <i class="la-3x mb-2 las la-credit-card"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('4. Payment') }}</h3>
                        </div>
                    </div>
                    <div class="col active">
                        <div class="text-center border border-bottom-6px p-2 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32.001"
                                viewBox="0 0 32 32.001" class="cart-rotate mb-3 mt-1">
                                <g id="Group_23976" data-name="Group 23976" transform="translate(-282 -404.889)">
                                    <path class="cart-ok has-transition" id="Path_28723" data-name="Path 28723"
                                        d="M313.283,409.469a1,1,0,0,0-1.414,0l-14.85,14.85-5.657-5.657a1,1,0,1,0-1.414,1.414l6.364,6.364a1,1,0,0,0,1.414,0l.707-.707,14.85-14.849A1,1,0,0,0,313.283,409.469Z"
                                        fill="#ffffff" />
                                    <g id="LWPOLYLINE">
                                        <path id="Path_28724" data-name="Path 28724"
                                            d="M313.372,416.451,311.72,418.1a14,14,0,1,1-5.556-8.586l1.431-1.431a16,16,0,1,0,5.777,8.365Z"
                                            fill="#d43533" />
                                    </g>
                                </g>
                            </svg>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('5. Confirmation') }}
                            </h3>
                        </div>
                    </div>
                    <!-- <div style="width: 0px;">
                                        <button onclick="printOrderConfirmation()" class="btn btn-success">Print Order Reciept</button>
                                    </div>
                                    -->
                    <div class="container">
                        <div class="text-center mt-3 rounded"
                            style="background-color: #d4edda; padding: 10px; font-size:20px">
                            <p class="m-0"><i class="la la-check-circle text-success fs-30"></i> Thank you for
                                Ordering at Allaaddin.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="text-center my-4">
    <a href="{{ route('download_order_receipt', $orders->id) }}" class="btn btn-success mt-3">Download Order Receipt</a>

    <!-- <button onclick="printOrderConfirmation()" class="btn btn-success">Download Order Reciept</button> -->
</div>
@php
$first_order = $orders->orders;
$manualPaymentData = json_decode($first_order[0]->manual_payment_data, true);
@endphp

<div class="pdf-main-container py-4 d-none">
    <div class="pdf-header">
        <div>
            @php
            $header_logo = get_setting('header_logo');
            @endphp
            <img class="pdf-logo" src="{{ uploaded_asset($header_logo) }}" style="margin-right: 20px;" />
            {{-- <h1 class="pdf-title">
                    <span>Allaaddin.com</span>
                </h1> --}}
        </div>
        <div>
            <p><b>Tel:</b> 042 35942626-145</p>
            <p><b>Website URL:</b> https://allaaddin.com/</p>
        </div>
    </div>
    <div class="pdf-customer-container">
        <div class="pdf-left">
            <p>To: <b>{{ json_decode($first_order[0]->shipping_address)->name }}</b></p>
            <p>Tel: {{ json_decode($first_order[0]->shipping_address)->phone }}</p>
            <p>Email: {{ json_decode($first_order[0]->shipping_address)->email }}</p>
        </div>

        <div class="pdf-right">
            <p>Ref# * {{ $first_order[0]->code }}</p>
            <p><b>Date: {{ date('d/m/Y', $first_order[0]->date) }}</b></p>
            <p>Supply in: {{ json_decode($first_order[0]->shipping_address)->city }}</p>
            <p id="shipment-type">Shipment Type: {{ $first_order[0]->orderDetails()->value('shipping_type') }}</p>
            <p>Payment Terms: 100% Advance</p>
            <p>Delivery: in 3-5 Working days</p>
        </div>
    </div>
    <div class="pdf-invoice-table">
        <h4>Invoice</h4>
        <table>
            <thead>
                <tr>
                    <th>Items</th>
                    <th>Description</th>
                    <th>Quantity (pcs)</th>
                    <th>Unit Price (Rs/ PCS)</th>
                    <th>Transportation (Rs)</th>
                    <th>Amount (Rs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($first_order as $order)
                @foreach ($order->orderDetails as $key => $orderDetail)
                @php
                // Raw query to join order_details, products, and parent_skus
                $skuResult = DB::select("
                SELECT parent_skus.sku
                FROM parent_skus
                JOIN products ON products.id = parent_skus.product_id
                WHERE products.id = :product_id", ['product_id' => $orderDetail->product_id]);

                // Fetch the SKU or set to 'N/A' if not found
                $sku = !empty($skuResult) ? $skuResult[0]->sku : 'N/A';

                // Get the delivery type for the orderDetail
                $deliverytype = $orderDetail->shipping_type ?? 'N/A';
                @endphp
                <tr>
                    <td class="items">{{ $loop->parent->iteration }}</td>
                    <!-- Combining both loops' iterations -->
                    <td class="description">
                        @if ($orderDetail->product != null)
                        {{ $orderDetail->product->getTranslation('name') }}--{{$sku}}
                        @if ($orderDetail->combo_id != null)
                        @php
                        $combo = \App\ComboProduct::findOrFail($orderDetail->combo_id);
                        echo '(' . $combo->combo_title . ')';
                        @endphp
                        @endif
                        @else
                        <strong>{{ translate('Product Unavailable') }}</strong>
                        @endif
                    </td>
                    <td class="quantity">{{ $orderDetail->quantity }}</td>
                    <td class="unit-price">{{ single_price($orderDetail->price / $orderDetail->quantity) }}
                    </td>
                    <td class="transport">{{ single_price($orderDetail->shipping_cost) }}</td>
                    <td class="amount">{{ single_price($orderDetail->price + $orderDetail->shipping_cost) }}</td>
                </tr>
                @endforeach
                @endforeach
                <tr>
                    <td colspan="5" class="right-align bold"><b>TOTAL PAYMENT:</b></td>
                    <td><b>{{ single_price($orders->grand_total) }}</b></td>
                </tr>
                <tr>
                    <td colspan="6" class="pdf-no-borde"></td>
                </tr>
                <tr>
                    <td colspan="6" class="pdf-no-borde bold">
                        RECEIVED PAYMENT DETAILS:
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="no-borde">Date {{ date('d-m-Y', $first_order[0]->date) }}</td>
                    <td colspan="2" class="no-border position-relative">
                        @if ($first_order[0]->payment_status == 'unpaid')
                        <div class="watermark-container">
                            <span class="watermark">UNPAID</span>
                        </div>
                        @endif
                        <span class="content">
                            {{ $first_order[0]->payment_type == 'bank_transfer' ? 'Bank Transfer' : 'Other Payment Method' }}
                        </span>
                    </td>
                    <td class=""><b>{{ single_price($orders->grand_total) }}</b></td>
                </tr>
                <tr>
                    <td colspan="6" class="pdf-no-borde bold">
                        Solar Dynamics Technologies Pakistan
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="pdf-note">
            *This is System Generated Invoice not Required any Stamp or Signature.
        </p>
    </div>
    <div class="pdf-footer">

        <div class="pdf-footer-left">
            @if ($first_order[0]->payment_type == 'bank_transfer')
            <div>
                <p>Bank: MCB</p>
                <p>Account Name: Solar Dynamics Technologies</p>
                <p>Account Number: 0585376961001725</p>
                <p>Account IBAN: PK56 MUCB 0585 3769 6100 1725</p>
            </div>
            @elseif($first_order[0]->payment_type == 'jazzcash')
            <div>
                <p>Method: JazzCash Account</p>
                <p>Account Name: Muhammad Naveed</p>
                <p>Account Number: 0300 0322034</p>
                <p>Account IBAN: PK56 MUCB 0585 3769 6100 1725</p>
            </div>
            @else
            <div>
                <p>Method: COD</p>
            </div>
            @endif
        </div>

        <div class="pdf-footer-right">
            <p>Solar Dynamics Technologies Co. Pakistan</p>
            <p>M-45-44, Zainab Tower, Link Rd Model Town, Lahore, Pakistan</p>
            <p>Tel: 042 35942626-145</p>
            <p>Email: solardtco@gmail.com</p>
        </div>

    </div>
</div>
<div style="text-align: center;">
    <p>This is System Generated Invoice not Required any Stamp or Signature.</p>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function printOrderConfirmation() {
        var printContent = document.querySelector('.py-4').innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>
<script>
    window.onload = function() {
        // Get the shipment type from local storage
        const shipmentType = localStorage.getItem('shipmentType');
        // Update the <p> element with the selected shipment type
        if (shipmentType) {
            document.getElementById('shipment-type').innerText = `Shipment Type: ${shipmentType}`;
        }
    }
</script>
<script>
    < script >
        document.addEventListener('DOMContentLoaded', function() {
            // Retrieve the saved payment option from local storage
            const selectedPaymentOption = localStorage.getItem('selected_payment_option');
            const bankNameElement = document.getElementById('selected-bank');
            let bankName = 'N/A'; // Default bank name
            if (selectedPaymentOption) {
                switch (selectedPaymentOption) {
                    case 'bank_transfer':
                        bankName = 'MCB'; // Bank Transfer
                        break;
                    case 'cash_on_delivery':
                        bankName = 'COD'; // No specific bank for COD
                        break;
                    case 'jazzcash':
                        bankName = 'JazzCash'; // JazzCash
                        break;
                    default:
                        bankName = 'N/A';
                }
            }
            // Update the text content of the <p> tag
            bankNameElement.textContent = `Bank: ${bankName}`;
        });
</script>
</script>
@endsection