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

#map {
    width: 100%;
    height: 400px; /* Adjust as needed */
}

tr.border-bottom td {
    padding-bottom: 10px;
}
strong {
    font-family: 'Aeonik-Semibold';
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


            
            <!-- Middle Columns -->
            <div class="col-lg-3 col-md-6 col-12 mb-3 middle-column" >

                <p class="mb-1">
                    <p class="mb-0 fs-18">Order number:</p>
                    <h1 class="text-dark">BH000{{ $order_id }}</h1>
                    <span class="badge badge-primary w-auto fs-16 py-1 h-auto text-capitalize"> {{  $order->status  }} </span>
                    <br>
                    <br>
                    <strong class="fs-16">Date Created:</strong> <br/> 
                    <span class="fs-17 text-capitalize">{{ $order->created_at }}</span>

                    
                </p>
                <p class="mb-1">
                    <strong class="fs-16">Customer</strong> <br/>
                    <span class="fs-17 ">{{ $order->user->name }}</span> <br/>
                    <span class="fs-17 ">{{ $order->user->email }}</span><br/>
                    <span class="fs-17 ">{{ $order->user->phone }}</span><br/>
                </p>
                @if( !empty($order->order_note) )
                <p class="mb-1">
                    <strong class="fs-16">Order Note</strong> <br/>
                    <span class="fs-17 ">{{ $order->order_note }}</span> <br/>
                    
                </p>
                @endif

               
        
               
            </div>
        
            <div class="col-lg-3 col-md-6 col-12 px-md-5 middle-sd-column">
                <p class="mb-1">
                    <strong class="fs-16">Delivery Type</strong> <br/>
                    <span class="fs-17 text-capitalize">{{ str_replace("_", " ", $order->order_type) }}</span>
                </p>
                <p class="mb-1">
                    <strong class="fs-16">Payment method:</strong> <br/>
                    <span class="fs-17 text-capitalize">{{ str_replace("_", " ", $order->payment_method) }}</span>
                </p>
                
                @if($order->payment_method == 'direct_bank_transfer')
                    <p class="mb-1">
                        <strong class="fs-16">Payment Transfer method:</strong> <br/>
                        {{-- <span class="fs-17 text-capitalize">{{ str_replace("_", " ", $order->payment_transfer_method) }}</span> --}}
                    </p>
                   
                    @if($order->payment_transfer_method == 'meezan_bank')

                        <p class=" fs-15 fw-500">Meezan Bank
                        </p>
                        <b>Account Title.</b>
                        <p class="mb-0">SOLARONLINE PAKISTAN</p>
                        <b>IBAN: </b>
                        <p class="mb-0">PK39 MEZN 0002 8101 0824 5316</p>
                        <b>Account No.</b>
                        <p class="mb-0">02810108245316</p>

                    @endif

                    @if($order->payment_transfer_method == 'mcb_bank')

                        <p class=" fs-15 fw-500">MCB Bank Ltd
                        </p>
                        <b>Account Title.</b>
                        <p class="mb-0">SOLAR DYNAMICS TECHNOLOGIES PAKISTAN</p>
                        <b>IBAN: </b>
                        <p class="mb-0">PK56 MUCB 0585 3769 6100 1725</p>
                        <b>Account No.</b>
                        <p class="mb-0">0585376961001725</p>

                    @endif

                    @if($order->payment_transfer_method == 'bank_al_habib')

                        <p class=" fs-15 fw-500">Bank AL Habib Ltd
                        </p>
                        <b>Account Title.</b>
                        <p class="mb-0">SOLAR DYNAMICS TECHNOLOGIES PAKISTAN</p>
                        <b>IBAN: </b>
                        <p class="mb-0">PK41 BAHL 0254 0981 0214 4301</p>

                    @endif
                    @if($order->payment_transfer_method == 'jazzcash')
                        <p class=" fs-15 fw-500">JazzCash
                        </p>
                        <b>Account Title: </b>
                        <p class="mb-0"> Muhammad Naveed</p>
                        <b>Account No.</b>
                        <p class="mb-0">
                            0300 0322034 
                       </p>
                    @endif

                    @if($order->payment_transfer_method == 'easypaisa')
                        <p class=" fs-15 fw-500">Easypaisa
                        </p>
                        <b>IBAN: </b>
                        <p class="mb-0">PAK12392390239239023</p>
                        <b>Account No.</b>
                        <p class="mb-0">2323093232</p>
                    @endif
                    
                

                @endif 
                @php                   
                    $receipts = json_decode($order->payment_receipts) ?? [];
                @endphp
        
                @if(count($receipts) > 0)
                    @foreach($receipts as $receipt)
                        @php
                            $fileUrl = static_asset('storage/' . $receipt);
                            $fileExtension = pathinfo($receipt, PATHINFO_EXTENSION);
                        @endphp
                        <a class="uploaded-file d-flex align-items-center mb-2"  href="{{ static_asset('storage/' . $receipt) }}" target="_blank">
                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ $fileUrl }}" alt="Receipt Image" class="img-thumbnail me-2" width="150">
                            @else
                                <a href="{{ $fileUrl }}" target="_blank" class="d-block">View Receipt</a>
                            @endif
                        </a>
                    @endforeach
                @endif
        

            </div>

            <div class="col-md-3">
              
               
            
                <p class="mb-1">
                    <strong class="fs-16">Delivery Contact </strong> <br/>
                    @php
                        $shipping_address = json_decode($order->shipping_address, true);
                    @endphp
                    <span class="fs-17 text-capitalize">{{ $shipping_address['name'] }}</span><br/>
                    <span class="fs-17 text-capitalize">{{ $shipping_address['phone'] }}</span><br/>
                    
                    <strong class="fs-16">Shipping Information</strong> <br/>
                    
                    <span class="fs-17 text-capitalize">{{ $shipping_address['address'] }}</span><br/>
                    <span class="fs-17 text-capitalize">{{ $shipping_address['area'] ?? '' }}</span>, <span class="fs-17 text-capitalize">{{ $shipping_address['landmark'] ?? '' }}</span><br/>
                    <span class="fs-17 text-capitalize">{{ $shipping_address['city'] }}</span><br/>
                    <span class="fs-17 text-capitalize">{{ $shipping_address['state'] }}</span><br/>
                    <span class="fs-17 text-capitalize">{{ $shipping_address['country'] }}</span><br/>
                    <span class="fs-17 text-capitalize">{{ $shipping_address['postal_code'] ?? '' }}</span><br/>
                    
                </p>

            
                

               
            </div>
            <div class="col-md-3  text-end">
                <strong class="fs-16">Order Actions</strong>
                <br>
                <a href="{{ url('invoice/'. $order_id) }}"  class="btn btn-soft-primary">
                     <i class="fa fa-file"></i>   Download Invoice
                </a>


                <br>
                <br>
                @if($order->payment_method  == 'direct_bank_transfer')

                    <h5 class="mt-2">Upload Receipts:</h5>
                    @php                   
                        // dd(json_decode($order->payment_receipts));
                        $receipts = json_decode($order->payment_receipts) ?? null;
                    @endphp
                    @if(!empty($receipts) && count($receipts) > 0)
                        @foreach($receipts as $receipt)
                            <a href="{{ static_asset('storage/' . $receipt) }}" target="_blank">View Receipt</a><br>
                        @endforeach
                    @else
                        <!-- Modal -->
                        <div class="modal fade" id="uploadReceiptsModal" tabindex="-1" aria-labelledby="uploadReceiptsModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="uploadReceiptsModalLabel">Upload Payment Receipts</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="{{ route('orders.uploadReceipts') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order_id }}">
                                    
                                    <div id="file-upload-container">
                                        <div class="file-upload-row my-2 d-flex gap-2">
                                            <button type="button" class="btn px-2 py-0 btn-primary delete-file-upload"><i class="fa fa-trash"></i></button>
                                            <input type="file" name="payment_receipts[]" class="form-control" accept="image/*,application/pdf">
                                        </div>
                                    </div>
                        
                                    <button type="button" id="add-more" class="btn btn-secondary mt-2">Add More</button>
                                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <!-- Trigger button to open the modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadReceiptsModal">
                            <i class="fa fa-upload" ></i>  Upload Payment Receipts
                        </button>
                            
                    @endif
    
                @endif



              

            </div>


        </div>
        

        <hr>

        <div class="row">
            <div class="col-12">
             

                <h4>Items</h4>
                <br>

                <table class="w-100">

                    @foreach ($order->orders as $order)
                        @foreach ($order->orderDetails as $key => $orderDetail)
                            @php
                            
                                $category = $orderDetail->product->main_category;
                                $category_name = '';
                                if ($category) {
                                    $category_name = $category->name;
                                }
                                $brand = $orderDetail->product->brand;
                                $brand_name = '';
                                if ($brand) {
                                    $brand_name = $brand->name;
                                }
                                $product = \App\Models\Product::find($orderDetail->product_id);
                                // dd($product);
                                $seller = \App\Models\User::find($product->user_id);
                            @endphp
                            <tr class="border-bottom border-secondary">
                                <td width="40%">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="w-80px h-80px">
                                            <img src="{{ uploaded_asset($product->thumbnail_img) }}" class="w-100 h-100 rounded-2">
                                        </div>
                                        <div>
                                            <small class="fs-15"><b>{{ $category_name }}</b></small><br>
                                            <p class="fs-16 mb-0">{{ $orderDetail->product->name ?? 'Product Unavailable' }}  </p>
                                            <span style="font-size: 13px;">SKIN: {{ $orderDetail->item_enc_skin }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td width="10%">
                                   x {{ $orderDetail->quantity }}
                                </td>
                                <td width="20%">  
                                    <button type="button"  class="bg-white border-0" >
                                        <div class="w-50px h-50px"><img src="{{ uploaded_asset($brand->logo) }}" class="h-100 object-fit rounded-2"> </div>
                                    </button>
                                </td>
                                <td width="20%">  
                                    <div class="h-30px d-flex align-items-center gap-2 fs-15">{{ $brand_name }} </div>
                                </td>
                                
                                
                                <td width="20%">
                                    
                                    <span class="badge badge-primary w-auto fs-16 py-1 h-auto text-capitalize"> {{  $order->delivery_status  }} </span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
               
            </div>
            <div class="col-12  my-5">
                <div id="map"></div>
            </div>
        </div>
      
    </div>



</div>
<script>
       $(document).on("click", ".delete-file-upload", function(){
        
        $(this).parent().remove()
    });
    function initialize() {

        @php

            // dd($shipping_address);
            $latlng = !empty($shipping_address['lat_lang']) ?  explode(',',  $shipping_address['lat_lang'] ) : []; 
        @endphp
        // Replace with your latitude and longitude

        @if( count($latlng) > 1)
        var lat = {{  $latlng[0] }};  // Example: Karachi, Pakistan
        var lng = {{  $latlng[1] }};
        
        var location = { lat: lat, lng: lng };

        // Initialize the map
        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 17, // Adjust zoom level
            center: location,
        });

        // Add a marker
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "Your Location",
        });
        @else
            $("#map").hide()
        @endif
    }

    document.getElementById('add-more').addEventListener('click', function() {
        let container = document.getElementById('file-upload-container');
        let newRow = document.createElement('div');
        newRow.classList.add('file-upload-row');
        newRow.classList.add('d-flex');
        newRow.classList.add('my-2');

        newRow.classList.add('gap-2');
        newRow.innerHTML = '<button type="button" class="btn px-2 py-0 btn-primary delete-file-upload"><i class="fa fa-trash"></i></button><input type="file" name="payment_receipts[]" class="form-control" accept="image/*,application/pdf">';
        container.appendChild(newRow);
    });
    frontend-new

    document.getElementById('add-more').addEventListener('click', function () {
    let container = document.getElementById('file-upload-container');

    // ✅ Create a single new row
    let newRow = document.createElement('div');
    newRow.classList.add('file-upload-row', 'my-2');

    newRow.innerHTML = `
        <input type="file" name="payment_receipts[]" class="form-control file-input" accept="image/*,application/pdf" onchange="previewFile(this)">
        <div class="preview-container mt-2"></div>
        <button type="button" class="btn btn-danger mt-2 delete-btn delete-receipt" onclick="removeField(this)" style="display: none;">X</button>
    `;

    container.appendChild(newRow);
});

// Function to show preview and toggle delete button
function previewFile(input) {
    let file = input.files[0];
    let previewContainer = input.nextElementSibling; // Get the preview container
    let deleteButton = input.parentElement.querySelector(".delete-receipt"); // Get delete button

    previewContainer.innerHTML = ""; // Clear previous content

    if (file && file.type.startsWith("image/")) {  // Only show preview for images
        let reader = new FileReader();
        reader.onload = function (e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-thumbnail', 'mt-2');
            img.width = 150;
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

    // ✅ Show delete button when a file is selected
    if (file) {
        deleteButton.style.display = "inline-block";
    }
}

// Function to remove the input field
function removeField(button) {
    button.parentElement.remove();
}


$(document).ready(function () {
 

    // Ensure Bootstrap JS is loaded
    if (typeof bootstrap === 'undefined') {
      console.error('Bootstrap JS is not loaded. Make sure to include Bootstrap’s JavaScript.');
    }

    // Open modal when button is clicked
    $('[data-bs-toggle="modal"]').click(function () {
      var targetModal = $(this).data('bs-target');
      $(targetModal).modal('show');
    });

    // Close modal when clicking the close button
    $('.btn-close').click(function () {
      $('#uploadReceiptsModal').modal('hide');
    });

    // Close modal when clicking outside (backdrop)
    $('#uploadReceiptsModal').on('click', function (e) {
      if ($(e.target).hasClass('modal')) {
        $(this).modal('hide');
      }
    });
  });

    
</script>

@endsection