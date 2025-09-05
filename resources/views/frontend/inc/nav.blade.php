
<style>
    .dropdown-item:hover {
    color: black !important;
}
/* Box Shadow for Bottom Only */
header{
    padding-bottom: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important; /* Adjust values as needed */
}

header .nav-link:not(.category-drawer-toggle-btn) {
    color: #000 !important;
}
.category-drawer-toggle-btn {
    padding: 10px !important;
}


</style>
<header >
    <div class="container bg-white pt-1">

        <!-- Header Top -->
        <div class="row align-items-center header-top">
            <!-- Logo -->
            <div class="col-lg-2 col-md-3 col-4 text-left">
                 @php

                    $header_logo =  get_setting('header_logo');
                    $logo_url = uploaded_asset(get_setting('header_logo'));
                    $my_account_url =  '/dashboard';
                    if( Auth::user() ) {
                        $my_account_url = Auth::user()->user_type == "staff" ? '/admin/profile/' : '/dashboard';
                    }
                    
                @endphp
                <a href="{{ url('/') }}">
                    @if ($header_logo != null)

                        <img src="{{ $logo_url }}" alt="{{ env('APP_NAME') }}" class="img-fluid">

                    @else

                        <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"

                            class="mw-100 h-30px h-md-40px" height="40" width="50">

                    @endif
                </a>
            </div>
            <!-- Search Bar -->
            <div class="col">
                <div class="input-group search-bar">
                    <select class="search-option1" id="search_cat" style="border: unset; field-sizing:content">
                        <option value="" class="search-option2 ">All</option>
                        @php
                            // Fetch categories with level = 0 and status = 1 directly in the view
                            $categories = \App\Models\Category::where('level', 0)->get();
                        @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="search-option2">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control search-input h-100 p-0 fs-15" id="search"  placeholder="Search products...">
                    <button class="btn btn-dark search_button_icon h-100"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                
                   
            </div>
            <div class="col-lg-3 col-md-5 col-12">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    @if(show_global_cart())
                        <div class="dropdown d-flex justify-content-start align-items-center">
                                <i class="fa fa-location-dot fs-20 me-2" style="color: @auth #3072cb @else #000 @endif">
                                </i>
                                <div class="d-flex flex-column">
                                    <span class="d-block fs-15" style="font-family: 'Aeonik' !important;">Deliver to</span>
                                    <span class="fw-bold fs-17" style="font-family: 'Aeonik-Semibold' !important;">Pakistan</span>
                                </div>
                        </div> 
                    @endif
                    @auth
                        @if(auth()->user()->user_type == 'seller' &&  auth()->user()->seller_type != 'brand_partner')
                        
                        
                    
                        <a href="{{ route('seller.market') }}">
                            <div class="dropdown d-flex justify-content-start align-items-center">
                                <i class="fa fa-shop fs-20 me-2" style="color: @auth #3072cb @else #000 @endif">
                                </i>
                                <div class="d-flex flex-column">
                                    <span class="d-block fs-15 text-dark">Explore</span>
                                    <span class="fw-bold fs-17 text-dark">Market Place</span>
                                </div>
                            </div> 
                        </a>
                        @endif
                        
                    @endauth
                    <!-- User Profile and Seller Area with Dropdown -->
                    <!-- My Account -->
                    <div class="dropdown">
                       
                        <button class="btn  dropdown-toggle p-0 border-0" type="button" id="dropdownMyAccount" data-bs-toggle="dropdown" aria-expanded="false">
                        @auth
                        
                            <div class="d-flex">
                                    @if ($user->avatar_original != null)
                                        <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                            <img src="{{ $user_avatar }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        </span>
                                    @endif
                                    <div class="d-flex flex-column">
                                        @php
                                            $user_name = explode(' ', $user->name);
                                            $first_name = $user_name[0];

                                        @endphp
                                        <span class="d-block fs-15"  style="text-wrap: auto; font-family: 'Aeonik' !important;"> Hello, {{$first_name}} </span>
                                        <span class="fw-bold fs-16"  style="font-family: 'Aeonik-Semibold' !important;">My Account</span>
                                        
                                    </div>
                                    
                                </div>
                            @else 
                                <div class="d-flex flex-column">
                                    <span class="d-block fs-14" style="font-family: 'Aeonik' !important;"> Customer Area</span>
                                    <span class="fw-bold fs-15"  style="font-family: 'Aeonik-Semibold' !important;" >My Account</span>
                                </div>
                            @endauth
                        </button>
                        
                        <ul class="dropdown-menu bg-white" aria-labelledby="dropdownMyAccount">
                            @auth 
                                <li><a href="{{ $my_account_url }}" class="dropdown-item Text-dark fs-14"   @if(Auth::user()->user_type == "staff" )  target="_blank"  @endif  > My Account</a></li>
                                <li><a  href="{{ url('/my-orders') }}" class="dropdown-item fs-14" >Orders</a></li>
                            
                            @else 
                                <li><a href="{{ route('user.login') }}" class="dropdown-item fs-16">Login</a></li>
                                <li><a href="{{ route('user.registration') }}" class="dropdown-item fs-16">Register</a></li>
                            @endif
                            @auth 
                                <li class="divider"></li>
                                <li>
                                <a class="dropdown-item fs-14"  href="{{ route('logout') }}">Log Out</a>
                                </li>
                            @endauth
                        
                        </ul>
                    </div>
                    
                    
              
                    
                   
    
                    @if(show_global_cart())
                    <button class="btn btn-light bg-white border-0 me-2 p-0 position-relative toggle-cart-modal">
                        <i class="fa-solid fs-18 fa-cart-shopping"></i>
                        <span class="cart-badge g-cart-items-count">0</span>
                        <p class="fw-bold mb-0">Cart</p>
                    </button>
                    @endif

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
                    <ul class="navbar-nav w-100" style="gap: 10px">
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary  px-3 py-1 category-btn toggle-btn category-drawer-toggle-btn cursor-pointer" href="#" style="background-color: #F5F5F5;">
                                <i class="fa-solid fa-bars"></i> All Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="{{ url('/shop') }}">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="#">Bestsellers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="/brands">Top Brands</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="#">Top Categories</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="#">Bighouz Ecosystem</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-btn" href="#">Investor Opportunities</a>
                        </li>
                        <li class="nav-item me-auto">
                            <a class="nav-link category-btn" href="#">Customer Care</a>
                        </li>
                        
                        
                        <!-- Last three items aligned to the right -->
                        <li class="nav-item me-3">
                            <a class="nav-link category-btn" href="#">About Us</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link category-btn" href="#">Contact</a>
                        </li>
                        <li class="nav-item d-flex align-items-center ">
                            <i class="fa-solid fa-phone fs-17 me-2"></i> 
                            <a class="nav-link p-0 fw-bold text-dark" href="tel:+923333120595" title="Helpline: +923333120595">Call Helpline</a>
                        </li>                                              
                    </ul>
                </div>
                
            </div>
        </nav>
    </div>
</header>

    <div class="row     align-items-center py-2 px-3 header-top d-lg-none" style="    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9;
    background: #fff;">
        <div class="col-7 d-flex align-items-center text-left">
            
            <i class="fa-solid fa-bars menu-icon fs-20 me-2 category-drawer-toggle-btn" ></i>
            <a href="{{ url('/') }}" style="display: block; text-align: center;">
                <img src="{{ $logo_url }}" alt="AliExpress Logo" class="w-100" style="max-width: 170px !important; height: auto; min-width: 150px !important;">
            </a>
            
        </div>
        <div class="col-5 d-flex justify-content-end align-items-center">


            <!-- My Account -->
            <div class="dropdown me-3">
                
                <button class="btn  dropdown-toggle p-0 border-0" type="button" id="dropdownMyAccount" data-bs-toggle="dropdown" aria-expanded="false">
                @auth
                
                    <div class="d-flex">
                            @if ($user->avatar_original != null)
                                <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                    <img src="{{ $user_avatar }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                </span>
                            @endif
                            <div class="d-flex flex-column">
                                @php
                                    $user_name = explode(' ', $user->name);
                                    $first_name = $user_name[0];

                                @endphp
                                <span class="d-block fs-15"  style="text-wrap: auto; font-family: 'Aeonik' !important;"> Hello, {{$first_name}} </span>
                                <span class="fw-bold fs-16"  style="font-family: 'Aeonik-Semibold' !important;">My Account</span>
                                
                            </div>
                            
                        </div>
                    @else 
                        <div class="d-flex flex-column">
                            <span class="d-block fs-14" style="font-family: 'Aeonik' !important;"> Customer Area</span>
                            <span class="fw-bold fs-15"  style="font-family: 'Aeonik-Semibold' !important;" >My Account</span>
                        </div>
                    @endauth
                </button>
                
                <ul class="dropdown-menu bg-white" aria-labelledby="dropdownMyAccount">
                    @auth 
                        <li><a href="{{ $my_account_url }}" class="dropdown-item Text-dark fs-14"   @if(Auth::user()->user_type == "staff" )  target="_blank"  @endif  > My Account</a></li>
                        <li><a  href="{{ url('/my-orders') }}" class="dropdown-item fs-14" >Orders</a></li>
                    
                    @else 
                        <li><a href="{{ route('user.login') }}" class="dropdown-item fs-16">Login</a></li>
                        <li><a href="{{ route('user.registration') }}" class="dropdown-item fs-16">Register</a></li>
                    @endif
                    @auth 
                        <li class="divider"></li>
                        <li>
                        <a class="dropdown-item fs-14"  href="{{ route('logout') }}">Log Out</a>
                        </li>
                    @endauth
                
                </ul>
            </div>
          

            @if(show_global_cart())
                
                <button class="btn btn-light bg-white p-0 border-0 toggle-cart-modal">
                    <i class="fa-solid fa-cart-shopping fs-20"></i>
                    <span class="cart-badge g-cart-items-count">0</span>
                    
                </button>

            @endif
            
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
        
                <div class="modal-body" style="overflow: hidden;">
                    <div class="row h-100 justify-content-end">
                        <!-- Left Section: You May Also Like -->
                        <div class="col-md-6 border-right cart-offers-section h-100 pe-0">
                        
                            
                            <h4>You May Also Like</h4>
                            <div class="sidecart_suggested-products custom_scrollbar" style="height: 95%;">
                                
                            </div>
                        
                        </div>

                    <!-- Right Section: Shopping Cart -->
                        <div class="col-md-6 col-12 d-flex flex-column minicart-main-left-section justify-content-between h-100">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <button  class="g-clear-cart bg-primary py-0 border-0 text-white border-0 rounded-2 me-2 fs-13 h-25px" style="transform: translateX(-7px);">Clear</button>
                                    <h5>Shopping Cart</h5>
                                </div>
                               
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="flex-grow-1  custom_scrollbar ">
                                
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
                            <div class="pt-3 px-3 bg-white d-flex  flex-column justify-content-end" >
                                
                                    
                                <div class="d-flex justify-content-between">
                                    <h6>Subtotal</h6>
                                    <h6 class="sidecart-subtotal">$0.00</h6>
                            </div>
                                <!-- Coupon System -->
                                @if (get_setting('coupon_system') == 1)
                                {{-- @if (123 > 2 )
                                    <div class="mt-3">
                                        <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <div class="form-control">{{ 'dsdsds' }}</div>
                                                <div class="input-group-append">
                                                    <button type="button" id="coupon-remove"
                                                        class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control rounded-0" name="code"
                                                    onkeydown="return event.key != 'Enter';"
                                                    placeholder="{{ translate('Have coupon code? Apply here') }}" required>
                                                <div class="input-group-append">
                                                    <button type="button" id="coupon-apply"
                                                        class="btn btn-primary rounded-0">{{ translate('Apply') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif --}}
                                @endif
                                {{-- <div class="d-flex justify-content-between g_discount_wrapper">
                                    <p>Discount</p>
                                    <p class="sidecart-total-discount"></p>
                                </div> --}}
                                <div class="d-flex justify-content-between g_total">
                                    <h5>Total</h5>
                                    <h5 class="sidecart-total"></h5>
                                </div>
                            
                            
                                <div class="mt-3 d-flex direction-column gap-3">
                                    <a href="{{ url('/shop') }}" class="btn btn-outline-primary w-100 ">View More</button>
                                    <a href="{{ url('/checkout') }}" class="btn btn-primary w-100">Check Out</a>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>


            </div>
        </div>
    </div>


 

  <div id="preloader">

      <img src="https://mir-s3-cdn-cf.behance.net/project_modules/disp/04de2e31234507.564a1d23645bf.gif" width="100">

  </div>
  <style>
    @media(min-width: 992px){
         .bottom-nav {
            display: none !important;
         }
    }
    .bottom-nav {
        position: fixed;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 95%;
        max-width: 500px;
        padding: 12px 0;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        z-index: 999;
    }

    .bottom-nav a {
      text-decoration: none;
      color: #333;
      font-size: 12px;
      display: flex;
      flex-direction: column;
      align-items: center;
      flex: 1;
      transition: 0.3s;
    }
    .bottom-nav a span {
        font-family: 'Aeonik';
        font-size: 15px;
    }

    .bottom-nav a i {
      font-size: 20px;
      margin-bottom: 5px;
    }

    .bottom-nav a.active {
    font-weight: bold;
    background: -webkit-linear-gradient(45deg, hsla(268, 79%, 49%, 1) 30%, hsla(351, 66%, 61%, 1) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    }

    .bottom-nav a.active i {
    background: -webkit-linear-gradient(45deg, hsla(268, 79%, 49%, 1) 30%, hsla(351, 66%, 61%, 1) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    }
</style>
 <div class="bottom-nav">
    <a href="/" class="active">
      <i class="fa-solid fa-house"></i>
      <span>Home</span>
    </a>
    <a href="javascript:void(0)" class="category-drawer-toggle-btn">
      <i class="fa-solid fa-headphones"></i>
      <span>Categories</span>
    </a>
    <a href="/shop">
      <i class="fa-solid fa-shop"></i>
      <span> Products</span>
    </a>
    <a href="/seller/login">
      <i class="fa-solid fa-users"></i>
      <span>Partner</span>
    </a>
    <a href="tel: +92 333 3120 595">
      <i class="fa-solid fa-phone"></i>
      <span>Call Us</span>
    </a>
  </div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
    <div id="errorToast" class="toast bg-white " role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto">Information</strong>

            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-soft-primary ">
            <!-- Error message will be injected here -->
        </div>
    </div>
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

    function showErrorToast(message) {
            $("#errorToast .toast-body").text(message); // Set the error message
            // Configure toast options
            var toastEl = new bootstrap.Toast(document.getElementById('errorToast'), {
                autohide: true, // If false, stays visible until manually closed
                delay: 5000 // 5 seconds duration
            });
            toastEl.show(); // Show the toast
        }
   
    // Add to Cart
    $(document).on('click', '.g-add-to-cart', function () {
        const productId = $(this).data('id');
        const skin_code = $(this).data('skin_code') ?? null;
        const prev_text = $(this).html();
        let quantity = 1;
        if( $('#g-detail-quantity').length != 0 ){
            quantity = $('#g-detail-quantity').val();
        }
        // alert(quantity)

        // console.warn($(this).closest('[name="quantity"]'))

        var elm = $(this);
        elm.attr("disabled", "disabled");
        $(this).html('<i class="fa fa-spinner fa-spin d-block fs-20 "></i>');
        $.ajax({
            url: '{{  url("/cart/add") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
                skin_code: skin_code,
                quantity
            },
            success: function (response) {
                updateSidecart(response.cart);
                elm.html(prev_text)
                elm.removeAttr("disabled")
                if (response.success) {
                   
                    $('#cartOffcanvas').modal("show");

                } else {
                    showErrorToast(response.message); 
                    // showToast(response.message)
                    // alert(response.message || 'Failed to add product to cart.');
                }
            },
        });
    });

    $(document).on('click', '.g-buy-now', function () {
        const productId = $(this).data('id');
        const skin_code = $(this).data('skin_code') ?? null;
        const prev_text = $(this).html();

        var elm = $(this);
        elm.attr("disabled", "disabled");
        $(this).html('<i class="fa fa-spinner fa-spin d-block fs-20 "></i>');
        $.ajax({
            url: '{{  url("/cart/add") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
                skin_code: skin_code
            },
            success: function (response) {
                if (response.success) {
                    updateSidecart(response.cart);
                    elm.html(prev_text)
                    elm.removeAttr("disabled")
                    // $('#cartOffcanvas').modal("show");
                    window.location.href = '{{ url("/checkout") }}';

                } else {
                    alert(response.message || 'Failed to add product to cart.');
                }
            },
        });
    });
    // Import to Seller
    $(document).on('click', '.g-import-to-seller', function () {
        const productId = $(this).data('id');
        const prev_text = $(this).html();

        var elm = $(this);
        elm.attr("disabled", "disabled");
        $(this).html('<i class="fa fa-spinner fa-spin d-block fs-20 "></i>');

        $.ajax({
            url: '{{ url("/product/import-to-seller") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_ids: [productId],
            },
            success: function (response) {
                if (response.success) {
                    elm.parent().append(response.new_html);
                    elm.remove();

                    // Redirect to checkout page after successful import
                    window.location.href = '{{ url("/checkout") }}';
                } else {
                    alert(response.message || 'Failed to import product to seller.');
                    elm.html(prev_text);
                    elm.removeAttr("disabled");
                }
            },
            error: function () {
                alert('Something went wrong. Please try again.');
                elm.html(prev_text);
                elm.removeAttr("disabled");
            }
        });
    });


    // Quantity Change with Switcher
    $(document).on('click', '.quantity-switcher button', function () {
        const productId = $(this).data('id');
        const operation = $(this).data('operation');
        const $input = $(`.g-cart-qty[data-id="${productId}"]`);
        let currentQty = parseInt($input.val());

        if (operation === 'increment') currentQty++;
        if (operation === 'decrement' && currentQty > 0) currentQty--;

        $input.val(currentQty).trigger('change');
    });

    // Update Quantity
    $(document).on('change', '.g-cart-qty', function () {
        const productId = $(this).data('id');
        const quantity = $(this).val();
        $(".sidecart-items").addClass("disabled")
        $.ajax({
            url: '{{  url("/cart/update") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: productId,
                quantity: quantity,
            },
            success: function (response) {
                  
                if (response.error) {

                    // $('#cartOffcanvas').modal("hide");

                    showErrorToast(response.message); 
                }
                updateSidecart(response.cart);
                $(".sidecart-items").removeClass("disabled")
            },
        });
    });
    $(document).on('click', '.g-remove-from-cart', function () {
        const id = $(this).data('id');  // Get the product ID from the data-id attribute
        $(".sidecart-items").addClass("disabled")
        $.ajax({
            url: '{{ url("/cart/remove") }}',  // The route for removing items from the cart
            method: 'POST',  // Sending a POST request
            data: {
                id,  // The product ID to remove
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token for security
            },
            success: function (response) {
                if (response.cart) {
                    $(".sidecart-items").removeClass("disabled")
                    updateSidecart(response.cart); 
                     // Update the sidecart with the new data
                } else {
                    // alert('Failed to remove the item.');
                }
            },
            error: function () {
                alert('An error occurred while removing the item.');
            }
        });
    });
    $(document).on('click', '.g-clear-cart', function () {
        
        $(".sidecart-items").addClass("disabled")
        $.ajax({
            url: '{{ url("/cart/clear") }}',  // The route for removing items from the cart
            method: 'GET',  // Sending a POST request
            data: {
                
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token for security
            },
            success: function (response) {
                if (response.cart) {
                    $(".sidecart-items").removeClass("disabled")
                    updateSidecart(response.cart); 
                     // Update the sidecart with the new data
                } else {
                    // alert('Failed to remove the item.');
                }
            },
            error: function () {
                alert('An error occurred while removing the items.');
            }
        });
    });

    function updateSidecart(cart) {
        const $sidecartItems = $('.sidecart-items');
        $sidecartItems.empty();
        cart.items.forEach((item) => {
            $sidecartItems.append(`
                <div class="sidecart-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="grid_sidecart">
                        <div class="d-flex align-items-center">
                            <button class="bg-white h-auto border-0 text-white rounded-2 g-remove-from-cart text-primary p-0" data-id="${item.id}"><i class="fa fa-trash fs-16"></i></button>
                        </div>
                        
                        <div class="position-relative ms-2 me-4" style="width: 100%;height: auto;aspect-ratio: 1 / 1;min-width: 20px;background: #eee;border-radius: 10px;" >
                            <img src="${item.image}" alt="${item.name}" class="rounded-2 w-100 h-100 " style="object-fit: contain;">
                            <span class="cart-item-count">${item.quantity}</span>
                        </div>
                        
                        <div class=" ms-4">
                            <div class="fs-13" style="display: inline-block;
    max-width: 90px;
    word-wrap: break-word;">${item.name}</div>
                            <div class="d-flex align-items-center gap-2" style="display: inline-block;
    max-width: 90px;
    word-wrap: break-word;">
                                <div>
                                 <div class="font-weight-bold  ${ item.discount ? ` fs-13 text-secondary" style="text-decoration: line-through;` : 'fs-16' }" >${item.price}</div>
                                ${
                                 item.discount ? `<div class="fs-16 font-weight-bold">${item.discounted_price}</div>`
                                 : ``
                                }
                                 </div>
                                 
                            </div>

                           
                        </div>
                    </div>
                    <div>
                        <div class="fs-15 font-weight-bold text-end">${item.subtotal}</div>
                        <div class="quantity-switcher">
                            <button class="quantity-switcher-buttons" data-id="${item.id}" data-operation="decrement"><i class="fa fa-minus"></i></button>
                            <input type="number" class="g-cart-qty" data-id="${item.id}" value="${item.quantity}" style="max-width: 20px;border: none;text-align: center;pointer-events: none;">
                            <button class="quantity-switcher-buttons" data-id="${item.id}" data-operation="increment"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="d-flex justify-content-end mt-1">
                        ${
                        item.discount ?
                        `<span class="bg-primary px-2 py-1 fs-15 rounded-3 text-white font-weight-bold"> - ${item.discounted_percentage}%</span>`
                        : '' 
                        }
                        </div>
                    </div>

                    
                   
                </div>
            `);
        });
        $('.g-cart-items-count').text(`${cart.items.length}`);
        if(cart.items_discount){
            $('.sidecart-total-discount').text(`-${cart.items_discount}`)

        } else {
            $("g_discount_wrapper").hide()
        }
       
        $('.sidecart-subtotal').text(`${cart.subtotal}`);
        $('.sidecart-total').text(`${cart.total}`);
        getSuggestedProducts(cart.suggested_products ?? []);
    }
    function getSuggestedProducts(products) {
        if(products.length == 0){
            $('.cart-offers-section').hide()
            $(".minicart-main-left-section").removeClass("col-md-6")
            $('.slide-in-right .modal-dialog').removeClass('slide-in-cart-extended');

            return;
        }
        $('.cart-offers-section').show()
        $('.slide-in-right .modal-dialog').addClass('slide-in-cart-extended');
        $(".minicart-main-left-section").addClass("col-md-6")
        const $sidecartItems = $('.sidecart_suggested-products');
        
        $sidecartItems.empty();
        
        
        products.forEach((item) => {
            $sidecartItems.append(`
                <div class="sidecart-item d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="grid_sidecart_suggested">
                        
                        <div class="position-relative ms-2 me-4" style="width: 100%;height: auto;aspect-ratio: 1 / 1;min-width: 15px;" >
                            <img src="${item.image}" alt="${item.name}" class="rounded-2 w-100 h-100 " style="object-fit: cover;">
                           
                        </div>
                        
                        <div class="">
                            <div class="fs-14">${item.name}</div>
                            <div class="d-flex align-items-center gap-2">
                                <div>
                                 <div class="font-weight-bold  ${ item.discount ? ` fs-14 text-secondary" style="text-decoration: line-through;` : 'fs-16' }" >${item.price}</div>
                                ${
                                 item.discount ? `<div class="fs-15 font-weight-bold">${item.discounted_price}</div>`
                                 : ``
                                }
                                 </div>
                                 
                            </div>
                                <div>
                                 ${
                                 item.discount ?
                                    `<span class="bg-primary px-2 py-1 fs-15 rounded-3 text-white font-weight-bold"> - ${item.discounted_percentage}%</span>`
                                    : '' 
                                 }
                                 </div>
                           
                        </div>
                    </div>
                    <div>
                        <button class="btn-primary add_to_cart_small_btn rounded-circle p-1 d-flex align-items-center justify-content-center g-add-to-cart" style="aspect-ratio:1/1"  data-id="${item.id}" data-skin_code="${item.product_skin}" ><i class="las la-cart-plus fs-20"></i>  </button>
                    </div>
                    
                   
                </div>
            `);
        });
    }

    function fetchCart() {
        $.ajax({
            url: '{{ url("/ajax/cart") }}',  // The URL of the cart endpoint
            method: 'GET',
            success: function (response) {
                if (response.cart) {
                    updateSidecart(response.cart);
                } else {
                    alert('Failed to retrieve cart.');
                }
            },
            error: function () {
                // alert('An error occurred while fetching the cart.');
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

    // $('#search_cat').change(function () {
    //     var select = $(this);
    //     var selectedOption = select.find('option:selected');
    //     var optionWidth = getTextWidth(selectedOption.text(), select.css('font'));
    //     optionWidth += 30
    //     // Set the dropdown width to fit the selected option's text width
    //     select.css('width', optionWidth + 'px');
    // });

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

            document.addEventListener("DOMContentLoaded", function () {
                const helplineLink = document.getElementById("helpline-link");
                const helplineNumber = document.getElementById("helpline-number");

                // Show number when hovering over the helpline text
                helplineLink.addEventListener("mouseover", function () {
                    helplineNumber.style.display = "block";
                });

                // Hide number when mouse leaves both the link and the number
                helplineLink.addEventListener("mouseleave", function () {
                    setTimeout(() => {
                        helplineNumber.style.display = "none";
                    }, 300); // Slight delay to avoid flickering
                });

                helplineNumber.addEventListener("mouseover", function () {
                    helplineNumber.style.display = "block";
                });

                helplineNumber.addEventListener("mouseleave", function () {
                    helplineNumber.style.display = "none";
                });

                // Click on helpline text to call the number
                helplineLink.addEventListener("click", function () {
                    window.location.href = "tel:+923021234123";
                });
            });

        </script>

    @endsection

