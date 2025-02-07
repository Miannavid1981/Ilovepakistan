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
 </style>
<div class="container text-center ">

    <h3 class="text-center mt-5">Thank you for shopping with us!</h3>
    <p class="text-center fs-18 fw-300">Thank you for shopping with us! You can track your order status with with all its activities ongoing</p>
   
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
        <p class="mb-0 fs-18 ">Order number:</p>
        <h1 class="text-dark ">BH000{{ $order_id }}</h1>

        <div class="row mt-3">
            <div class="col-lg-3 col-md-4 col-6">
                <p class="mb-1">
                    <strong class="fs-16">Date Created:</strong>
                     <br/> 
                     <span class="fs-17 text-capitalize">{{  $order->created_at }}</span>
                </p>
            </div>
           
            <div class="col-lg-3 col-md-4 col-6 ">
                <p class="mb-1">
                    <strong class="fs-16">Payment method:</strong>
                     <br/> 
                     <span class="fs-17 text-capitalize">{{ str_replace("_", " ", $order->payment_method ) }}</span>
                </p>
            </div>
        </div>

        <hr>

        <h5 class="fw-bold">We’re packing your order</h5>
        <p><strong>Estimated delivery:</strong> Fri, 13/10/2023 - Mon, 16/10/2023</p>

        <div class="progress mb-3" style="height: 8px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 25%;"></div>
        </div>

        <div class="alert alert-secondary" role="alert">
            Packing your items. Tracking details to come.
        </div>
        
      
        <div class="accordion mt-4" id="orderAccordion">
          <!-- Accordion Item 1 -->
          <div class="accordion-item">
              <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                      <div class="row w-100 align-items-center">
                          <div class="col-auto">
                              <div class="img-box">
                                  <img src="./apple-logo.png" class="img-fluid rounded" alt="Beanie Image">
                              </div>
                          </div>
                          <div class="col">
                              <h6 class="mb-0">Pier One</h6>
                              <p class="mb-1 text-muted">Beanie - Black</p>
                              <p class="mb-1"><strong>Colour:</strong> Black</p>
                              <p class="mb-1"><strong>Size:</strong> One Size</p>
                              <p class="mb-1"><strong>Article number:</strong> PI954R00F-Q11</p>
                          </div>
                          <div class="col-auto">
                              <h5 class="text-end">£8.00</h5>
                          </div>
                      </div>
                  </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#orderAccordion">
                  <div class="accordion-body">
                      <p><strong>Delivery type:</strong> 2-hour express</p>
                      <ul class="timeline">
                          <li><strong>ORDERED</strong><br> 15:30, September 9, 2018</li>
                          <li><strong>SHIPPED</strong><br> 15:45, September 9, 2018</li>
                          <li class="pending"><strong>DELIVERED</strong><br> Estimated delivery by <strong>17:30</strong></li>
                      </ul>
                      <p><strong>Courier:</strong> On Fleet</p>
                      <p><strong>Tracking Number:</strong> 123456789012345</p>
                      <button class="btn btn-dark w-100">TRACK MY SHIPMENT</button>
                  </div>
              </div>
          </div>

          <!-- Accordion Item 2 -->
          <div class="accordion-item">
              <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                      <div class="row w-100 align-items-center">
                          <div class="col-auto">
                              <div class="img-box">
                                  <img src="./money.png" class="img-fluid rounded" alt="Sneakers Image">
                              </div>
                          </div>
                          <div class="col">
                              <h6 class="mb-0">Nike Air Max</h6>
                              <p class="mb-1 text-muted">Sneakers - White</p>
                              <p class="mb-1"><strong>Size:</strong> 42</p>
                              <p class="mb-1"><strong>Article number:</strong> NI12345678</p>
                          </div>
                          <div class="col-auto">
                              <h5 class="text-end">£120.00</h5>
                          </div>
                      </div>
                  </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                  <div class="accordion-body">
                      <p><strong>Delivery type:</strong> Standard</p>
                      <ul class="timeline">
                          <li><strong>ORDERED</strong><br> 10:00, January 5, 2024</li>
                          <li><strong>SHIPPED</strong><br> 18:30, January 5, 2024</li>
                          <li class="pending"><strong>DELIVERED</strong><br> Estimated delivery by <strong>January 8</strong></li>
                      </ul>
                      <p><strong>Courier:</strong> FedEx</p>
                      <p><strong>Tracking Number:</strong> 987654321098765</p>
                      <button class="btn btn-dark w-100">TRACK MY SHIPMENT</button>
                  </div>
              </div>
          </div>

          <!-- Accordion Item 3 -->
          <div class="accordion-item">
              <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                      <div class="row w-100 align-items-center">
                          <div class="col-auto">
                              <div class="img-box">
                                  <img src="./paypal.png" class="img-fluid rounded" alt="Jacket Image">
                              </div>
                          </div>
                          <div class="col">
                              <h6 class="mb-0">Leather Jacket</h6>
                              <p class="mb-1 text-muted">Brown Leather</p>
                              <p class="mb-1"><strong>Size:</strong> Large</p>
                              <p class="mb-1"><strong>Article number:</strong> LJ987654</p>
                          </div>
                          <div class="col-auto">
                              <h5 class="text-end">£75.00</h5>
                          </div>
                      </div>
                  </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                  <div class="accordion-body">
                      <p><strong>Delivery type:</strong> Next-Day</p>
                      <ul class="timeline">
                          <li><strong>ORDERED</strong><br> 14:00, February 1, 2024</li>
                          <li><strong>SHIPPED</strong><br> 20:00, February 1, 2024</li>
                          <li class="pending"><strong>DELIVERED</strong><br> Estimated delivery by <strong>February 2</strong></li>
                      </ul>
                      <p><strong>Courier:</strong> DHL</p>
                      <p><strong>Tracking Number:</strong> 112233445566</p>
                      <button class="btn btn-dark w-100">TRACK MY SHIPMENT</button>
                  </div>
              </div>
          </div>

      </div>
      
    </div>



</div>


@endsection