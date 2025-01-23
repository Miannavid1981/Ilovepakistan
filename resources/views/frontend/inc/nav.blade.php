  <!-- Preloader -->
  <style>


        .search-bar {
            border: 1px solid #858585;
            border-radius: 50px;
            overflow: hidden;
            max-height: 37px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .search-bar input {
            border: none;
            outline: none;
           
        }
        .header-top img {
            max-height: 50px;
        }
        .header-bottom .nav-link {
            font-size: 1.1rem;
        }
        .header-bottom .nav-link:hover {
            background-color: #eeeeee;
            border-radius: 50px;
            transition: 0.3s ease;
        }
        .cart-badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            font-size: 0.8rem;
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -8px;
            right: -6px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            min-width: 160px;
        }

        .dropdown-menu a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        .nav-link.category-btn {
            display: inline-block; 
            border-radius: 20px;
            background-color: transparent; 
            padding: 5px 30px !important;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .nav-link.category-btn:hover {
            background-color: #F5F5F5; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            text-decoration: none;
        }


        .nav-item {
            margin: 0;
        }

        .nav-link.category-btn + .nav-link.category-btn {
            margin-left: 10px; 
        }

        .navbar .nav-link {
            font-size: 16px;
            font-weight: 400;
            color: #000;
        }

        .search_button_icon {
            background: #000;
            border-radius: 30px !important;
            font-size: 17px;
            padding: 0px 20px !important;
            color: #fff !important;
            margin: 2px;
        }
        

        #search_cat {
            background: #ccc;
            background: #e9e9e9;
            border-radius: 30px;
            font-size: 16px;
            padding: 2px 20px;
            color: #000000 !important;
            margin: 4px;
            border: unset !important;
            height: 100%;
        }
        /* Slide in from right */
        @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
        }

        @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
        }
        .slide-in-right {
            border-radius: 20px;
            height: 100vh;
        }
        .slide-in-right .modal-dialog {
            min-width: 800px;
            border-radius: 20px;
            height: auto !important;
        }
        .modal.fade.slide-in-right .modal-dialog {
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
        }

        .modal.fade.show.slide-in-right .modal-dialog {
        transform: translateX(0);
        }

        .modal.fade.slide-in-right {
        animation: slideInRight 0.3s forwards;
        }

        .modal.fade.slide-in-right .modal.fade {
        animation: slideOutRight 0.3s forwards;
        }
        .slide-in-right .modal-dialog {
            right: 20px !important;
            top: 20px !important;
            bottom: 20px !important;
            height: auto;
        }
        .slide-in-right .modal-body {
            max-height: 100%;
        }
        header .dropdown-toggle {
            
            align-items: flex-end !important;
        }
        header .dropdown-toggle::after {
    
            font-size: 100% !important;
            
        }

        

        @media (max-width: 991px){
            header {
                display: none !important;
            }
            .cart-offers-section {
                display: none !important;
            }
            .slide-in-right .modal-dialog {
                right: 10px !important;
                top: 10px !important;
                bottom: 10px !important;
                min-width: 200px;
                max-width: 200px;
                border-radius: 15px !important;
                height: auto !important;
            }
            .slide-in-right .modal-body {
                padding: 0px 10px !important;
                height: 100% !important;
            }
            .slide-in-right .minicart-main-left-section {
                padding-top: 15px ;
            }
        }
        .quantity-switcher {
            display: flex;
        }

        .quantity-switcher-buttons {
            background: #e6e6e6;
            border: none;
            width: 25px;
            color: #000000;
            font-size: 20px;
            border-radius: 50%;
            aspect-ratio: 1 / 1;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            line-height: 0;
            vertical-align: middle;
        }
        .cart-item-count {
            position: absolute;
            bottom: -10px;
            right: -10px;
            background: red;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            height: 20px;
            color: #fff;
            font-weight: bold;
        }
    </style>

<header class="container bg-white pt-2">
        <!-- Header Top -->
        <div class="row align-items-center header-top">
            <!-- Logo -->
            <div class="col-lg-1 col-md-3 col-4 text-center">
                 @php

                $header_logo =  get_setting('header_logo');
                $logo_url = 'https://allaaddin.com/public/images/1j+ojFVDOMkX9Wytexe43D6kh.png';
                $my_account_url =  route('profile');
                if( Auth::user() ) {
                    $my_account_url = Auth::user()->user_type == "staff" ? '/admin/profile/' : route('profile');
                }
                
                
            @endphp

            @if ($header_logo != null)

                <img src="{{ $logo_url }}" alt="{{ env('APP_NAME') }}" class="img-fluid">

            @else

                <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"

                    class="mw-100 h-30px h-md-40px" height="40" width="50">

            @endif
            </div>
            <!-- Search Bar -->
            <div class="col">
                <div class="input-group search-bar">
                    <select class="search-option1" id="search_cat" style="border: unset;">
                        <option value="" class="search-option2 ">All</option>
                        @php
                            // Fetch categories with level = 0 and status = 1 directly in the view
                            $categories = \App\Models\Category::where('level', 0)->get();
                        @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="search-option2">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control search-input h-100 p-0 fs-17" id="search"  placeholder="Search products...">
                    <button class="btn btn-dark search_button_icon h-100"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                
                   
            </div>
            <div class="col-lg-5 col-md-6 col-12">
                <div class="d-flex justify-content-end align-items-center gap-4">
                    <!-- Language and Currency -->
                    <div class="">
                       
                    </div>
                    <div class="d-flex align-items-center gap-2" style="min-width: 150px;">
                        <div>
                            <i class="fa-solid fs-20 fa-phone"></i>
                        </div>
                        <div>
                            <p class="mb-0 mb-0 fs-14">Call Helpline</p>
                            <h6 class="fw-bold mb-0">+92 302 1234 123</h6>
                        </div>
                       
                    </div>
                    
                    <!-- User Profile and Seller Area with Dropdown -->

                    <!-- My Account -->
                    <div class="dropdown">
                        <button class="btn  dropdown-toggle p-0 " type="button" id="dropdownMyAccount" data-bs-toggle="dropdown" aria-expanded="false">
                        @auth
                        
                            <div class="d-flex">
                                    @if ($user->avatar_original != null)
                                        <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                            <img src="{{ $user_avatar }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        </span>
                                    @endif
                                    <div class="d-flex flex-column">
                                        <span class="d-block fs-15" style="text-wrap: auto"> Hello, {{$user->name}} </span>
                                        <span class="fw-bold fs-16">My Account</span>
                                        
                                    </div>
                                    
                                </div>
                            @else 
                                <div class="d-flex flex-column">
                                    <span class="d-block fs-15"> Customer Area</span>
                                    <span class="fw-bold fs-16">My Account</span>
                                </div>
                            @endauth
                        </button>
                        
                        <ul class="dropdown-menu" aria-labelledby="dropdownMyAccount">
                            @auth 
                                <li><a href="{{ $my_account_url }}" class="dropdown-item"   @if(Auth::user()->user_type == "staff" )  target="_blank"  @endif  > My Account</a></li>
                                <li><a  href="{{ $my_account_url }}" class="dropdown-item" >Orders</a></li>
                            
                            @else 
                                <li><a href="{{ route('user.login') }}" class="dropdown-item">Login</a></li>
                                <li><a href="{{ route('user.registration') }}" class="dropdown-item">Register</a></li>
                            @endif
                            @auth 
                                <li class="divider"></li>
                                <li>
                                <a class="dropdown-item"  href="{{ route('logout') }}">Log Out</a>
                                </li>
                            @endauth
                        
                        </ul>
                    </div>
                    
                    
                    <!-- Seller Account -->
                    <!-- <div class="dropdown">
                        
                        <button class="btn  dropdown-toggle px-0" type="button" id="dropdownSellerAccount" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex flex-column">
                                <span class="d-block">Seller Area</span>
                                <span class="fw-bold">Store Login</span>
                            </div>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownSellerAccount">
                            
                            <li><a href="{{ route('seller.login') }}" class="dropdown-item">Seller Login</a></li>
                            <li><a href="{{ route('shops.create') }}" class="dropdown-item">Create Your Store</a></li>
                        
                        </ul>
                    </div> -->
                

                    <button class="btn btn-light bg-white border-0 me-3 p-0 position-relative toggle-cart-modal">
                        <i class="fa-solid fs-20 fa-cart-shopping"></i>
                        <span class="cart-badge g-cart-items-count">0</span>
                        <p class="fw-bold mb-0">Cart</p>
                    </button>


                </div>
            </div>
            
        </div>

        <!-- Header Bottom -->
        <nav class="navbar navbar-expand  navbar-light bg-white w-100  p-0 mt-2">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav w-100">
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-dark px-3 py-1 category-btn toggle-btn category-drawer-toggle-btn" href="#" style="border-radius: 20px; background-color: #F5F5F5;">
                                <i class="fa-solid fa-bars"></i> All Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="#">Deals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="#">Bestsellers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="#">Top Brands</a>
                        </li>
                        <li class="nav-item me-auto">
                            <a class="nav-link category-btn" href="#">Home & Garden</a>
                        </li>
                        
                        <!-- Last three items aligned to the right -->
                        <li class="nav-item me-3">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Helpline</a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </nav>

    </header>

    <div class="row align-items-center py-2 px-3 header-top d-lg-none">
        <div class="col-4 d-flex align-items-center text-left">
            
            <i class="fa-solid fa-bars menu-icon fs-20 me-2 category-drawer-toggle-btn" ></i>
            <img src="{{ $logo_url }}" alt="AliExpress Logo" class="img-fluid">
        </div>
        <div class="col-8 d-flex justify-content-end align-items-center">
            <i class="fa-solid fa-user fs-20 me-3"></i>
            <button class="btn btn-light bg-white p-0 border-0 toggle-cart-modal">
                <i class="fa-solid fa-cart-shopping fs-20"></i>
            </button>
            
        </div>
        <div class="col-12 mt-2">
            <input type="text" class="form-control fs-18 border-none search" placeholder="Search products..." style="background: rgba(0,0,0,.08); border-radius: 30px; padding: 3px 20px;height: auto;">
        </div>
    </div>

    
    <div class="modal fade" id="searchpopup">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative p-3">
                <!-- <div class="c-preloader text-center p-3">
                    <i class="las la-spinner la-spin la-3x"></i>
                </div> -->
                <!-- <h5>Search Results</h5> -->
                <button type="button" class="close absolute-top-right btn-icon close z-1 btn-circle bg-gray mr-2 mt-2 d-flex justify-content-center align-items-center" data-dismiss="modal" aria-label="Close" style="background: #ededf2; width: calc(2rem + 2px); height: calc(2rem + 2px);">
                    <span aria-hidden="true" class="fs-24 fw-700" style="margin-left: 2px;">&times;</span>
                </button>
                <div id="searchpopup-modal-body">
                    <div class="search-preloader absolute-top-center">
                        <div class="dot-loader">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="search-nothing d-none p-3 text-center fs-16">
                    </div>
                    <div id="search-content" class="text-left">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white ">

        <div class="flex-grow-1 px-3 px-lg-0">

            <form action="{{ route('search') }}" method="GET" class="stop-propagation">

                <div class="d-flex position-relative align-items-center">

                    <div class="d-lg-none" data-toggle="class-toggle"

                        data-target=".front-header-search">

                        <button class="btn px-2" type="button">
                            <i class="la la-2x la-long-arrow-left"></i>
                        </button>
                    </div>

                    <!--<div class="search-input-box">-->

                    <!--    <input type="text"-->

                    <!--        class="border border-soft-light form-control fs-14 hov-animate-outline"-->

                    <!--        id="search" name="keyword"-->

                    <!--        @isset($query)-->

                    <!--        value="{{ $query }}"-->

                    <!--        @endisset-->

                    <!--        placeholder="{{ translate('I am shopping for...') }}" autocomplete="off">-->



                    <!--    <svg id="Group_723" data-name="Group 723" xmlns="http://www.w3.org/2000/svg"-->

                    <!--        width="20.001" height="20" viewBox="0 0 20.001 20">-->

                    <!--        <path id="Path_3090" data-name="Path 3090"-->

                    <!--            d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z"-->

                    <!--            transform="translate(-1.854 -1.854)" fill="#b5b5bf" />-->

                    <!--        <path id="Path_3091" data-name="Path 3091"-->

                    <!--            d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z"-->

                    <!--            transform="translate(-5.2 -5.2)" fill="#b5b5bf" />-->

                    <!--    </svg>-->

                    <!--</div>-->

                </div>

            </form>

            <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"

                style="min-height: 200px;z-index: 999;">
                
                <!--<div class="container">-->
                    
                    <!-- <div class="search-preloader absolute-top-center">

                        <div class="dot-loader">

                            <div></div>

                            <div></div>

                            <div></div>

                        </div>

                    </div>

                    <div class="search-nothing d-none p-3 text-center fs-16">



                    </div>

                    <div id="search-content" class="text-left">



                    </div> -->
                    
                <!--</div>-->

                

            </div>

        </div>

    </div>
<!-- Offcanvas Sidebar -->
 
    <div class="modal fade slide-in-right" id="cartOffcanvas">
        <div class="modal-dialog modal-lg modal-dialog-right modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
      
                <div class="d-flex justify-content-end align-items-center d-none mt-3 mx-3">
                    <button type="button" class="btn-close d-flex justify-content-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
        
                <div class="modal-body">
                    <div class="row gx-5 h-100">
                        <!-- Left Section: You May Also Like -->
                        <div class="col-md-6 border-right cart-offers-section">
                        <div class="">
                            <h4>You May Also Like</h4>
                            <div class="list-group mt-4">
                            <div class="d-flex align-items-center">
                                <img src="https://anvogue.vercel.app/_next/image?url=%2Fimages%2Fproduct%2Ffashion%2F2-1.png&w=384&q=75" width="100px" height="100px" alt="Mesh Shirt" class="rounded me-3">
                                <div>
                                <h6 class="mb-0">Mesh Shirt</h6>
                                <small class="text-muted"><s>$55.00</s> $45.00</small>
                                </div>
                                <button class="btn btn-outline-secondary ms-auto left-section-icon">
                            <i class="bi bi-bag-check"></i>
                                </button>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center">
                                <img src="https://anvogue.vercel.app/_next/image?url=%2Fimages%2Fproduct%2Ffashion%2F2-1.png&w=384&q=75"  width="100px" height="100px" alt="Raglan Sleeve T-Shirt" class="rounded me-3">
                                <div>
                                <h6 class="mb-0">Raglan Sleeve T-Shirt</h6>
                                <small class="text-muted"><s>$36.00</s> $28.00</small>
                                </div>
                                <button class="btn btn-outline-secondary ms-auto left-section-icon">
                            <i class="bi bi-bag-check"></i>
                                </button>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center">
                                <img src="https://anvogue.vercel.app/_next/image?url=%2Fimages%2Fproduct%2Ffashion%2F2-1.png&w=384&q=75"  width="100px" height="100px" alt="Off-The-Shoulder Blouse" class="rounded me-3">
                                <div>
                                <h6 class="mb-0">Off-The-Shoulder Blouse</h6>
                                <small class="text-muted"><s>$40.00</s> $32.00</small>
                                </div>
                                <button class="btn btn-outline-secondary ms-auto left-section-icon">
                            <i class="bi bi-bag-check"></i>
                                </button>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center">
                                <img src="https://anvogue.vercel.app/_next/image?url=%2Fimages%2Fproduct%2Ffashion%2F2-1.png&w=384&q=75"  width="100px" height="100px" alt="Kimono Sleeve Top" class="rounded me-3">
                                <div>
                                <h6 class="mb-0">Kimono Sleeve Top</h6>
                                <small class="text-muted"><s>$32.00</s> $24.00</small>
                                </div>
                                <button class="btn btn-outline-secondary ms-auto left-section-icon">
                            <i class="bi bi-bag-check"></i>
                                </button>
                            </div>
                            <hr>
                            </div>
                        </div>
                        </div>

                        <!-- Right Section: Shopping Cart -->
                        <div class="col-md-6 col-12 d-flex flex-column minicart-main-left-section">
                            <div class="px-1 flex-grow-1  ">
                                <div class="d-flex justify-content-between">
                                    <h4>Shopping Cart</h4>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- <div class="alert mt-4 alert-success d-flex align-items-center" role="alert">
                                    <i class="bi bi-fire me-2"></i>
                                    <div>
                                    Your cart will expire in <strong>0:00</strong> minutes!<br>
                                    Please checkout now before your items sell out!
                                    </div>
                                </div>
                                <p>Buy <strong>$150.00</strong> more to get <strong>Freeship</strong></p>
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> -->

                                <div class="sidecart-items">

                                </div>
                            </div>
                            
                            <!-- Fixed Bottom Section -->
                            <div class="p-3 bg-white">
                                
                                    
                                <div class="d-flex justify-content-between mt-3">
                                    <h5>Subtotal</h5>
                                    <h5 class="sidecart-subtotal">$0.00</h5>
                                </div>
                                <div class="d-flex justify-content-between mt-3 g_discount_wrapper">
                                    <h6>Discount</h6>
                                    <h6 class="sidecart-total-discount"></h6>
                                </div>
                                <div class="d-flex justify-content-between mt-3 g_total">
                                    <h4>Total</h4>
                                    <h4 class="sidecart-total-discount"></h4>
                                </div>
                            
                            
                                <div class="mt-3 d-flex direction-column gap-3">
                                    <button class="btn btn-outline-primary w-100 ">View Cart</button>
                                    <button class="btn btn-primary w-100">Check Out</button>
                                </div>
                                <p class="text-center mt-3 mb-0">Or Continue Shopping </p>
                            </div>
                        </div>
                        
                    </div>
                </div>


            </div>
        </div>
    </div>





 <style>


     /* Preloader container */

#preloader {

  position: fixed;

  top: 0;

  left: 0;

  width: 100%;

  height: 100%;

  background-color: #fff;

  display: none;

  justify-content: center;

  align-items: center;

  z-index: 9999;

}



/* Loader animation */

.loader {

  border: 5px solid #ccc;

  border-top: 5px solid #007bff;

  border-radius: 50%;

  width: 50px;

  height: 50px;

  animation: spin 1s linear infinite;

}



 </style>

 

  <div id="preloader">

      <img src="https://mir-s3-cdn-cf.behance.net/project_modules/disp/04de2e31234507.564a1d23645bf.gif" width="100">

  </div>



  <!-- Content -->

  <div id="content" style="display: none;">

    <h1>Welcome to the Website!</h1>

    <p>Your content goes here...</p>

  </div>

  

    <!-- Top Bar Banner -->

    @php

        $topbar_banner = get_setting('topbar_banner');

        $topbar_banner_medium = get_setting('topbar_banner_medium');

        $topbar_banner_small = get_setting('topbar_banner_small');

        $topbar_banner_asset = uploaded_asset($topbar_banner);

        

        $total = 0;

        $carts = get_user_cart();
    
        if(count($carts) > 0) {
    
            foreach ($carts as $key => $cartItem) {
    
                $product = get_single_product($cartItem['product_id']);
    
                $total = $total + cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
    
            }
    
        }

    @endphp

    

<style>

/* CSS from the previous instructions */

.proceed-order-popup {

    position: fixed;

    right: 20px;

    z-index: 100;

    background-color: #ff5722;

    color: white;

    border: none;

    padding: 10px 20px;

    border-radius: 5px;

    cursor: pointer;

    animation: blinker 2s linear infinite;

}

@keyframes blinker {

  50% {

    opacity: 0.3;

  }

}

</style>

    @if ($topbar_banner != null)

        <div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner"

            data-value="removed">

            <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset">

                <img src="{{ $topbar_banner_asset }}" class="d-none d-xl-block img-fit" alt="{{ translate('topbar_banner') }}">

                <!-- For Large device -->

                <img src="{{ $topbar_banner_medium != null ? uploaded_asset($topbar_banner_medium) : $topbar_banner_asset }}"

                    class="d-none d-md-block d-xl-none img-fit" alt="{{ translate('topbar_banner') }}"> <!-- For Medium device -->

                <img src="{{ $topbar_banner_small != null ? uploaded_asset($topbar_banner_small) : $topbar_banner_asset }}"

                    class="d-md-none img-fit" alt="{{ translate('topbar_banner') }}"> <!-- For Small device -->

            </a>

            <button class="btn text-white h-100 absolute-top-right set-session" data-key="top-banner"

                data-value="removed" data-toggle="remove-parent" data-parent=".top-banner">

                <i class="la la-close la-2x"></i>

            </button>

        </div>

    @endif

    

<script>

$(document).ready(function(){

    // Add to Cart
    $(document).on('click', '.g-add-to-cart', function () {
        const productId = $(this).data('id');
        const prev_text = 'Add to Cart';
        var elm = $(this);
        $(this).html('<i class="fa fa-spinner fa-spin d-block fs-20 "></i>');
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
            },
            success: function (response) {
                if (response.success) {
                    updateSidecart(response.cart);
                    elm.html(prev_text)
                    $('#cartOffcanvas').modal("show");

                } else {
                    alert(response.message || 'Failed to add product to cart.');
                }
            },
        });
    });

    // Quantity Change with Switcher
    $(document).on('click', '.quantity-switcher button', function () {
        const productId = $(this).data('id');
        const operation = $(this).data('operation');
        const $input = $(`.g-cart-qty[data-id="${productId}"]`);
        let currentQty = parseInt($input.val());

        if (operation === 'increment') currentQty++;
        if (operation === 'decrement' && currentQty > 1) currentQty--;

        $input.val(currentQty).trigger('change');
    });

    // Update Quantity
    $(document).on('change', '.g-cart-qty', function () {
        const productId = $(this).data('id');
        const quantity = $(this).val();
        $.ajax({
            url: '/cart/update',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
                quantity: quantity,
            },
            success: function (response) {
                if (response.success) {
                    updateSidecart(response.cart);
                } else {
                    alert(response.message || 'Failed to update quantity.');
                }
            },
        });
    });
    $(document).on('click', '.g-remove-from-cart', function () {
        const productId = $(this).data('id');  // Get the product ID from the data-id attribute

        $.ajax({
            url: '/cart/remove',  // The route for removing items from the cart
            method: 'POST',  // Sending a POST request
            data: {
                product_id: productId,  // The product ID to remove
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token for security
            },
            success: function (response) {
                if (response.cart) {
                    updateSidecart(response.cart);  // Update the sidecart with the new data
                } else {
                    alert('Failed to remove the item.');
                }
            },
            error: function () {
                alert('An error occurred while removing the item.');
            }
        });
    });

    function updateSidecart(cart) {
        const $sidecartItems = $('.sidecart-items');
        $sidecartItems.empty();
        cart.items.forEach((item) => {
            $sidecartItems.append(`
                <div class="sidecart-item d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="d-flex flex-row justify-content-start align-items-center">
                        <button class="px-1 text-primary g-remove-from-cart btn-light bg-white border-0 btn-lg" data-id="${item.id}"><i class="fa fa-trash"></i></button>
                        <div class="position-relative ms-2 me-4" style="width: 50px; height: 50px;" >
                            <img src="${item.image}" alt="${item.name}" class="rounded-2 w-100 h-100 " style="object-fit: contain;">
                            <span class="cart-item-count">${item.quantity}</span>
                        </div>
                        
                        <div class="">
                            <div class="fs-15">${item.name}</div>
                            <div class="d-flex align-items-center gap-2">
                                <div>
                                 <div class="font-weight-bold  ${ item.discount ? ` fs-14 text-secondary" style="text-decoration: line-through;` : 'fs-16' }" >${item.price}</div>
                                ${
                                 item.discount ? `<div class="fs-16 font-weight-bold">${item.discounted_price}</div>`
                                 : ``
                                }
                                 </div>
                                 <div>
                                 ${
                                 item.discount ?
                                    `<span class="bg-primary px-2 py-1 fs-16 rounded-3 text-white font-weight-bold"> - ${item.discounted_percentage}%</span>`
                                    : '' 
                                 }
                                 </div>
                            </div>

                           
                        </div>
                    </div>
                    <div>
                        <div class="fs-18 font-weight-bold text-end">${item.subtotal}</div>
                        <div class="quantity-switcher">
                            <button class="quantity-switcher-buttons" data-id="${item.id}" data-operation="decrement"><i class="fa fa-minus"></i></button>
                            <input type="number" class="g-cart-qty" data-id="${item.id}" value="${item.quantity}" style="max-width: 20px;border: none;text-align: center;pointer-events: none;">
                            <button class="quantity-switcher-buttons" data-id="${item.id}" data-operation="increment"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    
                   
                </div>
            `);
        });
        $('.g-cart-items-count').text(`${cart.items.length}`);
        $('.sidecart-subtotal').text(`${cart.subtotal}`);
    }

    function fetchCart() {
        $.ajax({
            url: '/ajax/cart',  // The URL of the cart endpoint
            method: 'GET',
            success: function (response) {
                if (response.cart) {
                    updateSidecart(response.cart);
                } else {
                    alert('Failed to retrieve cart.');
                }
            },
            error: function () {
                alert('An error occurred while fetching the cart.');
            }
        });
    }

    fetchCart()



    $('.navbar-toggler').click(function(){

        $('.navbar-collapse').slideToggle(300);

    });
    $(".toggle-cart-modal").click(function(){

        $('#cartOffcanvas').modal("show");

    });

    $('#search_cat').change(function () {
        var select = $(this);
        var selectedOption = select.find('option:selected');
        var optionWidth = getTextWidth(selectedOption.text(), select.css('font'));
        optionWidth += 30
        // Set the dropdown width to fit the selected option's text width
        select.css('width', optionWidth + 'px');
    });

    // Function to calculate the width of a text string
    function getTextWidth(text, font) {
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        context.font = font;
        return context.measureText(text).width;
    }
   
    $('.dropdown-toggle').on('click', function (e) {
        e.stopPropagation(); // Prevent the click event from propagating
        $('.dropdown-menu').hide(); //
        $(this).next('.dropdown-menu').toggle(); // Toggle the dropdown menu
    });

    $(document).on('click', function () {
        $('.dropdown-menu').hide(); // Close dropdown when clicking outside
    });

    smallScreenMenu();

    let temp;

    function resizeEnd(){

        smallScreenMenu();

    }



    $(window).resize(function(){

        clearTimeout(temp);

        temp = setTimeout(resizeEnd, 100);

        resetMenu();

    });

	const elem = $('.navbar');

	const scrolled = () => {

    	const threshold = $(document).scrollTop() > 50;

    	elem.toggleClass('sticky', threshold);

	

	};

	$(window).on({ scroll: scrolled });

});





const subMenus = $('.sub-menu');

const menuLinks = $('.menu-link');



function smallScreenMenu(){

    if($(window).innerWidth() <= 992){

        menuLinks.each(function(item){

            $(this).click(function(){

                $(this).next().slideToggle();

            });

        });

    } else {

        menuLinks.each(function(item){

            $(this).off('click');

        });

    }

}



function resetMenu(){

    if($(window).innerWidth() > 992){

        subMenus.each(function(item){

            $(this).css('display', 'none');

        });

    }

}







    </script>

     <!-- Top Bar -->
    
     
 <!-- Search Icon for small device -->

                   
    

    
    @section('script')

        <script type="text/javascript">

            function show_order_details(order_id) {

                $('#order-details-modal-body').html(null);



                if (!$('#modal-size').hasClass('modal-lg')) {

                    $('#modal-size').addClass('modal-lg');

                }



                $.post('{{ route('orders.details') }}', {

                    _token: AIZ.data.csrf,

                    order_id: order_id

                }, function(data) {

                    $('#order-details-modal-body').html(data);

                    $('#order_details').modal();

                    $('.c-preloader').hide();

                    AIZ.plugins.bootstrapSelect('refresh');

                });

            }

        </script>

    @endsection

