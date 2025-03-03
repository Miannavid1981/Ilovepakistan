@extends('frontend.layouts.app')
@php
$order_info = $order;
    // dd($order_info);
@endphp
@section('content')

<style>
    
    /* header, footer, .front-header-search {
        display: none !important;
    } */
</style>

<style>
    .timeline {
         list-style: none;
         padding: 0;
         position: relative;
     }
     .timeline::before {
         content: "";
         position: absolute;
         top: 0;
         left: 20px;
         height: 100%;
         width: 2px;
         background: #ccc;
     }
     .timeline li {
         position: relative;
         margin-bottom: 20px;
         padding-left: 40px;
     }
     .timeline li::before {
         content: "✔";
         position: absolute;
         left: 10px;
         top: 5px;
         background: #198754;
         color: white;
         border-radius: 50%;
         padding: 5px;
         font-size: 12px;
     }
     .timeline .pending::before {
         content: "●";
         background: #ccc;
     }
     .img-box {
 width: 100px; /* Adjust as needed */
 height: 100px; /* Adjust as needed */
 display: flex;
 align-items: center;
 justify-content: center;
 border: none;
 border-radius: 0;
 background: transparent;
 padding: 0;
 margin: 0;
}

.img-box img {
 width: 100%;
 height: 100%;
 object-fit: cover;
}
     .accordion-button {
         background-color: white !important;
         color: black !important;
         box-shadow: none !important;
         border: 1px solid #ddd !important;
     }
     .accordion-button:not(.collapsed) {
         background-color: white !important;
         color: black !important;
     }

     .delete-reciept {
        position: absolute !important;
    top: 140px !important;
    right: 44px !important;
}

.middle-column{
    border-right: 1px solid black;
}
@media (max-width: 768px) {
    .middle-column{
    border-bottom: 1px solid black;
    border-right: none !important;
    text-align: center;
}
.middle-sd-column{
    text-align: center;
}
}
 </style>
<div class="container text-center ">

    <h3 class="text-center mt-5">Thank you for shopping with us!</h3>
    <p class="text-center fs-18 fw-300">Thank you for shopping with us! You can track your order status with all its activities ongoing</p>
   
</div>

<div class="container mt-4">
    <!-- Order Details Section -->
    <div class="  p-4">
        {{-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Overview</a></li>
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">10501020676969</li>
            </ol>
        </nav> --}}
       
        <div class="row my-5">


            <div class="col-md-3"></div>
            
            <!-- Middle Columns -->
            <div class="col-lg-3 col-md-6 col-12 mb-3 middle-column" >

                <p class="mb-1">
                    <p class="mb-0 fs-18">Order number:</p>
                    <h1 class="text-dark">BH000{{ $order_id }}</h1>
                    <strong class="fs-16">Date Created:</strong> <br/> 
                    <span class="fs-17 text-capitalize">{{ $order->created_at }}</span>
                </p>
            </div>
        
            <div class="col-lg-3 col-md-6 col-12 px-md-5 middle-sd-column">
                <p class="mb-1">
                    <strong class="fs-16">Payment method:</strong> <br/>
                    <span class="fs-17 text-capitalize">{{ str_replace("_", " ", $order->payment_method) }}</span>
                </p>
        
                @if($order->payment_method == 'direct_bank_transfer')
                    <p class="mb-1">
                        <strong class="fs-16">Payment Transfer method:</strong> <br/>
                        <span class="fs-17 text-capitalize">{{ str_replace("_", " ", $order->payment_transfer_method) }}</span>
                    </p>

                    
                

                @endif

                    
                
               
            </div>
            <div class="col-md-3  text-end">
                <strong class="fs-16">Order Actions</strong>
                <br>
                <a href="{{ url('invoice/'. $order_id) }}"  class="btn btn-primary">
                        Download Invoice
                </a>
                <br>
                @if($order->payment_method  == 'direct_bank_transfer')

                    <h5 class="mt-2">Upload Receipts:</h5>
                    @php                   
                        // dd(json_decode($order->payment_receipts));
                        $receipts = json_decode($order->payment_receipts) ?? null;
                    @endphp
                    @if(!empty($receipts) && count($receipts) > 0)
                        @foreach($receipts as $receipt)
                            <a href="{{ url('/storage/' . $receipt) }}" target="_blank">View Receipt</a><br>
                        @endforeach
                    @else
                        <form action="{{ route('orders.uploadReceipts') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order_id }}">
                            <div id="file-upload-container">
                                <div class="file-upload-row my-2">
                                    <button type="button" class="btn btn-primary delete-file-upload"><i class="fa fa-trash"></i></button>
                                    <input type="file" name="payment_receipts[]" class="form-control" accept="image/*,application/pdf">
                                </div>
                            </div>
                            <button type="button" id="add-more" class="btn btn-secondary">Add More</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                            
                    @endif
    
                @endif

            </div>


        </div>
        

        <hr>

        <div class="row">
            <div class="col-md text-center my-5">
                {{-- <h5 class="fw-bold">We’re packing your order</h5> --}}
                {{-- <p><strong>Estimated delivery:</strong> Fri, 13/10/2023 - Mon, 16/10/2023</p> --}}
                
            </div>
        </div>
      
    </div>



</div>
<script>
    document.getElementById('add-more').addEventListener('click', function() {
        let container = document.getElementById('file-upload-container');
        let newRow = document.createElement('div');
        newRow.classList.add('file-upload-row');
        newRow.innerHTML = '<input type="file" name="payment_receipts[]" class="form-control" accept="image/*,application/pdf">';
        container.appendChild(newRow);
    });
    $(document).on("click", ".delete-file-upload", function(){
        $(this).parent().remove()
    });
</script>

@endsection