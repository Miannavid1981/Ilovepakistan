  <!-- Preloader -->
  <style>
  header {
      padding: 0 50px !important;
  }

        .search-bar {
            border: 1px solid #000;
            border-radius: 50px;
            overflow: hidden;
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
    padding: 10px 20px; 
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
    </style>

<header class="container-fluid bg-white shadow-sm">
        <!-- Header Top -->
        <div class="row align-items-center py-2 header-top">
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
            <div class="col-lg-7 col-md-5 col-8">
                <div class="input-group search-bar">
                    <select class="search-option1" id="search_cat" style="border: unset;
    border-right: 1px solid rgb(0, 0, 0) !important;">
                        <option value="" class="search-option2 ">All Categories</option>
                        @php
                            // Fetch categories with level = 0 and status = 1 directly in the view
                            $categories = \App\Models\Category::where('level', 0)->get();
                        @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="search-option2">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control search-input" id="search"  placeholder="Search products...">
                    <button class="btn btn-light"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                                    
                                <!--</div>-->

                                

                            </div>

                        </div>

                    </div>
            </div>
            <!-- Language and Currency -->
            <div class="col-lg-1 col-md-2 col-6 text-center">
                <p class="mb-0">EN/</p>
                <p class="fw-bold mb-0">PAK</p>
            </div>
          <!-- User Profile and Seller Area with Dropdown -->
            <div class="col-lg-2 col-md-4 col-12 text-center d-flex justify-content-center align-items-center">
                <!-- My Account -->
                <div class="dropdown me-3">
                    <button class="btn  dropdown-toggle " type="button" id="dropdownMyAccount" data-bs-toggle="dropdown" aria-expanded="false">
                       @auth
                       
                           <div class="d-flex">
                                @if ($user->avatar_original != null)
                                    <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                        <img src="{{ $user_avatar }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                    </span>
                                @endif
                                <div class="d-flex flex-column">
                                    <span class="d-block"> Hello, {{$user->name}} </span>
                                    <span class="fw-bold">My Account</span>
                                    
                                </div>
                                
                            </div>
                        @else 
                            <div class="d-flex flex-column">
                                <span class="d-block"> Customer Area</span>
                                <span class="fw-bold">My Account</span>
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
                <div class="dropdown me-3">
                    
                    <button class="btn  dropdown-toggle" type="button" id="dropdownSellerAccount" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex flex-column">
                            <span class="d-block">Seller Area</span>
                            <span class="fw-bold">Store Login</span>
                        </div>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownSellerAccount">
                        
                        <li><a href="{{ route('seller.login') }}" class="dropdown-item">Seller Login</a></li>
                        <li><a href="{{ route('shops.create') }}" class="dropdown-item">Create Your Store</a></li>
                      
                    </ul>
                </div>
            </div>

            <div class="col-lg-1 col-md-2 col-12 text-center">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-badge">0</span>
                <p class="fw-bold mb-0">Cart</p>
            </div>
        </div>

        <!-- Header Bottom -->
        <nav class="navbar  navbar-light bg-white border-top w-100 mx-2">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav w-100">
                        <li class="nav-item me-5">
                            <a class="nav-link btn btn-primary text-dark px-3 py-2 category-btn toggle-btn" href="#" style="border-radius: 20px; background-color: #F5F5F5;">
                                <i class="fa-solid fa-bars"></i> All Categories
                            </a>
                        </li>
                        <li class="nav-item me-5">
                            <a class="nav-link category-btn" href="#">Deals</a>
                        </li>
                        <li class="nav-item me-5">
                            <a class="nav-link category-btn" href="#">Bestsellers</a>
                        </li>
                        <li class="nav-item me-5">
                            <a class="nav-link category-btn" href="#">Top Brands</a>
                        </li>
                        <li class="nav-item me-5">
                            <a class="nav-link category-btn" href="#">Home & Garden</a>
                        </li>
                        <li class="nav-item me-auto">
                            <a class="nav-link category-btn" href="#">Hair Extensions & Wigs</a>
                        </li>
                        <!-- Last three items aligned to the right -->
                        <li class="nav-item me-5">
                            <a class="nav-link category-btn" href="#">About Us</a>
                        </li>
                        <li class="nav-item me-5">
                            <a class="nav-link category-btn" href="#">Contact</a>
                        </li>
                        <li class="nav-item me-5">
                            <a class="nav-link category-btn" href="#">Helpline</a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </nav>

    </header>

 <style>

     /* Preloader container */

#preloader {

  position: fixed;

  top: 0;

  left: 0;

  width: 100%;

  height: 100%;

  background-color: #fff;

  display: flex;

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

    $('.navbar-toggler').click(function(){

        $('.navbar-collapse').slideToggle(300);

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

	const elem = $('header');

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

