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

                    
                

                @endif frontend-new
        
                @php                   
                    $receipts = json_decode($order->payment_receipts) ?? [];
                @endphp
        
                @if(count($receipts) > 0)
                    @foreach($receipts as $receipt)
                        @php
                            $fileUrl = url('/storage/' . $receipt);
                            $fileExtension = pathinfo($receipt, PATHINFO_EXTENSION);
                        @endphp
                        <div class="uploaded-file d-flex align-items-center mb-2">
                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ $fileUrl }}" alt="Receipt Image" class="img-thumbnail me-2" width="150">
                            @else
                                <a href="{{ $fileUrl }}" target="_blank" class="d-block">View Receipt</a>
                            @endif
                        </div>
                    @endforeach
                @endif
        
               <!-- Modal -->
               <div class="modal fade" id="uploadReceiptsModal" tabindex="-1" aria-labelledby="uploadReceiptsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadReceiptsModalLabel">Upload Payment Receipts</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('orders.uploadReceipts') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order_id }}">
            
            <div id="file-upload-container">
              <div class="file-upload-row my-2">
                <input type="file" name="payment_receipts[]" class="form-control file-input" accept="image/*,application/pdf" onchange="previewFile(this)">
                <div class="preview-container mt-2"></div>
                <button type="button" class="btn btn-danger mt-2 delete-btn delete-receipt" onclick="removeField(this)" style="display: none;">X</button>
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
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadReceiptsModal">
    Upload Receipts
</button>

  

                    
                
                main
            </div>

            <div class="col-md-3"></div>
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

    $(document).on("click", ".delete-file-upload", function(){
        $(this).parent().remove()
    });
main
</script>

@endsection