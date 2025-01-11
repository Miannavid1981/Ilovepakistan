  <!-- Preloader -->

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

    

    <style>

:root {
    --color-gold: #F1992A;
    --color-black: #000000;
    --color-white: #ffffff;
}



.navbar {
  height: 60px;
  background: #fff !important;
  color: #000 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: space-evenly !important;
  width: 100% !important;
}

.navbar *{
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}

.navlogo {
  height: 50px !important;
  width: 150px !important;
}

.logo {
  background-image: url(https://www.amazon.com/ref=nav_logo) !important;
  height: 50px !important;
  width: 100% !important;
  background-size: cover !important;
}

.border {
  border: 2px solid transparent !important;
  border-radius: 2px !important;
}
/* .border:hover {
  border: 1.5px solid white !important;
} */

.addfirst {
  color: #cccccc !important;
  font-size: 12px !important;
  margin-left: 16px !important;
  align-items: center !important;
}

.addsecond {
  font-size: 14px !important;
  margin-left: 3px !important;
  font-weight: 700 !important;
  align-items: center !important;
}

.addicon {
  display: flex !important;
  align-items: center !important;
}

.nav-search {
  display: flex !important;
  height: 35px !important;
  max-width: 620px !important;
  width:100% !important;
  border-top-left-radius: 4px !important;
  border-bottom-left-radius: 4px !important;
  text-align: center !important;
  background-color: var(--color-gold) !important;
  margin-left: 15px !important;
  border-radius: 4px !important;
  justify-content: space-evenly !important;
  border: 1px solid var(--color-gold);
}

.search-option1 {
  background-color: #f3f3f3 !important;
  border-top-left-radius: 4px !important;
  border-bottom-left-radius: 4px !important;
  /*width: auto !important;*/
  width: 150px ;
  text-align: left !important;
  border: none !important;
  /*max-width: 150px;*/
  padding: 0 10px;
  
}

@media (max-width:768px){
    
    .search-option1 {
    font-size: 12px;
    }
}



.search-input {
  width: 100% !important;
  font-size: 12px!important;
  border: none !important;
  padding-left: 10px;
}

.search-icon {
  width: 45px !important;
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  background-color: var(--color-gold) !important;
  font-size: 1.2rem !important;
  border-top-right-radius: 4px !important;
  color: #fff !important;
  padding: 0 15px;
}

.search-icon::before , .search-icon::after{
    border: unset !important;
    background: unset !important;
}

.nav-search:hover {
  border: 2px solid orange !important;
}

.languageoption {
  height: 50px !important;
  width: 50px !important;
  display: flex !important;
  align-items: center !important;
  padding-left: 6px !important;
}

.american {
  background-image: url(Images/america.webp) !important;
  background-size: cover !important;
  height: 15px !important;
  width: 20px !important;
}

.lanoption {
  font-weight: bolder !important;
  background: transparent !important;
  color: var(--color-black) !important;
  border: none !important;
}

.hello {
  font-size: 12px !important;
  margin-left: 4px !important;
}

.account-sign {
  font-size: 14px !important;
  font-weight: bold !important;
  background: transparent !important;
  color: white !important;
  border: none !important;
}

.return {
  font-size: 12px !important;
}

.order {
  font-size: 14px !important;
  font-weight: bold !important;
}

.cart i {
  font-size: 20px !important;
}

.cart {
  font-size: 0.8rem !important;
  font-weight: 700 !important;
  color: var(--color-black);
}

.fa-cart-shopping:before, .fa-shopping-cart:before {
    color: var(--color-gold);
}

.order, .account-sign{
    color: var(--color-gold) !important;
}

.second-nav {
  height: 30px !important;
  background-color: var(--color-gold) !important;
  align-items: center !important;
  color: white !important;
  justify-content: space-evenly !important;
  display: flex !important;
}

.second-nav p {
  display: inline !important;
}

.allicon {
    padding-left: 8px !important;
    align-items: center !important;
    display: flex !important;
    width: 138px !important;
    height: 36px !important;
    flex-direction: row;
}

.list {
  font-weight: 700 !important;
  margin: 2px !important;
  font-size: 14px !important;
}

.panel-ops {
  width: 70% !important;
  font-size: 0.8rem !important;
}

.ptag {
  margin-left: 15px !important;
}

.deals {
  font-size: 0.9rem !important;
  font-weight: 700 !important;
}


    .sticky {
    position: fixed !important;
    top: 0px;
    z-index: 99999;
    transition: all .3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
  }

.c_dropdown:hover {
    cursor:pointer;
}
.dd-menu {
  position: absolute;
  top: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 0;
  margin: 2px 0 0 0;
  box-shadow: 0 0 6px 0 rgba(0,0,0,0.1);
  background-color: #ffffff;
  list-style-type: none;
  display: none;
  z-index: 999;
}
.dd-menu.open {
    display: block;
}
.dd-input + .dd-menu {
  display: none;
} 

.dd-input:checked + .dd-menu {
  display: block;
} 

.dd-menu li {
  padding: 10px 20px;
  cursor: pointer;
  white-space: nowrap;
}

.dd-menu li:hover {
  background-color: #f6f6f6;
}

.dd-menu li a {
  display: block;
  margin: -10px -20px;
  padding: 0px 20px;
}

.dd-menu li.divider{
  padding: 0;
  border-bottom: 1px solid #cccccc;
}
.navbar_right {
    display: flex;
    gap: 20px;
    align-items: center;
    justify-content: end;
    
}

@media (min-width: 992px){
    .navbar {
        flex-wrap: nowrap;
    }
}
@media (max-width: 1200px){
    .panel-ops {
        display: none ;
    }
    .second-nav {
       
        justify-content: space-between !important;
       
        padding: 0 15px;
        height: 26px !important;
    }
}
@media (max-width: 992px){
    .navbar {
        height: auto !important;
    }
    .navlogo {
        height: 39px !important;
    }
    
    .navbar_right {
        margin-top: 10px !important;
        gap: 6px; !important
    }
    
}


 .cart-btn {
    background: #ffffff;
    opacity: 0.7;
     transform: unset !important; 
    transition: 0.3s;
    overflow: hidden;
    right: 0;
    left: unset;
    /*border: 1px solid #aeaeae;*/
    border-radius: 50%;
    color: #454545 !important;
    opacity: 1;
    margin: 10px;
    width: 40px;
    height: 40px;
    box-shadow: 0px 2px 10px rgb(0 0 0 / 15%);
}

.cart-btn i {
    font-size: 2.3em;
}

.cart-btn:hover {
    background: var(--color-gold) ;
    color: #fff !important;
    border: 1px solid var(--color-gold)  !important;
}

.custom_card_tag {
    background: #FCE585;
    padding: 2px  5px;
    color: #000;
    border-radius: 6px;
    font-size: 12px;
}
.card_outer:hover {
    background: #ffefe3;
    border-radius: 10px;
    cursor: pointer;
}
.card_outer .aiz-p-hov-icon a {
   
    border-radius: 50% !important;
   
}
    </style>

    <script>

        $(document).ready(function(){

    $('.navbar-toggler').click(function(){

        $('.navbar-collapse').slideToggle(300);

    });

// $("#search_cat").select2();
    

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

    
    $(".c_dropdown").click(function (event) {
        // Stop event from propagating to document
        event.stopPropagation();
$(".dd-menu").removeClass("open");
        // Toggle the dropdown menu
        $(this).next(".dd-menu").toggleClass("open");
    });

    // Close the dropdown when clicking outside
    $(document).on("click", function () {
        $(".dd-menu").removeClass("open");
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
    
        <header>
      <div class="navbar">
        <div class="navlogo">
        <a class="d-block  mr-3 ml-0" href="{{ route('home') }}">

            @php

                $header_logo =  get_setting('header_logo');
                $logo_url = 'https://allaaddin.com/public/images/1j+ojFVDOMkX9Wytexe43D6kh.png';
                $my_account_url =  route('profile');
                if( Auth::user() ) {
                    $my_account_url = Auth::user()->user_type == "staff" ? '/admin/profile/' : route('profile');
                }
                
                
            @endphp

            @if ($header_logo != null)

                <img src="{{ $logo_url }}" alt="{{ env('APP_NAME') }}"

                    class="mw-100 h-30px h-md-40px" height="40">

            @else

                <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"

                    class="mw-100 h-30px h-md-40px" height="40" width="50">

            @endif

            </a>
        </div>
        
        <div class="nav-search">
            
           <select class="search-option1" id="search_cat">
                <option value="" class="search-option2 ">All Categories</option>
                @php
                    // Fetch categories with level = 0 and status = 1 directly in the view
                    $categories = \App\Models\Category::where('level', 0)->where('status', 1)->get();
                @endphp
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" class="search-option2">{{ $category->name }}</option>
                @endforeach
            </select>
            <input type="text" placeholder="Search something..." id="search" class="search-input">
            <div class="search-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            
             <!--<div class="d-lg-none ml-auto mr-0">-->

             <!--           <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle"-->

             <!--               data-target=".front-header-search">-->

             <!--               <i class="las la-search la-flip-horizontal la-2x"></i>-->

             <!--           </a>-->

             <!--       </div>-->

                    <!-- Search field -->

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
           <div class="navbar_right" style=" ">
               
           
               <div class="languageoption border">
                    <div class="american"></div>
                    <select class="lanoption">
                        <option value="lan">EN</option>
                    </select>
               </div>
               <div class="sign border">
                   
                   <div class="d-flex">
                           
                        @auth
                            <div class="d-flex">
                                @if ($user->avatar_original != null)
                                    <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                        <img src="{{ $user_avatar }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                    </span>
                                @endif
                            </div>
                           <div>
                                <p class="hello"> Hello, {{$user->name}} </p>
                        @else    
                            <div>
                                <p class="hello"> Customer Area </p>
                         
                        @endauth
                                
                                <div class="account">
                                    <div class="account-sign dropdown-toggle c_dropdown">
                                           My Account  
                                      </div>
                                   
                                    
                                      <ul class="dd-menu">
                                            @auth 
                                                <li><a href="{{ $my_account_url }}" class="text-dark "    @if(Auth::user()->user_type == "staff" ) target="_blank" @endif>My Account</a></li>
                                                <li><a href="{{ $my_account_url }}" class="text-dark " >Orders</a></li>
                                            @else 
                                                <li><a href="{{ route('user.login') }}" class="text-dark ">Login</a></li>
                                                <li><a href="{{ route('user.registration') }}" class="text-dark ">Register</a></li>
                                            @endauth
                                            
                                            @auth 
                                                <li class="divider"></li>
                                                <li>
                                                  <a href="{{ route('logout') }}">Log Out</a>
                                                </li>
                                            
                                            @else 
                                            
                                            
                                            @endauth
                                            
                                      </ul>
                                </div>
                           </div>
                       </div>
                       
                    </div>
              
                    
                    <div>
                        <p class="hello"> Seller Area </p>
                        
                         <div class="account">
                            <div class="account-sign dropdown-toggle c_dropdown">
                                  Seller Account
                               
                              </div>
                           
                            
                              <ul class="dd-menu">
                                   
                                    <li><a href="{{ route('seller.login') }}" class="text-dark ">Seller Login</a></li>
                                    <li><a href="{{ route('shops.create') }}" class="text-dark ">Create Your Store</a></li>
                                    
                                   
                                    
                              </ul>
                        </div>
                   </div>
                   <a href="/cart">
                        <div class="cart border">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Cart
                        </div>
                   </a>
                  
                    
                </div>
          
      </div>
      <div class="second-nav">
        <div class="allicon border toggle-btn">
          <i class="fa-solid fa-bars"></i>
         <p class="list">All Categories</p>
        </div>
        <div class="panel-ops">
          <p class="ptag border">Today's Deals</p>
          <p class="ptag border">Customer Service</p>
          <p class="ptag border">Registry</p> 
          <p class="ptag border">Gift Cards</p>
          <p class="ptag border"> Sell</p>
        </div>
        <div class="deals">
        <i class="fa-solid fa-phone mr-2" style="color: #fff;"></i>

        <span class=" fs-13 text-white">Helpline: &nbsp; +92 42 35942626</span>
        </div>
      </div>
    </header>
 <!-- Search Icon for small device -->

                   
    

    <header class="bg-white text-dark mb-3 d-none" style="">

       

        <!-- Navigation Bar -->

        <div style="background: #008ae0">

             <div class="container d-flex align-items-center justify-content-between py-2" style=" color: black;">

                <div class="d-flex">

                         

                     

                    <!-- Logo Section -->

                    <div class="custom-logo">

                        <a class="d-block  mr-3 ml-0" href="{{ route('home') }}">

                            @php

                                $header_logo = get_setting('header_logo');

                            @endphp

                            @if ($header_logo != null)

                                <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"

                                    class="mw-100 h-30px h-md-40px" height="40">

                            @else

                                <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"

                                    class="mw-100 h-30px h-md-40px" height="40">

                            @endif

                        </a>

                    </div>

                

                    <!-- Mobile View Hamburger Icon (hidden on desktop) -->

                    <button class="d-md-none navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

                        <i class="fas fa-bars" style="color: black; padding-right: 10px;"></i>

                    </button>

                

                    <!-- Navigation Links (Desktop View) -->

                    <nav class="d-none d-md-flex">

                        <ul class="nav">

                            <li class="nav-item">

                                <a class="nav-link" href="#" style="">

                                    <i class="bx bx-like " style=""></i> Home

                                </a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" href="#" style="">

                                    <i class="bx bx-like " style=""></i> All Categories

                                </a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" href="#" style="">

                                    <i class="bx bx-like " style=""></i> Flash Sale

                                </a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" href="#" style="">

                                    <i class="bx bx-like " style=""></i> 

                                </a>

                            </li>

                            <!--<li class="nav-item">-->

                            <!--    <a class="nav-link" href="#" style="color: black;">-->

                            <!--        <i class="bx bx-star" style="color: black;"></i> 5-Star Rated-->

                            <!--    </a>-->

                            <!--</li>-->

                            <!--<li class="nav-item">-->

                            <!--    <a class="nav-link" href="#" style="color: black;">New Arrivals</a>-->

                            <!--</li>-->

                            <!--<li class="nav-item dropdown">-->

                            <!--    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown" style="color: black;">-->

                            <!--        Featured-->

                            <!--    </a>-->

                            <!--    <ul class="dropdown-menu multi-level-dropdown" aria-labelledby="navbarDropdown">-->

                            <!--        <div class="row">-->

                            <!--            <div class="col-md-3">-->

                            <!--                <ul class="list-unstyled">-->

                            <!--                    <li><a class="dropdown-item" href="#">Home & Kitchen</a></li>-->

                            <!--                    <li><a class="dropdown-item" href="#">Women's Clothing</a></li>-->

                            <!--                    <li><a class="dropdown-item" href="#">Women's Curve Clothing</a></li>-->

                            <!--                    <li><a class="dropdown-item" href="#">Women's Shoes</a></li>-->

                            <!--                    <li><a class="dropdown-item" href="#">Men's Clothing</a></li>-->

                            <!--                </ul>-->

                            <!--            </div>-->

                            <!--        </div>-->

                            <!--    </ul>-->

                            <!--</li>-->

                        </ul>

                    </nav>

                

                    <!-- Search Bar -->

                    <div class="d-flex justify-content-center">

                        <div class="search-input-box" style="min-width: 300px;">

                                                <input type="text"

                                                    class="border border-soft-light form-control fs-14 hov-animate-outline"

                                                    id="search_old" name="keyword"

                                                    @isset($query) 

                                                    value="{{ $query }}"

                                                @endisset

                                                    placeholder="{{ translate('I am shopping for...') }}" autocomplete="off">

         

                                                <svg id="Group_723" data-name="Group 723" xmlns="http://www.w3.org/2000/svg"

                                                    width="20.001" height="20" viewBox="0 0 20.001 20">

                                                    <path id="Path_3090" data-name="Path 3090"

                                                        d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z"

                                                        transform="translate(-1.854 -1.854)" fill="#b5b5bf" />

                                                    <path id="Path_3091" data-name="Path 3091"

                                                        d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z"

                                                        transform="translate(-5.2 -5.2)" fill="#b5b5bf" />

                                                </svg>

                                            </div>

                    </div>

                </div>

                <!-- Account and Cart Section (Mobile and Desktop) -->

                <div class="d-flex align-items-center">

                     <!-- Profile Section -->

                     @auth

                       

                        <div class="me-3 text-end d-flex justify-content-center">

                             <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">

                            @if ($user->avatar_original != null)

                                <img src="{{ $user_avatar }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"

                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">

                            @else

                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"

                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">

                            @endif

                        </span>

                            <span style="color: black;" class="d-none d-md-block">

                                Hello, {{$user->name}}<br>

                                <a href="{{ $my_account_url }}" class="text-decoration-none "  @if(Auth::user()->user_type == "staff" ) target="_blank" @endif >Orders & Account</a>

                            </span>

                        </div>

                    

                    @else 

                    

                       

                        <div class="mr-3 text-end d-flex align-items-center justify-content-center" style="gap:10px">

                             <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">

                            

                                

                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"

                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">

                            

                            </span>

                            <span style="color: black;" class="d-none d-md-block">

                                

                                <a href="#" class="text-decoration-none text-white">Login</a>

                            </span>

                            <span style="color: black;" class="d-none d-md-block">

                                

                                <a href="#" class="text-decoration-none text-white">Registration</a>

                            </span>

                        </div>

                    

                    @endauth

            

                    <!-- Support Dropdown (Desktop) -->

                    

                    <!-- Language Dropdown (Desktop) -->

                    <!--<div class="dropdown me-3 language-dropdown d-none d-md-block">-->

                    <!--    <span class="text-dark dropdown-toggle" style="cursor: pointer;">EN</span>-->

                    <!--    <ul class="dropdown-menu">-->

                    <!--        <li><a class="dropdown-item" href="#">English</a></li>-->

                    <!--        <li><a class="dropdown-item" href="#">Spanish</a></li>-->

                    <!--        <li><a class="dropdown-item" href="#">French</a></li>-->

                    <!--    </ul>-->

                    <!--</div>-->

            

                    <!-- Cart Icon (Desktop) -->

                    <a href="/cart" class="cart-icon text-dark d-none d-md-block">

                        <i class="bx bx-cart" style="color: black;"></i>

                    </a>

                </div>

            </div>

        </div>

       

        

        <!-- Mobile View Navbar (Collapsible) -->

        <div class="collapse d-md-none" id="navbarNav">

            <ul class="navbar-nav px-5">

              <li class="nav-item">

                <a class="nav-link" style="">All Categories</a>

              </li>

              <li class="nav-item">

                <a class="nav-link" >5-Star Rated</a>

              </li>

              <li class="nav-item">

                <a class="nav-link" >New Arrivals</a>

              </li>

              <li class="nav-item">

                <a class="nav-link" >Featured</a>

              </li>

            </ul>

        </div>

          

        

        <!-- Mobile View Hamburger Icon -->

        <button class="d-md-none navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon" style="color: black;"></span>

        </button>

  </header>

    

    

    <!--<header class="bg-primary ">-->

    <!--    <div class="container">-->

    <!--        <div class="row">-->

    <!--            <div class="col-3">-->

                    

    <!--            </div>-->

    <!--        </div>-->

    <!--    </div>-->

    <!--    <div class="brand-logo"></div>-->

        

    <!--</header>-->



    <!-- Top Bar -->

   {{-- <div class="top-navbar bg-white z-1035 h-35px h-sm-auto " style="10px">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 col">

                    <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">

                        <!-- Language switcher -->

                        @if (get_setting('show_language_switcher') == 'on')

                            <li class="list-inline-item dropdown mr-4" id="lang-change">

                                

                                <a href="javascript:void(0)" class="dropdown-toggle text-secondary fs-12 py-2"

                                    data-toggle="dropdown" data-display="static">

                                    <span class="">{{ $system_language->name }}</span>

                                </a>

                                <ul class="dropdown-menu dropdown-menu-left">

                                    @foreach (get_all_active_language() as $key => $language)

                                        <li>

                                            <a href="javascript:void(0)" data-flag="{{ $language->code }}"

                                                class="dropdown-item @if ($system_language->code == $language->code) active @endif">

                                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}"

                                                    data-src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"

                                                    class="mr-1 lazyload" alt="{{ $language->name }}" height="11">

                                                <span class="language">{{ $language->name }}</span>

                                            </a>

                                        </li>

                                    @endforeach

                                </ul>

                            </li>

                        @endif



                        <!-- Currency Switcher 

                        @if (get_setting('show_currency_switcher') == 'on')

                            <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0" id="currency-change">

                                @php

                                    $system_currency = get_system_currency();

                                @endphp



                                <a href="javascript:void(0)" class="dropdown-toggle text-secondary fs-12 py-2"

                                    data-toggle="dropdown" data-display="static">

                                    {{ $system_currency->name }}

                                </a>

                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">

                                    @foreach (get_all_active_currency() as $key => $currency)

                                        <li>

                                            <a class="dropdown-item @if ($system_currency->code == $currency->code) active @endif"

                                                href="javascript:void(0)"

                                                data-currency="{{ $currency->code }}">{{ $currency->name }}

                                                ({{ $currency->symbol }})</a>

                                        </li>

                                    @endforeach

                                </ul>

                            </li>

                        @endif

                        -->

                    </ul>

                </div>



                <div class="col-6 text-right d-none d-lg-block">

                    <ul class="list-inline mb-0 h-100 d-flex justify-content-end align-items-center">

                        @if (get_setting('vendor_system_activation') == 1)

                            <!-- Become a Seller -->

                            <li class="list-inline-item mr-0 pl-0 py-2">

                                <a href="{{ route('shops.create') }}"

                                    class="text-secondary fs-12 pr-3 d-inline-block border-width-2 border-right">{{ translate('Become a Seller !') }}</a>

                            </li>

                            <!-- Seller Login -->

                            <li class="list-inline-item mr-0 pl-0 py-2">

                                <a href="{{ route('seller.login') }}"

                                    class="text-secondary fs-12 pl-3 d-inline-block">{{ translate('Login to Seller') }}</a>

                            </li>

                        @endif

                        @if (get_setting('helpline_number'))

                            <!-- Helpline -->

                            <li class="list-inline-item ml-3 pl-3 mr-0 pr-0">

                                <a href="tel:{{ get_setting('helpline_number') }}"

                                    class="text-secondary fs-12 d-inline-block py-2">

                                    <span>{{ translate('Helpline') }}</span>

                                    <span>{{ get_setting('helpline_number') }}</span>

                                </a>

                            </li>

                        @endif

                    </ul>

                </div>

            </div>

        </div>

    </div> --}}



    <header class="@if (get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white d-none ">

        <!-- Search Bar -->

        <div class="position-relative logo-bar-area border-bottom border-md-nonea z-1025" style="70px;">

            <div class="container">

                <div class="d-flex align-items-center">

                    <!-- top menu sidebar button -->

                    <button type="button" class="btn d-lg-none mr-3 mr-sm-4 p-0 active" data-toggle="class-toggle"

                        data-target=".aiz-top-menu-sidebar">

                        <svg id="Component_43_1" data-name="Component 43 – 1" xmlns="http://www.w3.org/2000/svg"

                            width="16" height="16" viewBox="0 0 16 16">

                            <rect id="Rectangle_19062" data-name="Rectangle 19062" width="16" height="2"

                                transform="translate(0 7)" fill="#919199" />

                            <rect id="Rectangle_19063" data-name="Rectangle 19063" width="16" height="2"

                                fill="#919199" />

                            <rect id="Rectangle_19064" data-name="Rectangle 19064" width="16" height="2"

                                transform="translate(0 14)" fill="#919199" />

                        </svg>



                    </button>

                    <!-- Header Logo -->

                    <div class="col-auto pl-0 pr-3 d-flex align-items-center">

                        <a class="d-block py-20px mr-3 ml-0" href="{{ route('home') }}">

                            @php

                                $header_logo = get_setting('header_logo');

                            @endphp

                            @if ($header_logo != null)

                                <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"

                                    class="mw-100 h-30px h-md-40px" height="40">

                            @else

                                <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"

                                    class="mw-100 h-30px h-md-40px" height="40">

                            @endif

                        </a>

                    </div>

                    <!-- Search Icon for small device -->

                    <!--<div class="d-lg-none ml-auto mr-0">-->

                    <!--    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle"-->

                    <!--        data-target=".front-header-search">-->

                    <!--        <i class="las la-search la-flip-horizontal la-2x"></i>-->

                    <!--    </a>-->

                    <!--</div>-->

                    <!-- Search field -->

                    <!--<div class="flex-grow-1 front-header-search d-flex align-items-center bg-white mx-xl-5">-->

                    <!--    <div class="position-relative flex-grow-1 px-3 px-lg-0">-->

                    <!--        <form action="{{ route('search') }}" method="GET" class="stop-propagation">-->

                    <!--            <div class="d-flex position-relative align-items-center">-->

                    <!--                <div class="d-lg-none" data-toggle="class-toggle"-->

                    <!--                    data-target=".front-header-search">-->

                    <!--                    <button class="btn px-2" type="button">-->
                    <!--                        <i class="la la-2x la-long-arrow-left"></i>-->
                    <!--                    </button>-->
                    <!--                </div>-->

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

                    <!--            </div>-->

                    <!--        </form>-->

                    <!--        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"-->

                    <!--            style="min-height: 200px">-->

                    <!--            <div class="search-preloader absolute-top-center">-->

                    <!--                <div class="dot-loader">-->

                    <!--                    <div></div>-->

                    <!--                    <div></div>-->

                    <!--                    <div></div>-->

                    <!--                </div>-->

                    <!--            </div>-->

                    <!--            <div class="search-nothing d-none p-3 text-center fs-16">-->



                    <!--            </div>-->

                    <!--            <div id="search-content" class="text-left">-->



                    <!--            </div>-->

                    <!--        </div>-->

                    <!--    </div>-->

                    <!--</div>-->

                    <!-- Search box -->

                    <div class="d-none d-lg-none ml-3 mr-0">

                        <div class="nav-search-box">

                            <a href="#" class="nav-box-link">

                                <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>

                            </a>

                        </div>

                    </div>

                    <!-- Compare -->

                    <div class="d-none d-lg-block ml-3 mr-0">

                        <div class="" id="compare">

                            @include('frontend.partials.compare')

                        </div>

                    </div>

                    <!-- Wishlist -->

                    <div class="d-none d-lg-block mr-3" style="margin-left: 36px;">

                        <div class="" id="wishlist">

                            @include('frontend.partials.wishlist')

                        </div>

                    </div>

                    @if (!isAdmin())

                        <!-- Notifications -->

                        <ul class="list-inline mb-0 h-100 d-none d-xl-flex justify-content-end align-items-center">

                            <li class="list-inline-item ml-3 mr-3 pr-3 pl-0 dropdown">

                                <a class="dropdown-toggle no-arrow text-secondary fs-12" data-toggle="dropdown"

                                    href="javascript:void(0);" role="button" aria-haspopup="false"

                                    aria-expanded="false">

                                    <span class="">

                                        <span class="position-relative d-inline-block">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="14.668" height="16"

                                                viewBox="0 0 14.668 16">

                                                <path id="_26._Notification" data-name="26. Notification"

                                                    d="M8.333,16A3.34,3.34,0,0,0,11,14.667H5.666A3.34,3.34,0,0,0,8.333,16ZM15.06,9.78a2.457,2.457,0,0,1-.727-1.747V6a6,6,0,1,0-12,0V8.033A2.457,2.457,0,0,1,1.606,9.78,2.083,2.083,0,0,0,3.08,13.333H13.586A2.083,2.083,0,0,0,15.06,9.78Z"

                                                    transform="translate(-0.999)" fill="#91919b" />

                                            </svg>

                                            @if (Auth::check() && count($user->unreadNotifications) > 0)

                                                <span class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{ count($user->unreadNotifications) }}</span>

                                            @endif

                                        </span>

                                </a>



                                @auth

                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0 rounded-0">

                                        <div class="p-3 bg-light border-bottom">

                                            <h6 class="mb-0">{{ translate('Notifications') }}</h6>

                                        </div>

                                        <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">

                                            <ul class="list-group list-group-flush">

                                                @forelse($user->unreadNotifications as $notification)

                                                    <li class="list-group-item">

                                                        @if ($notification->type == 'App\Notifications\OrderNotification')

                                                            @if ($user->user_type == 'customer')

                                                                <a href="{{ route('purchase_history.details', encrypt($notification->data['order_id'])) }}"

                                                                    class="text-secondary fs-12">

                                                                    <span class="ml-2">

                                                                        {{ translate('Order code: ') }}

                                                                        {{ $notification->data['order_code'] }}

                                                                        {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}

                                                                    </span>

                                                                </a>

                                                            @elseif ($user->user_type == 'seller')

                                                                <a href="{{ route('seller.orders.show', encrypt($notification->data['order_id'])) }}"

                                                                    class="text-secondary fs-12">

                                                                    <span class="ml-2">

                                                                        {{ translate('Order code: ') }}

                                                                        {{ $notification->data['order_code'] }}

                                                                        {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}

                                                                    </span>

                                                                </a>

                                                            @endif

                                                        @endif

                                                    </li>

                                                @empty

                                                    <li class="list-group-item">

                                                        <div class="py-4 text-center fs-16">

                                                            {{ translate('No notification found') }}

                                                        </div>

                                                    </li>

                                                @endforelse

                                            </ul>

                                        </div>

                                        <div class="text-center border-top">

                                            <a href="{{ route('all-notifications') }}"

                                                class="text-secondary fs-12 d-block py-2">

                                                {{ translate('View All Notifications') }}

                                            </a>

                                        </div>

                                    </div>

                                @endauth

                            </li>

                        </ul>

                    @endif



                    <div class="ml-auto mr-0">

                        @auth

                            <div class="dropdown">

                                <button class="btn dropdown-toggle d-none d-xl-flex align-items-center nav-user-info py-2 @if (isAdmin()) ml-5 @endif" 

                                    id="dropdownUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <!-- Image -->

                                    <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">

                                        @if ($user->avatar_original != null)

                                            <img src="{{ $user_avatar }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"

                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">

                                        @else

                                            <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="img-fit h-100 w-100" alt="{{ translate('avatar') }}"

                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">

                                        @endif

                                    </span>

                                    <!-- Name -->

                                    <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0 nav-user-name">{{ $user->name }}</h4>

                                </button>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUserMenu">

                                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>

                                </div>

                            </div>

                        @else

                            <!-- Login & Registration -->

                            <span class="d-none d-xl-flex align-items-center nav-user-info ml-3">

                                <!-- Placeholder Image -->

                                <span class="size-40px rounded-circle overflow-hidden border d-flex align-items-center justify-content-center nav-user-img">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">

                                        <path id="user-icon"

                                            d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"

                                            transform="translate(-2.064 -1.995)" fill="#91919b" />

                                    </svg>

                                </span>

                                <a href="{{ route('user.login') }}"

                                    class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login') }}</a>

                                <a href="{{ route('user.registration') }}"

                                    class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Registration') }}</a>

                            </span>

                        @endauth

                    </div>

                </div>

            </div>



            <!-- Loged in user Menus -->

            <div class="hover-user-top-menu position-absolute top-100 left-0 right-0 z-3">

                <div class="container">

                    <div class="position-static float-right">

                        <div class="aiz-user-top-menu bg-white rounded-0 border-top shadow-sm" style="width:220px;">

                            <ul class="list-unstyled no-scrollbar mb-0 text-left">

                                @if (isAdmin())

                                    <li class="user-top-nav-element border border-top-0" data-id="1">

                                        <a href="{{ route('admin.dashboard') }}"

                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"

                                                viewBox="0 0 16 16">

                                                <path id="Path_2916" data-name="Path 2916"

                                                    d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z"

                                                    fill="#b5b5c0" />

                                            </svg>

                                            <span

                                                class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>

                                        </a>

                                    </li>

                                @else

                                    <li class="user-top-nav-element border border-top-0" data-id="1">

                                        <a href="{{ route('dashboard') }}"

                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"

                                                viewBox="0 0 16 16">

                                                <path id="Path_2916" data-name="Path 2916"

                                                    d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z"

                                                    fill="#b5b5c0" />

                                            </svg>

                                            <span

                                                class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>

                                        </a>

                                    </li>

                                @endif



                                @if (isCustomer())

                                    <li class="user-top-nav-element border border-top-0" data-id="1">

                                        <a href="{{ route('purchase_history.index') }}"

                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"

                                                viewBox="0 0 16 16">

                                                <g id="Group_25261" data-name="Group 25261"

                                                    transform="translate(-27.466 -542.963)">

                                                    <path id="Path_2953" data-name="Path 2953"

                                                        d="M14.5,5.963h-4a1.5,1.5,0,0,0,0,3h4a1.5,1.5,0,0,0,0-3m0,2h-4a.5.5,0,0,1,0-1h4a.5.5,0,0,1,0,1"

                                                        transform="translate(22.966 537)" fill="#b5b5bf" />

                                                    <path id="Path_2954" data-name="Path 2954"

                                                        d="M12.991,8.963a.5.5,0,0,1,0-1H13.5a2.5,2.5,0,0,1,2.5,2.5v10a2.5,2.5,0,0,1-2.5,2.5H2.5a2.5,2.5,0,0,1-2.5-2.5v-10a2.5,2.5,0,0,1,2.5-2.5h.509a.5.5,0,0,1,0,1H2.5a1.5,1.5,0,0,0-1.5,1.5v10a1.5,1.5,0,0,0,1.5,1.5h11a1.5,1.5,0,0,0,1.5-1.5v-10a1.5,1.5,0,0,0-1.5-1.5Z"

                                                        transform="translate(27.466 536)" fill="#b5b5bf" />

                                                    <path id="Path_2955" data-name="Path 2955"

                                                        d="M7.5,15.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"

                                                        transform="translate(23.966 532)" fill="#b5b5bf" />

                                                    <path id="Path_2956" data-name="Path 2956"

                                                        d="M7.5,21.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"

                                                        transform="translate(23.966 529)" fill="#b5b5bf" />

                                                    <path id="Path_2957" data-name="Path 2957"

                                                        d="M7.5,27.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"

                                                        transform="translate(23.966 526)" fill="#b5b5bf" />

                                                    <path id="Path_2958" data-name="Path 2958"

                                                        d="M13.5,16.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"

                                                        transform="translate(20.966 531.5)" fill="#b5b5bf" />

                                                    <path id="Path_2959" data-name="Path 2959"

                                                        d="M13.5,22.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"

                                                        transform="translate(20.966 528.5)" fill="#b5b5bf" />

                                                    <path id="Path_2960" data-name="Path 2960"

                                                        d="M13.5,28.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"

                                                        transform="translate(20.966 525.5)" fill="#b5b5bf" />

                                                </g>

                                            </svg>

                                            <span

                                                class="user-top-menu-name has-transition ml-3">{{ translate('Purchase History') }}</span>

                                        </a>

                                    </li>

                                    <li class="user-top-nav-element border border-top-0" data-id="1">

                                        <a href="{{ route('digital_purchase_history.index') }}"

                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16.001" height="16"

                                                viewBox="0 0 16.001 16">

                                                <g id="Group_25262" data-name="Group 25262"

                                                    transform="translate(-1388.154 -562.604)">

                                                    <path id="Path_2963" data-name="Path 2963"

                                                        d="M77.864,98.69V92.1a.5.5,0,1,0-1,0V98.69l-1.437-1.437a.5.5,0,0,0-.707.707l1.851,1.852a1,1,0,0,0,.707.293h.172a1,1,0,0,0,.707-.293l1.851-1.852a.5.5,0,0,0-.7-.713Z"

                                                        transform="translate(1318.79 478.5)" fill="#b5b5bf" />

                                                    <path id="Path_2964" data-name="Path 2964"

                                                        d="M67.155,88.6a3,3,0,0,1-.474-5.963q-.009-.089-.015-.179a5.5,5.5,0,0,1,10.977-.718,3.5,3.5,0,0,1-.989,6.859h-1.5a.5.5,0,0,1,0-1l1.5,0a2.5,2.5,0,0,0,.417-4.967.5.5,0,0,1-.417-.5,4.5,4.5,0,1,0-8.908.866.512.512,0,0,1,.009.121.5.5,0,0,1-.52.479,2,2,0,1,0-.162,4l.081,0h2a.5.5,0,0,1,0,1Z"

                                                        transform="translate(1324 486)" fill="#b5b5bf" />

                                                </g>

                                            </svg>

                                            <span

                                                class="user-top-menu-name has-transition ml-3">{{ translate('Downloads') }}</span>

                                        </a>

                                    </li>

                                    @if (get_setting('conversation_system') == 1)

                                        <li class="user-top-nav-element border border-top-0" data-id="1">

                                            <a href="{{ route('conversations.index') }}"

                                                class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"

                                                    viewBox="0 0 16 16">

                                                    <g id="Group_25263" data-name="Group 25263"

                                                        transform="translate(1053.151 256.688)">

                                                        <path id="Path_3012" data-name="Path 3012"

                                                            d="M134.849,88.312h-8a2,2,0,0,0-2,2v5a2,2,0,0,0,2,2v3l2.4-3h5.6a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2m1,7a1,1,0,0,1-1,1h-8a1,1,0,0,1-1-1v-5a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z"

                                                            transform="translate(-1178 -341)" fill="#b5b5bf" />

                                                        <path id="Path_3013" data-name="Path 3013"

                                                            d="M134.849,81.312h8a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h-.5a.5.5,0,0,0,0,1h.5a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2h-8a2,2,0,0,0-2,2v.5a.5.5,0,0,0,1,0v-.5a1,1,0,0,1,1-1"

                                                            transform="translate(-1182 -337)" fill="#b5b5bf" />

                                                        <path id="Path_3014" data-name="Path 3014"

                                                            d="M131.349,93.312h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"

                                                            transform="translate(-1181 -343.5)" fill="#b5b5bf" />

                                                        <path id="Path_3015" data-name="Path 3015"

                                                            d="M131.349,99.312h5a.5.5,0,1,1,0,1h-5a.5.5,0,1,1,0-1"

                                                            transform="translate(-1181 -346.5)" fill="#b5b5bf" />

                                                    </g>

                                                </svg>

                                                <span

                                                    class="user-top-menu-name has-transition ml-3">{{ translate('Conversations') }}</span>

                                            </a>

                                        </li>

                                    @endif



                                    @if (get_setting('wallet_system') == 1)

                                        <li class="user-top-nav-element border border-top-0" data-id="1">

                                            <a href="{{ route('wallet.index') }}"

                                                class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                                <svg xmlns="http://www.w3.org/2000/svg"

                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="16"

                                                    height="16" viewBox="0 0 16 16">

                                                    <defs>

                                                        <clipPath id="clip-path1">

                                                            <rect id="Rectangle_1386" data-name="Rectangle 1386"

                                                                width="16" height="16" fill="#b5b5bf" />

                                                        </clipPath>

                                                    </defs>

                                                    <g id="Group_8102" data-name="Group 8102"

                                                        clip-path="url(#clip-path1)">

                                                        <path id="Path_2936" data-name="Path 2936"

                                                            d="M13.5,4H13V2.5A2.5,2.5,0,0,0,10.5,0h-8A2.5,2.5,0,0,0,0,2.5v11A2.5,2.5,0,0,0,2.5,16h11A2.5,2.5,0,0,0,16,13.5v-7A2.5,2.5,0,0,0,13.5,4M2.5,1h8A1.5,1.5,0,0,1,12,2.5V4H2.5a1.5,1.5,0,0,1,0-3M15,11H10a1,1,0,0,1,0-2h5Zm0-3H10a2,2,0,0,0,0,4h5v1.5A1.5,1.5,0,0,1,13.5,15H2.5A1.5,1.5,0,0,1,1,13.5v-9A2.5,2.5,0,0,0,2.5,5h11A1.5,1.5,0,0,1,15,6.5Z"

                                                            fill="#b5b5bf" />

                                                    </g>

                                                </svg>

                                                <span

                                                    class="user-top-menu-name has-transition ml-3">{{ translate('My Wallet') }}</span>

                                            </a>

                                        </li>

                                    @endif

                                    <li class="user-top-nav-element border border-top-0" data-id="1">

                                        <a href="{{ route('support_ticket.index') }}"

                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16.001"

                                                viewBox="0 0 16 16.001">

                                                <g id="Group_25259" data-name="Group 25259"

                                                    transform="translate(-316 -1066)">

                                                    <path id="Subtraction_184" data-name="Subtraction 184"

                                                        d="M16427.109,902H16420a8.015,8.015,0,1,1,8-8,8.278,8.278,0,0,1-1.422,4.535l1.244,2.132a.81.81,0,0,1,0,.891A.791.791,0,0,1,16427.109,902ZM16420,887a7,7,0,1,0,0,14h6.283c.275,0,.414,0,.549-.111s-.209-.574-.34-.748l0,0-.018-.022-1.064-1.6A6.829,6.829,0,0,0,16427,894a6.964,6.964,0,0,0-7-7Z"

                                                        transform="translate(-16096 180)" fill="#b5b5bf" />

                                                    <path id="Union_12" data-name="Union 12"

                                                        d="M16414,895a1,1,0,1,1,1,1A1,1,0,0,1,16414,895Zm.5-2.5V891h.5a2,2,0,1,0-2-2h-1a3,3,0,1,1,3.5,2.958v.54a.5.5,0,1,1-1,0Zm-2.5-3.5h1a.5.5,0,1,1-1,0Z"

                                                        transform="translate(-16090.998 183.001)" fill="#b5b5bf" />

                                                </g>

                                            </svg>

                                            <span

                                                class="user-top-menu-name has-transition ml-3">{{ translate('Support Ticket') }}</span>

                                        </a>

                                    </li>

                                @endif

                                <li class="user-top-nav-element border border-top-0" data-id="1">

                                    <a href="{{ route('logout') }}"

                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.999"

                                            viewBox="0 0 16 15.999">

                                            <g id="Group_25503" data-name="Group 25503"

                                                transform="translate(-24.002 -377)">

                                                <g id="Group_25265" data-name="Group 25265"

                                                    transform="translate(-216.534 -160)">

                                                    <path id="Subtraction_192" data-name="Subtraction 192"

                                                        d="M12052.535,2920a8,8,0,0,1-4.569-14.567l.721.72a7,7,0,1,0,7.7,0l.721-.72a8,8,0,0,1-4.567,14.567Z"

                                                        transform="translate(-11803.999 -2367)" fill="#d43533" />

                                                </g>

                                                <rect id="Rectangle_19022" data-name="Rectangle 19022" width="1"

                                                    height="8" rx="0.5" transform="translate(31.5 377)"

                                                    fill="#d43533" />

                                            </g>

                                        </svg>

                                        <span

                                            class="user-top-menu-name text-primary has-transition ml-3">{{ translate('Logout') }}</span>

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- Menu Bar -->

        <div class="d-none d-lg-block position-relative bg-primary h-50px">

            <div class="container h-100">

                <div class="d-flex h-100">

                    <!-- Categoty Menu Button -->

                    <div class="d-none d-xl-block all-category has-transition bg-black-10" id="category-menu-bar">

                        <div class="px-3 h-100"

                            style="padding-top: 12px;padding-bottom: 12px; width:270px; cursor: pointer;">

                            <div class="d-flex align-items-center justify-content-between">

                                <div>

                                    <span class="fw-700 fs-16 text-white mr-3">{{ translate('Categories') }}</span>

                                    <a href="{{ route('categories.all') }}" class="text-reset">

                                        <span

                                            class="d-none d-lg-inline-block text-white hov-opacity-80">({{ translate('See All') }})</span>

                                    </a>

                                </div>

                                <i class="las la-angle-down text-white has-transition" id="category-menu-bar-icon"

                                    style="font-size: 1.2rem !important"></i>

                            </div>

                        </div>

                    </div>

                    <!-- Header Menus -->

                    <div class="ml-xl-4 w-100">

                        <div class="d-flex align-items-center justify-content-center justify-content-xl-start h-100">

                            <ul class="list-inline mb-0 pl-0 hor-swipe c-scrollbar-light">

                                @if (get_setting('header_menu_labels') != null)

                                    @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)

                                        <li class="list-inline-item mr-0 animate-underline-white">

                                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"

                                                class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10

                                            @if (url()->current() == json_decode(get_setting('header_menu_links'), true)[$key]) active @endif">

                                                {{ translate($value) }}

                                            </a>

                                        </li>

                                    @endforeach

                                @endif

                            </ul>

                        </div>

                    </div>

                    <!-- Cart -->

                    <div class="d-none d-xl-block align-self-stretch ml-5 mr-0 has-transition bg-black-10"

                        data-hover="dropdown">

                        <div class="nav-cart-box dropdown h-100" id="cart_items" style="width: max-content;">

                            @include('frontend.partials.cart')

                        </div>

                    </div>

                </div>

            </div>

            <!-- Categoty Menus -->

            <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 z-3 d-none"

                id="click-category-menu">

                <div class="container">

                    <div class="d-flex position-relative">

                        <div class="position-static">

                            @include('frontend.partials.category_menu')

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </header>



    <!-- Top Menu Sidebar -->

    <div class="aiz-top-menu-sidebar collapse-sidebar-wrap sidebar-xl sidebar-left d-lg-none z-1035">

        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"

            data-target=".aiz-top-menu-sidebar" data-same=".hide-top-menu-bar"></div>

        <div class="collapse-sidebar c-scrollbar-light text-left">

            <button type="button" class="btn btn-sm p-4 hide-top-menu-bar" data-toggle="class-toggle"

                data-target=".aiz-top-menu-sidebar">

                <i class="las la-times la-2x text-primary"></i>

            </button>

            @auth

                <span class="d-flex align-items-center nav-user-info pl-4">

                    <!-- Image -->

                    <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">

                        @if ($user->avatar_original != null)

                            <img src="{{ $user_avatar }}" class="img-fit h-100" alt="{{ translate('avatar') }}"

                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">

                        @else

                            <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image" alt="{{ translate('avatar') }}"

                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">

                        @endif

                    </span>

                    <!-- Name -->

                    <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0">{{ $user->name }}</h4>

                </span>

            @else

                <!--Login & Registration -->

                <span class="d-flex align-items-center nav-user-info pl-4">

                    <!-- Image -->

                    <span

                        class="size-40px rounded-circle overflow-hidden border d-flex align-items-center justify-content-center nav-user-img">

                        <svg xmlns="http://www.w3.org/2000/svg" width="19.902" height="20.012"

                            viewBox="0 0 19.902 20.012">

                            <path id="fe2df171891038b33e9624c27e96e367"

                                d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"

                                transform="translate(-2.064 -1.995)" fill="#91919b" />

                        </svg>

                    </span>

                    <a href="{{ route('user.login') }}"

                        class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login') }}</a>

                    <a href="{{ route('user.registration') }}"

                        class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Registration') }}</a>

                </span>

            @endauth

            <hr>

            <ul class="mb-0 pl-3 pb-3 h-100">

                @if (get_setting('header_menu_labels') != null)

                    @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)

                        <li class="mr-0">

                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"

                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links

                            @if (url()->current() == json_decode(get_setting('header_menu_links'), true)[$key]) active @endif">

                                {{ translate($value) }}

                            </a>

                        </li>

                    @endforeach

                @endif

                @auth

                    @if (isAdmin())

                        <hr>

                        <li class="mr-0">

                            <a href="{{ route('admin.dashboard') }}"

                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links">

                                {{ translate('My Account') }}

                            </a>

                        </li>

                    @else

                        <hr>

                        <li class="mr-0">

                            <a href="{{ route('dashboard') }}"

                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links

                                {{ areActiveRoutes(['dashboard'], ' active') }}">

                                {{ translate('My Account') }}

                            </a>

                        </li>

                    @endif

                    @if (isCustomer())

                        <li class="mr-0">

                            <a href="{{ route('all-notifications') }}"

                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links

                                {{ areActiveRoutes(['all-notifications'], ' active') }}">

                                {{ translate('Notifications') }}

                            </a>

                        </li>

                        <li class="mr-0">

                            <a href="{{ route('wishlists.index') }}"

                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links

                                {{ areActiveRoutes(['wishlists.index'], ' active') }}">

                                {{ translate('Wishlist') }}

                            </a>

                        </li>

                        <li class="mr-0">

                            <a href="{{ route('compare') }}"

                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links

                                {{ areActiveRoutes(['compare'], ' active') }}">

                                {{ translate('Compare') }}

                            </a>

                        </li>

                    @endif

                    <hr>

                    <li class="mr-0">

                        <a href="{{ route('logout') }}"

                            class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-primary header_menu_links">

                            {{ translate('Logout') }}

                        </a>

                    </li>

                @endauth

            </ul>

            <br>

            <br>

        </div>

    </div>



    <!-- Modal -->

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

            <div class="modal-content">

                <div id="order-details-modal-body">



                </div>

            </div>

        </div>

    </div>

    <!--@if (isset($carts) && count($carts) > 0)-->

 @if(Request::is('checkout') || Request::is('cart') || Request::is('checkout/order-confirmed') || Request::is('checkout/payment')  || Request::is('checkout/delivery-info'))

    @else

    <!--<div id="proceedOrderPopup" class="btn btn-primary rounded-4 proceed-order-popup" style="display:none;position: fixed;top: 50%;right: 0;color:white;background:#d4b039;" onclick="location.href='{{ route('cart') }}'">-->

        <!--<button >Proceed with Order</button>-->

    <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="20.562" viewBox="0 0 24 20.562">-->

    <!--            <g id="_5e67fc94b53aaec8ca181b806dd815ee" data-name="5e67fc94b53aaec8ca181b806dd815ee" transform="translate(-33.276 -101)">-->

    <!--            <path id="Path_32659" data-name="Path 32659" d="M34.034,102.519H38.2l-.732-.557c.122.37.243.739.365,1.112q.441,1.333.879,2.666.528,1.6,1.058,3.211.46,1.394.917,2.788c.149.451.291.9.446,1.352l.008.02a.76.76,0,0,0,1.466-.4c-.122-.37-.243-.739-.365-1.112q-.441-1.333-.879-2.666-.528-1.607-1.058-3.213-.46-1.394-.917-2.788c-.149-.451-.289-.9-.446-1.352l-.008-.02a.783.783,0,0,0-.732-.557H34.037a.76.76,0,0,0,0,1.519Z" fill="#fff"></path>-->

    <!--            <path id="Path_32660" data-name="Path 32660" d="M288.931,541.934q-.615,1.1-1.233,2.193c-.058.106-.119.21-.177.317a.767.767,0,0,0,.656,1.142h11.6c.534,0,1.071.01,1.608,0h.023a.76.76,0,0,0,0-1.519h-11.6c-.534,0-1.074-.015-1.608,0h-.023l.656,1.142q.615-1.1,1.233-2.193c.058-.106.119-.21.177-.316a.759.759,0,0,0-1.312-.765Z" transform="translate(-247.711 -429.41)" fill="#fff"></path>-->

    <!--            <circle id="Ellipse_553" data-name="Ellipse 553" cx="1.724" cy="1.724" r="1.724" transform="translate(49.612 117.606)" fill="#fff"></circle>-->

    <!--            <path id="Path_32661" data-name="Path 32661" d="M658.4,739.2a2.267,2.267,0,0,0,1.489,2.1,2.232,2.232,0,0,0,2.433-.648A2.231,2.231,0,1,0,658.4,739.2a.506.506,0,0,0,1.013,0c0-.041,0-.084.005-.124a.381.381,0,0,1,.005-.053c.008-.1,0,.033-.005.03a.979.979,0,0,1,.061-.248c.008-.02.023-.106.04-.111s-.046.094-.018.043a.656.656,0,0,0,.028-.061,2.3,2.3,0,0,1,.129-.215c.048-.073-.068.078.013-.015.025-.028.051-.058.078-.086s.056-.056.084-.081l.038-.033c.018-.015.091-.051.025-.023s-.015.013,0,0,.035-.025.056-.038a.947.947,0,0,1,.086-.051c.038-.023.078-.041.119-.061.013-.008.066-.033,0,0s.025-.008.033-.01A1.56,1.56,0,0,1,660.4,738l.068-.013c.056-.013-.048.005-.048.005.046,0,.094-.01.139-.01a2.043,2.043,0,0,1,.248.008c.094.008-.1-.018.02.005.046.008.089.02.134.03s.076.023.114.035a.589.589,0,0,1,.063.023c0,.008-.094-.048-.043-.018.071.043.149.076.22.122.018.013.035.025.056.038s.056.023,0,0-.018-.015,0,0l.051.043a2.274,2.274,0,0,1,.172.177c.076.084-.035-.058.013.015.02.033.043.063.063.1s.041.068.058.1l.023.046c.048.091.01-.008,0-.013.03.01.063.192.073.225l.023.1c.02.1,0-.03,0-.033.013.013.008.071.008.086a1.749,1.749,0,0,1,0,.23.63.63,0,0,0-.005.071c0,.051-.03.043.005-.03a.791.791,0,0,0-.028.134c-.018.071-.046.139-.066.21s.046-.086.013-.028a.245.245,0,0,0-.02.046c-.02.041-.041.078-.063.117s-.041.066-.063.1c-.068.1.048-.051-.01.018a1.932,1.932,0,0,1-.172.18c-.01.01-.071.076-.089.076,0,0,.1-.071.023-.02-.015.01-.028.018-.041.028-.071.046-.144.084-.218.122s.091-.03-.018.008l-.111.038-.116.03c-.018,0-.033.008-.051.01-.111.025.081-.005.015,0a2.045,2.045,0,0,1-.248.01c-.041,0-.081-.005-.124-.008-.015,0-.076-.008,0,0s-.018-.005-.035-.008a1.912,1.912,0,0,1-.261-.076c-.015-.005-.066-.03,0,0s-.015-.008-.03-.015c-.041-.02-.078-.041-.117-.063s-.073-.048-.111-.073c-.061-.038.008.02.023.02-.01,0-.043-.035-.051-.043a1.872,1.872,0,0,1-.187-.187.3.3,0,0,1-.043-.051c0,.01.061.086.02.023-.025-.038-.051-.073-.073-.111s-.048-.089-.071-.132c-.053-.1.025.081-.015-.033a1.836,1.836,0,0,1-.073-.263.163.163,0,0,0-.01-.051c.038.084.008.071,0,.013s-.008-.106-.008-.16a.513.513,0,0,0-1.026,0Z" transform="translate(-609.293 -619.872)" fill="#fff"></path>-->

    <!--            <circle id="Ellipse_554" data-name="Ellipse 554" cx="1.724" cy="1.724" r="1.724" transform="translate(40.884 117.606)" fill="#fff"></circle>-->

    <!--            <path id="Path_32662" data-name="Path 32662" d="M270.814,272.355a2.267,2.267,0,0,0,1.489,2.1,2.232,2.232,0,0,0,2.433-.648,2.231,2.231,0,1,0-3.922-1.453.506.506,0,0,0,1.013,0c0-.041,0-.084.005-.124a.377.377,0,0,1,.005-.053c.008-.1,0,.033-.005.03a.981.981,0,0,1,.061-.248c.008-.02.023-.106.04-.111s-.046.094-.018.043a.656.656,0,0,0,.028-.061,2.3,2.3,0,0,1,.129-.215c.048-.073-.068.079.013-.015.025-.028.051-.058.078-.086s.056-.056.084-.081l.038-.033c.018-.015.091-.051.025-.023s-.015.013,0,0,.035-.025.056-.038a.96.96,0,0,1,.086-.051c.038-.023.078-.04.119-.061.013-.008.066-.033,0,0s.025-.008.033-.01a1.564,1.564,0,0,1,.213-.061l.068-.013c.056-.013-.048.005-.048.005.046,0,.094-.01.139-.01a2.031,2.031,0,0,1,.248.008c.094.008-.1-.018.02.005.046.008.089.02.134.03s.076.023.114.035a.583.583,0,0,1,.063.023c0,.008-.094-.048-.043-.018.071.043.149.076.22.122.018.013.035.025.056.038s.056.023,0,0-.018-.015,0,0l.051.043a2.257,2.257,0,0,1,.172.177c.076.084-.035-.058.013.015.02.033.043.063.063.1s.04.068.058.1l.023.046c.048.091.01-.008,0-.013.03.01.063.192.073.225l.023.1c.02.1,0-.03,0-.033.013.013.008.071.008.086a1.749,1.749,0,0,1,0,.23.622.622,0,0,0-.005.071c0,.051-.03.043.005-.03a.788.788,0,0,0-.028.134c-.018.071-.046.139-.066.21s.046-.086.013-.028a.249.249,0,0,0-.02.046c-.02.04-.041.078-.063.116s-.041.066-.063.1c-.068.1.048-.051-.01.018a1.929,1.929,0,0,1-.172.18c-.01.01-.071.076-.089.076,0,0,.1-.071.023-.02-.015.01-.028.018-.041.028-.071.046-.144.084-.218.122s.091-.03-.018.008l-.111.038-.116.03c-.018,0-.033.008-.051.01-.111.025.081-.005.015,0a2.039,2.039,0,0,1-.248.01c-.041,0-.081-.005-.124-.008-.015,0-.076-.008,0,0s-.018-.005-.035-.008a1.919,1.919,0,0,1-.261-.076c-.015-.005-.066-.03,0,0s-.015-.008-.03-.015c-.04-.02-.078-.04-.116-.063s-.073-.048-.111-.073c-.061-.038.008.02.023.02-.01,0-.043-.035-.051-.043a1.873,1.873,0,0,1-.187-.187.3.3,0,0,1-.043-.051c0,.01.061.086.02.023-.025-.038-.051-.073-.073-.111s-.048-.089-.071-.132c-.053-.1.025.081-.015-.033a1.84,1.84,0,0,1-.073-.263.164.164,0,0,0-.01-.051c.038.084.008.071,0,.013s-.008-.106-.008-.16a.513.513,0,0,0-1.026,0ZM287.2,258l-3.074,7.926H272.313L269.7,258Z" transform="translate(-230.437 -153.024)" fill="#fff"></path>-->

    <!--            <path id="Path_32663" data-name="Path 32663" d="M267.044,237.988q-.52,1.341-1.038,2.682-.828,2.138-1.654,4.274l-.38.983.489-.372H254.1c-.476,0-.957-.02-1.436,0h-.02l.489.372q-.444-1.348-.886-2.694-.7-2.131-1.4-4.264c-.109-.327-.215-.653-.324-.983l-.489.641h16.791c.228,0,.456.005.681,0h.03a.506.506,0,0,0,0-1.013H250.744c-.228,0-.456-.005-.681,0h-.03a.511.511,0,0,0-.489.641q.444,1.348.886,2.694.7,2.131,1.4,4.264c.109.327.215.653.324.983a.523.523,0,0,0,.489.372h10.359c.476,0,.957.018,1.436,0h.02a.526.526,0,0,0,.489-.372q.52-1.341,1.038-2.682.828-2.138,1.654-4.274l.38-.983a.508.508,0,0,0-.355-.623A.52.52,0,0,0,267.044,237.988Z" transform="translate(-210.769 -133.152)" fill="#fff"></path>-->

    <!--            </g>-->

    <!--        </svg>-->

    <!--    checkout-->

    <!--</div>-->

    @endif

<!--@endif-->

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

