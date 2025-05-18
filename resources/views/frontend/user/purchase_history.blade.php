@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card shadow-none rounded-0 border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('Purchase History') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead class="text-gray fs-12">
                    <tr>
                        <th class="pl-0">{{ translate('Code')}}</th>
                        <th data-breakpoints="md">{{ translate('Date')}}</th>
                        <th>{{ translate('Order Type')}}</th>
                        <th>{{ translate('Amount')}}</th>
                        <th data-breakpoints="md">{{ translate('Delivery Status')}}</th>
                        <th data-breakpoints="md">{{ translate('Payment Status')}}</th>
                        <th class="text-right pr-0">{{ translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody class="fs-14">
                    @foreach ($combined_orders as $key => $combined_order)

                        @php
                            $order = $combined_order->orders->first();
                        @endphp
                        @if (count($order->orderDetails) > 0)
                            <tr>
                                <!-- Code -->
                                <td class="pl-0">
                                    <a href="{{route('purchase_history.details', encrypt($combined_order->id))}}">BH000{{ $combined_order->id }}</a>
                                </td>
                                <!-- Date -->
                                <td class="text-secondary">{{ date('d-m-Y', $order->date) }}</td>
                                <!-- Amount -->
                                <td class="fw-500 ">
                                    <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">  {{ ucfirst(str_replace('_', ' ', $combined_order->order_type)) }} </span>
                                </td>
                                <td class="fw-700">
                                    {{ single_price($combined_order->grand_total) }}
                                </td>
                                <!-- Delivery Status -->
                                <td class="fw-700">
                                    <span class="badge badge-inline badge-warning p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;"> {{ translate(ucfirst(str_replace('_', ' ', $combined_order->status))) }} </span>
                                    {{-- @if($order->delivery_viewed == 0)
                                        <span class="ml-2" style="color:green"><strong>*</strong></span>
                                    @endif --}}
                                </td>
                                <!-- Payment Status -->
                                <td>
                                    @if ($order->payment_status == 'paid')
                                        <span class="badge badge-inline badge-success p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{translate('Paid')}}</span>
                                    @else
                                        <span class="badge badge-inline badge-danger p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{translate('Unpaid')}}</span>
                                    @endif
                                    @if($order->payment_status_viewed == 0)
                                        <span class="ml-2" style="color:green"><strong>*</strong></span>
                                    @endif
                                </td>
                                {{-- <!-- Options -->
                                <td class="text-right pr-0">
                                    <!-- Re-order -->
                                    <a class="btn-soft-white rounded-3 btn-sm mr-1" href="{{ route('re_order', encrypt($order->id)) }}">
                                        {{ translate('Reorder') }}
                                    </a>
                                    <!-- Details -->
                                    <a href="{{route('purchase_history.details', encrypt($order->id))}}" class="btn btn-soft-info btn-icon btn-circle btn-sm hov-svg-white mt-2 mt-sm-0" title="{{ translate('Order Details') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                            <g id="Group_24807" data-name="Group 24807" transform="translate(-1339 -422)">
                                                <rect id="Rectangle_18658" data-name="Rectangle 18658" width="12" height="1" transform="translate(1339 422)" fill="#3490f3"/>
                                                <rect id="Rectangle_18659" data-name="Rectangle 18659" width="12" height="1" transform="translate(1339 425)" fill="#3490f3"/>
                                                <rect id="Rectangle_18660" data-name="Rectangle 18660" width="12" height="1" transform="translate(1339 428)" fill="#3490f3"/>
                                                <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12" height="1" transform="translate(1339 431)" fill="#3490f3"/>
                                            </g>
                                        </svg>
                                    </a>
                                    <!-- Invoice -->
                                    <a class="btn btn-soft-secondary-base btn-icon btn-circle btn-sm hov-svg-white mt-2 mt-sm-0" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12.001" viewBox="0 0 12 12.001">
                                            <g id="Group_24807" data-name="Group 24807" transform="translate(-1341 -424.999)">
                                              <path id="Union_17" data-name="Union 17" d="M13936.389,851.5l.707-.707,2.355,2.355V846h1v7.1l2.306-2.306.707.707-3.538,3.538Z" transform="translate(-12592.95 -421)" fill="#f3af3d"/>
                                              <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12" height="1" transform="translate(1341 436)" fill="#f3af3d"/>
                                            </g>
                                        </svg>
                                    </a>
                                </td> --}}


                                <!-- Options -->
                                <td class="text-right pr-0">
                                    <div class="d-flex flex-column flex-sm-row justify-content-end align-items-center">
                                        <!-- Re-order -->
                                        {{-- <a class=" mb-2 mb-sm-0 mr-sm-1"
                                            href="{{ route('re_order', encrypt($combined_order->orders->first()->id)) }}" title="{{ translate('Re-order') }}">
                                            <!--<i class="fas fa-sync-alt" style="font-size: 15px;"></i> -->
                                            <!-- Icon for reorder or refresh -->
                                             <img src="https://www.svgrepo.com/show/4361/refresh.svg" alt="reorder Image" style="width: 26px;"/> 
                                        </a>
                                 --}}
                                        {{-- @if ($combined_order->orders->first()->payment_status == 'unpaid' && $combined_order->orders->first()->payment_type != 'cod')
                                            <!-- Payment Info -->
                                            <a class="mb-2 mb-sm-0 mr-sm-1"
                                                data-toggle="modal" data-target="#paymentInfoModal"
                                                data-order-id="{{ $combined_order->orders->first()->code }}"
                                                title="{{ translate('Add Payment') }}"
                                                data-payment-type="{{ $combined_order->orders->first()->payment_type }}"
                                                onclick="setOrderDetailsForModal(this)" style="cursor: pointer;">
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR27erYfDTTwMz5B9TLGi9HbRkkGyXIx7sEJg&s" alt="Payment Image" style="    height: 23px;width: 100%;"/> <!-- Image for payment -->
                                            </a>
                                        @endif --}}
                                
                                        <!-- Cancel -->
                                        {{-- @if ($combined_order->orders->first()->delivery_status == 'pending' && $combined_order->orders->first()->payment_status == 'unpaid')
                                            <a href="javascript:void(0)"
                                                class="mb-2 mb-sm-0 mt-sm-0 mr-sm-1 confirm-delete"
                                                data-href="{{ route('purchase_history.destroy', $combined_order->orders->first()->id) }}"
                                                title="{{ translate('Cancel') }}">
                                                <!--<svg xmlns="http://www.w3.org/2000/svg" width="9.202" height="12"-->
                                                <!--    viewBox="0 0 9.202 12">-->
                                                <!--    <path id="Path_28714" data-name="Path 28714"-->
                                                <!--        d="M15.041,7.608l-.193,5.85a1.927,1.927,0,0,1-1.933,1.864H9.243A1.927,1.927,0,0,1,7.31,13.46L7.117,7.608a.483.483,0,0,1,.966-.032l.193,5.851a.966.966,0,0,0,.966.929h3.672a.966.966,0,0,0,.966-.931l.193-5.849a.483.483,0,1,1,.966.032Zm.639-1.947a.483.483,0,0,1-.483.483H6.961a.483.483,0,1,1,0-.966h1.5a.617.617,0,0,0,.615-.555,1.445,1.445,0,0,1,1.442-1.3h1.126a1.445,1.445,0,0,1,1.442,1.3.617.617,0,0,0,.615.555h1.5a.483.483,0,0,1,.483.483ZM9.913,5.178h2.333a1.6,1.6,0,0,1-.123-.456.483.483,0,0,0-.48-.435H10.516a.483.483,0,0,0-.48.435,1.6,1.6,0,0,1-.124.456ZM10.4,12.5V8.385a.483.483,0,0,0-.966,0V12.5a.483.483,0,1,0,.966,0Zm2.326,0V8.385a.483.483,0,0,0-.966,0V12.5a.483.483,0,1,0",".966,0Z"-->
                                                <!--        transform="translate(-6.478 -3.322)" fill="#d43533" />-->
                                                <!--</svg>-->
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgJ7lEUuv6EXaohegbqy5qy3RZA7QoaQeyT6m7riI83ofjNgj9PyWLXspsIAQWeqXqte0&usqp=CAU" alt="Payment Image" style="    height: 26px;"/>
                                            </a>
                                        @endif
                                 --}}
                                        <!-- Details -->
                                        <a href="{{ route('purchase_history.details', ['order_id' => encrypt($combined_order->orders->first()->id), 'id' => encrypt($combined_order->id)]) }}"
                                            class="mb-2 mb-sm-0 mt-sm-0 mr-sm-1"
                                            title="{{ translate('Order Details') }}">
                                            <!--<svg xmlns="http://www.w3.org/2000/svg" width="12" height="10"-->
                                            <!--    viewBox="0 0 12 10">-->
                                            <!--    <g id="Group_24807" data-name="Group 24807"-->
                                            <!--        transform="translate(-1339 -422)">-->
                                            <!--        <rect id="Rectangle_18658" data-name="Rectangle 18658" width="12"-->
                                            <!--            height="1" transform="translate(1339 422)" fill="#3490f3" />-->
                                            <!--        <rect id="Rectangle_18659" data-name="Rectangle 18659" width="12"-->
                                            <!--            height="1" transform="translate(1339 425)" fill="#3490f3" />-->
                                            <!--        <rect id="Rectangle_18660" data-name="Rectangle 18660" width="12"-->
                                            <!--            height="1" transform="translate(1339 428)" fill="#3490f3" />-->
                                            <!--        <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12"-->
                                            <!--            height="1" transform="translate(1339 431)" fill="#3490f3" />-->
                                            <!--    </g>-->
                                            <!--</svg>-->
                                            <img src="https://icon-library.com/images/icon-menu/icon-menu-28.jpg" alt="Payment Image" style="    height: 26px;"/>
                                        </a>
                                
                                        <!-- Invoice -->
                                        <a class="mt-sm-0"
                                            href="{{ route('download_order_receipt', $combined_order->id) }}"
                                            title="{{ translate('Download Invoice') }}">
                                            <!--<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12.001"-->
                                            <!--    viewBox="0 0 12 12.001">-->
                                            <!--    <g id="Group_24807" data-name="Group 24807"-->
                                            <!--        transform="translate(-1341 -424.999)">-->
                                            <!--        <path id="Union_17" data-name="Union 17"-->
                                            <!--            d="M13936.389,851.5l.707-.707,2.355,2.355V846h1v7.1l2.306-2.306.707.707-3.538,3.538Z"-->
                                            <!--            transform="translate(-12592.95 -421)" fill="#f3af3d" />-->
                                            <!--        <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12"-->
                                            <!--            height="1" transform="translate(1341 436)" fill="#f3af3d" />-->
                                            <!--    </g>-->
                                            <!--</svg>-->
                                            <img src="https://cdn-icons-png.flaticon.com/512/5611/5611845.png" alt="Payment Image" style="    height: 26px;"/>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="aiz-pagination mt-2">
                {{ $combined_orders->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Delete modal -->
    @include('modals.delete_modal')

@endsection

@section('script')
    <script>
        //     // function setOrderIdForModal(element) {
        //     //     var orderId = $(element).data('order-id');
        //     //     $("#paymentInfoForm input[name='order_id']").val(orderId);
        //     // }
        function setOrderDetailsForModal(element) {
            var orderId = $(element).data('order-id');
            var paymentType = $(element).data('payment-type');

            // Set the order ID in the form (as before)
            $("#paymentInfoForm input[name='order_id']").val(orderId);

            // Hide all payment details sections first
            $('.payment-details').hide();

            // Show relevant payment details section based on payment type
            if (paymentType === 'bank_transfer') {
                $('#bank-transfer-details').show();
            } else if (paymentType === 'jazzcash') {
                $('#jazzcash-details').show();
            }
        }
    </script>

    <script>
        // Event delegation to handle dynamically added elements
    //     document.getElementById('paymentProofContainer').addEventListener('click', function(event) {
    //         const container = document.getElementById('paymentProofContainer');

    //         if (event.target.classList.contains('add-more-payment-proof')) {
    //             const newProofSection = document.createElement('div');
    //             newProofSection.className = 'payment-proof';
    //             newProofSection.innerHTML = `
    //     <div class="form-group">
    //       <label>{{ translate('Transaction ID') }}</label>
    //       <input type="text" class="form-control" name="transaction_id[]" placeholder="{{ translate('Enter Transaction ID') }}" required>
    //     </div>
    //     <div class="form-group">
    //       <label>{{ translate('Photo') }}</label>
    //       <input type="file" class="form-control-file" name="photos[]" required>
    //     </div>
    //   `;
    //             container.appendChild(newProofSection);
    //         }

    //         if (event.target.classList.contains('remove-proof')) {
    //             const proofSections = container.getElementsByClassName('payment-proof');
    //             if (proofSections.length > 0) {
    //                 container.removeChild(proofSections[proofSections.length - 1]);
    //             }
    //         }
    //     });
    
    let transactionIndex = 1;

    $(document).ready(function () {
    let proofIndex = 0;

    // Add more payment proof fields
    $(".add-more-payment-proof").click(function (e) {
        e.preventDefault();
        proofIndex++;

        let newProof = `
            <div class="form-group payment-proof" id="proof-${proofIndex}">
                <label for="transactionId">Transaction ID</label>
                <input type="text" class="form-control" name="transactions[${proofIndex}][transaction_id]" placeholder="Enter Transaction ID" required>
                <label for="paymentPhoto">Photos</label>
                <input type="file" class="form-control-file" name="transactions[${proofIndex}][photos][]" multiple required>
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-proof" data-proof-id="proof-${proofIndex}">Remove</button>
            </div>
        `;

        $("#paymentProofContainer").append(newProof);
    });

    // Remove payment proof field
    $("#paymentProofContainer").on("click", ".remove-proof", function (e) {
        e.preventDefault();
        let proofId = $(this).data("proof-id");
        $("#" + proofId).remove();
    });
});


    </script>
@endsection
