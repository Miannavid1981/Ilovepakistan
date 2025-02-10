@extends('frontend.layouts.app')

@section('content')
    <style>
        #section_featured .slick-slider .slick-list{
            background: #fff;
        }
        #section_featured .slick-slider .slick-list .slick-slide,
        #section_best_selling .slick-slider .slick-list .slick-slide,
        #section_newest .slick-slider .slick-list .slick-slide {
            margin-bottom: -5px;
        }
        .hov-animate-outline:hover::before,
        .hov-animate-outline:hover::after {
            width: calc(100% - 2px);
        }
        @media (max-width: 575px){
            #section_featured .slick-slider .slick-list .slick-slide {
                margin-bottom: -4px;
            }
        }
        @media (min-width: 992px) {
            .aiz-count-down-box-div{
                position: absolute;
                top: 70%;
                left: 50%;
                -webkit-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }
        }
    </style>

    @php $lang = get_system_language()->code;  @endphp

    
<style>

/* General styles for all screens */
.cat_sidebar {
    width: 100%;
    background-color: #f7f7f7;
    padding: 10px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border-radius: 20px;
}

.cat_sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.cat_sidebar ul li {
  padding: 8px 30px;
  position: relative;
}

.cat_sidebar ul li a {
  text-decoration: none;
  color: #383838;
  display: flex;
  align-items: center;
  text-align: left;
  font-size: 17px;
  transition: color 0.3s ease;
}

.cat_sidebar ul li:hover {
  color: black;
  font-weight: 700;
  background-color: rgb(255, 255, 255);
}

.cat_sidebar ul li i {
  margin-right: 17px;
  justify-content: center;
  font-size: 15px;
  color: rgb(66, 66, 66);
  flex-direction: row;
  width: 20px;
}

.cat_sidebar h3 {
  font-size: 16px;
}

.cat_sidebar ul .submenu {
  display: none;
  position: absolute;
  background-color: #fff;
  box-shadow: 3px 0 3px 0 rgba(0, 0, 0, 0.1);
  right: 0;
  top: 0;
  border-radius: 15px;
  z-index: 9;
}

.cat_sidebar ul li:hover .submenu {
  display: block;
}


@media (max-width: 768px){
    .left-section {
        display: none !important
    }
}

.bighouz-business {
    display: grid;
    grid-template-columns: 1.7fr 1fr;
    gap: 25px;
}

/* For screens below 767px (Mobile View) */
@media (max-width: 767px) {
    .bighouz-business {
        grid-template-columns: 1fr; /* Stack the columns vertically */
        gap: 20px; /* Reduced space between items */
    }
}

/* Default (desktop) grid layout with 2 columns */
.category-grid {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Two columns by default */
    gap: 20px; /* Space between items */
    grid-template-rows: 1fr 1fr 1fr ;
    height: 100%;
}
@media (max-width: 1800px){
    .bighouz-business {
        grid-template-columns: 1.7fr 1fr;
        gap: 25px;
    }
}

@media (max-width: 768px){
    .bighouz-business {
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
}
/* Mobile (small screens) layout - 1 column per row *//* For screens below 767px (Mobile) */
@media (max-width: 767px) {
    .bighouz-business {
        grid-template-columns: 1fr;
    }
    .category-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .category-card {
        width: 100%; /* Ensure full-width category cards */
        margin-bottom: 0px; /* Add space between cards */
        min-height: 170px !important;
    }

    .category-card img {
        width: 100%; /* Make images take the full width */
        max-height: 150px; /* Ensure images have a max height */
        object-fit: contain; /* Keep aspect ratio */
    }
    .category-card p {
        font-size: 16px !important;
    }
}

/* For larger screens (1200px and up) */
@media (min-width: 1200px) {
    .category-card img {
        max-height: 200px;
        object-fit: contain;
    }
}

/* For screens between 992px and 1199px (Tablets and smaller laptops) */
@media (min-width: 992px) and (max-width: 1199px) {
    .category-card img {
        max-height: 180px;
        object-fit: contain;
    }
}

/* For screens between 768px and 991px (Small tablets) */
@media (min-width: 768px) and (max-width: 991px) {
    .category-card img {
        max-height: 150px;
        object-fit: contain;
    }
}

/* For screens between 576px and 767px (Mobile landscape) */
@media (min-width: 576px) and (max-width: 767px) {
    .category-card img {
        max-height: 120px;
        object-fit: contain;
    }
}

/* For screens 575px and below */
@media (max-width: 575px) {
    .category-card img {
        max-height: 100px;
        object-fit: contain;
    }
}





</style>

<div class="container py-4">

    <div class="bighouz-business">
                <!-- Left Section -->
        <div class="left-section d-flex flex-column h-100" 
            style="background-image: url({{ static_asset('assets/img/solarbg.png') }}); background-size: cover; background-position: center; background-color: #d3e7ff ; border-radius: 20px"
        >
            <!-- banner-home-page  -->
            <div class="banner " >
                    
                <h1>BigHouz Business</h1>
                <div class="d-flex gap-3">
                    <p><i class="fas fa-check-circle"></i> Tax exemptions</p>
                    <p><i class="fas fa-credit-card"></i> Express Payments</p>
                    <p><i class="fas fa-dollar-sign"></i> Financial Support</p>
                </div>
                
                <button class="btn btn-lg btn-dark">Shop now</button>


          
            </div>
    
        </div>

                <!-- Right Section -->
        <!-- Right Section -->
            <div class="right-section flex-column h-100">
                <div class="category-grid">
                @php

                $banner_categories = \App\Models\Category::where('level', 0)->limit(6)->get();
                @endphp

                    @foreach($banner_categories as $category)
        
                    <div class="category-card" style="background-image: url({{uploaded_asset($category->cover_image)}}); background-size:cover; aspect-ratio: 1 / 1;">
                        <p style="font-size: 20px; font-weight: 600;"> {{$category->name}}</p>
                        <!-- <img src="https://s.alicdn.com/@sc04/kf/H0c9193fb07984a3c8ee34970ef68472aP.png_300x300.png" alt="Home Improvement & Lighting"> -->
                    </div>
                    @endforeach

                    <!-- <div class="category-card" style="background: #eefac5;">
                        <p style="font-size: 20px; font-weight: 600;">Solar Panels</p>
                        <img src="https://file.aiquickdraw.com/imgcompressed/img/compressed_588b1d72a9a6e9550d13cd00c7de6fd5.webp" alt="Home Improvement & Lighting">
                    </div>

                    <div class="category-card" style="background: #ffd0d0;">
                        <p style="font-size: 20px; font-weight: 600;">Electric Tools</p>
                        <img src="https://png.pngtree.com/png-vector/20240626/ourmid/pngtree-electrician-tools-on-wooden-surface-instrument-manufacture-ohmmeter-png-image_12868398.png" alt="Home Improvement & Lighting">
                    </div>

                    <div class="category-card" style="background: #ffe39d;">
                        <p style="font-size: 20px; font-weight: 600;">Hardware & Tools</p>
                        <img src="https://www.solelyverified.in/wp-content/uploads/2024/11/Electrical-Supplies.png" alt="Home Improvement & Lighting">
                    </div>

                    <div class="category-card" style="background: #eae4ff;">
                        <p style="font-size: 20px; font-weight: 600;">Solar Batteries</p>
                        <img src="https://rameensolarenergy.com/wp-content/uploads/2023/10/veyron-1.2.png" alt="Home Improvement & Lighting">
                    </div>

                    <div class="category-card" style="background: #c1f2f9;">
                        <p style="font-size: 20px; font-weight: 600;">Renewable Energy</p>
                        <img src="https://cdn-icons-png.flaticon.com/512/1996/1996742.png" alt="Home Improvement & Lighting">
                    </div> -->
                </div>
            </div>

    </div>

    <!-- Category-end -->
</div>
<img src="{{ static_asset('/public/assets/img/mainbanner.jpg') }}" class="w-100 mt-2">


<!-- Category-start -->

<div class="container py-4  d-none">
    
    <!-- <h2 class="mb-4 category-h2">Shop by category</h2> -->
    <div class="" style="display: grid; grid-template-columns: 1fr 3.5fr;gap: 25px;">
        <div class="">


            <div class="cat_sidebar">
                <h3 class="mt-3 fs-18" style="padding-left: 30px;">
                    
                    <i class="fa-solid fa-bars " style="margin-right: 20px"></i></i> All Categories</a></li>
                
                </h3>
                
                <ul>
                <li>
                    <a href="#"><i class="fa-regular fa-clock"></i> Accessories</a>
                    <ul class="submenu">
                    <li><a href="#">Watches</a></li>
                    <li><a href="#">Hats</a></li>
                    <li><a href="#">Belts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-regular fa-gem"></i> Jewelry & Watches</a>
                    <ul class="submenu">
                    <li><a href="#">Necklaces</a></li>
                    <li><a href="#">Bracelets</a></li>
                    <li><a href="#">Earrings</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-house-user"></i> Home & Garden</a>
                    <ul class="submenu">
                    <li><a href="#">Furniture</a></li>
                    <li><a href="#">Kitchen</a></li>
                    <li><a href="#">Decor</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-bath"></i> Hair Extensions & Wigs</a>
                    <ul class="submenu">
                    <li><a href="#">Synthetic Wigs</a></li>
                    <li><a href="#">Human Hair Wigs</a></li>
                    <li><a href="#">Hair Care</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-shirt"></i> Men's Clothing</a>
                    <ul class="submenu">
                    <li><a href="#">Shirts</a></li>
                    <li><a href="#">Trousers</a></li>
                    <li><a href="#">Suits</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-laptop-medical"></i> Consumer Electronics</a>
                    <ul class="submenu">
                    <li><a href="#">Mobile Phones</a></li>
                    <li><a href="#">Laptops</a></li>
                    <li><a href="#">Cameras</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-regular fa-lightbulb"></i> Home Improvement & Lighting</a>
                    <ul class="submenu">
                    <li><a href="#">Lighting Fixtures</a></li>
                    <li><a href="#">Tools</a></li>
                    <li><a href="#">Plumbing</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-blender-phone"></i> Home Appliances</a>
                    <ul class="submenu">
                    <li><a href="#">Refrigerators</a></li>
                    <li><a href="#">Microwaves</a></li>
                    <li><a href="#">Washers</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-motorcycle"></i> Automotive & Motorcycle</a>
                    <ul class="submenu">
                    <li><a href="#">Car Accessories</a></li>
                    <li><a href="#">Motorcycle Parts</a></li>
                    <li><a href="#">Tires</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-bag-shopping"></i> Luggages & Bags</a>
                    <ul class="submenu">
                    <li><a href="#">Suitcases</a></li>
                    <li><a href="#">Backpacks</a></li>
                    <li><a href="#">Travel Bags</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-shoe-prints"></i> Shoes</a>
                    <ul class="submenu">
                    <li><a href="#">Sneakers</a></li>
                    <li><a href="#">Formal Shoes</a></li>
                    <li><a href="#">Boots</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-person-military-pointing"></i> Special Occasion Costume</a>
                    <ul class="submenu">
                    <li><a href="#">Halloween Costumes</a></li>
                    <li><a href="#">Party Costumes</a></li>
                    <li><a href="#">Themed Outfits</a></li>
                    </ul>
                </li>
                </ul>
                
                
            </div>

        </div>    
        <div class="">

          
        

        </div>
    </div>
    
        
    
</div>






    <!-- Featured Categories -->
    @if (count($featured_categories) > 0)
        <section class="mb-3 mb-md-4 pt-3 pt-md-2rem d-none">
            <div class="container">
                <!-- Categories -->
                <div class="bg-white px-sm-3">
                    <div class="aiz-carousel sm-gutters-17" data-items="8" data-xxl-items="8" data-xl-items="8"
                        data-lg-items="6" data-md-items="5" data-sm-items="3" data-xs-items="2" data-arrows="true"
                        data-dots="false" data-autoplay="false" data-infinite="true" data-center="false">
                        @foreach ($featured_categories as $key => $category)
                            @php
                                $category_name = $category->getTranslation('name');
                            @endphp
                            <div class="carousel-box px-4 d-flex flex-column align-items-center">
                                <div class="size-80px overflow-hidden hov-scale-img">
                                    <a class="d-block" href="{{ route('products.category', $category->slug) }}">
                                        <img src="{{ isset($category->bannerImage->file_name) ? my_asset($category->bannerImage->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                            class="lazyload img-fit h-100 mx-auto has-transition"
                                            alt="{{ $category->getTranslation('name') }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    </a>
                                </div>
                                <div class="text-center h-35px text-truncate-2" style="margin-top: 12px;">
                                    <a class="fs-13 fw-500 text-center text-reset hov-text-primary"
                                        href="{{ route('products.category', $category->slug) }}"
                                        style="width: max-content;">
                                        {{ $category_name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Sliders -->
    <div class="home-banner-area mb-3" style="background-color: {{ get_setting('slider_section_bg_color', '#dedede') }}">
        <div class="@if(get_setting('slider_section_full_width') == 1) p-0 @else container @endif">
            <!-- Sliders -->
            <div class="home-slider slider-full">
                @if (get_setting('home_slider_images', null, $lang) != null)
                    <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-autoplay="true" data-infinite="true">
                        @php
                            $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
                            $sliders = get_slider_images($decoded_slider_images);
                            $home_slider_links = get_setting('home_slider_links', null, $lang);
                        @endphp
                        @foreach ($sliders as $key => $slider)
                            <div class="carousel-box">
                                <a href="{{ isset(json_decode($home_slider_links, true)[$key]) ? json_decode($home_slider_links, true)[$key] : '' }}">
                                    <!-- Image -->
                                    <div class="d-block mw-100 img-fit overflow-hidden h-180px h-sm-200px h-md-250px h-lg-300px h-xl-370px overflow-hidden">
                                        <img class="img-fit h-100 m-auto has-transition ls-is-cached lazyloaded"
                                        src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                        alt="{{ env('APP_NAME') }} promo"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
   

    <!-- Flash Deal -->
    @php
        $flash_deal = get_featured_flash_deal();
        $flash_deal_bg = get_setting('flash_deal_bg_color');
        $flash_deal_bg_full_width = (get_setting('flash_deal_bg_full_width') == 1) ? true : false;
        $flash_deal_banner_menu_text = ((get_setting('flash_deal_banner_menu_text') == 'dark') ||  (get_setting('flash_deal_banner_menu_text') == null)) ? 'text-dark' : 'text-white';

    @endphp
    @if ($flash_deal != null)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3" style="background: {{ ($flash_deal_bg_full_width && $flash_deal_bg != null) ? $flash_deal_bg : '' }};" id="flash_deal">
            <div class="container">
                <div class="@if(!$flash_deal_bg_full_width) px-3 px-md-2rem @endif pb-3 pb-md-4" style="background: {{ $flash_deal_bg != null ? $flash_deal_bg : '#faf9f7' }};">
                    <!-- Top Section -->
                    <div class="d-flex flex-wrap align-items-baseline justify-content-center justify-content-sm-between mb-2 mb-md-3 pt-2 pt-md-3 position-relative">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="d-inline-block {{ $flash_deal_banner_menu_text }}">{{ translate('Flash Sale') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="24" viewBox="0 0 16 24"
                                class="ml-3">
                                <path id="Path_28795" data-name="Path 28795"
                                    d="M30.953,13.695a.474.474,0,0,0-.424-.25h-4.9l3.917-7.81a.423.423,0,0,0-.028-.428.477.477,0,0,0-.4-.207H21.588a.473.473,0,0,0-.429.263L15.041,18.151a.423.423,0,0,0,.034.423.478.478,0,0,0,.4.2h4.593l-2.229,9.683a.438.438,0,0,0,.259.5.489.489,0,0,0,.571-.127L30.9,14.164a.425.425,0,0,0,.054-.469Z"
                                    transform="translate(-15 -5)" fill="#fcc201" />
                            </svg>
                        </h3>
                        <!-- Countdown -->
                        <div class="aiz-count-down-box-div">
                            <div class="aiz-count-down-box align-items-center mb-2 mb-lg-0" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                        </div>
                        <!-- Links -->
                        <div>
                            <div class="text-dark d-flex align-items-center mb-0">
                                <a href="{{ route('flash-deals') }}"
                                    class="fs-10 fs-md-12 fw-700 has-transition @if ((get_setting('flash_deal_banner_menu_text') == 'light') && $flash_deal_bg_full_width && $flash_deal_bg != null) text-white opacity-60 hov-opacity-100 animate-underline-white @else text-reset opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary @endif mr-3">{{ translate('View All Flash Sale') }}</a>
                                <span class=" border-left border-soft-light border-width-2 pl-3">
                                    <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                                        class="fs-10 fs-md-12 fw-700 has-transition @if ((get_setting('flash_deal_banner_menu_text') == 'light') && $flash_deal_bg_full_width && $flash_deal_bg != null) == 'light') text-white opacity-60 hov-opacity-100 animate-underline-white @else text-reset opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary @endif">{{ translate('View All Products from This Flash Sale') }}</a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row no-gutters align-items-center border" style="background: {{ $flash_deal_bg }};">
                        <!-- Flash Deals Baner -->
                        <div class="col-xxl-2 col-md-3 col-sm-4 col-5 h-150px h-md-200px h-lg-240px">
                            <a href="{{ route('flash-deal-details', $flash_deal->slug) }}">
                                <div class="h-100 w-100 w-xl-auto"
                                    style="background-image: url('{{ uploaded_asset($flash_deal->banner) }}'); background-size: cover; background-position: center center;">
                                </div>
                            </a>
                        </div>

                        <div class="col-xxl-10 col-md-9 col-sm-8 col-7">
                            <!-- Flash Deals Products -->
                            @php
                                $flash_deal_products = get_flash_deal_products($flash_deal->id);
                            @endphp
                            <div class="aiz-carousel arrow-inactive-none arrow-x-0"
                                data-items="6" data-xxl-items="6" data-xl-items="5" data-lg-items="3.7" data-md-items="3"
                                data-sm-items="2.7" data-xs-items="1.5" data-arrows="true" data-dots="false">
                                @foreach ($flash_deal_products as $key => $flash_deal_product)
                                    <div class="carousel-box bg-white">
                                        @if ($flash_deal_product->product != null && $flash_deal_product->product->published != 0)
                                            @php
                                                $product_url = route('product', $flash_deal_product->product->slug);
                                                if ($flash_deal_product->product->auction_product == 1) {
                                                    $product_url = route('auction-product', $flash_deal_product->product->slug);
                                                }
                                            @endphp
                                            <div
                                                class="h-150px h-md-200px h-lg-240px flash-deal-item position-relative text-center has-transition hov-shadow-out z-1">
                                                <a href="{{ $product_url }}"
                                                    class="d-block py-md-2 overflow-hidden hov-scale-img"
                                                    title="{{ $flash_deal_product->product->getTranslation('name') }}">
                                                    <!-- Image -->
                                                    <img src="{{ get_image($flash_deal_product->product->thumbnail) }}"
                                                        class="lazyload h-100px h-md-120px h-lg-140px mw-100 mx-auto has-transition"
                                                        alt="{{ $flash_deal_product->product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                    <!-- Price -->
                                                    <div
                                                        class="fs-10 fs-md-14 mt-2 text-center h-md-48px has-transition overflow-hidden pt-md-4 flash-deal-price lh-1-5">
                                                        <span
                                                            class="d-block text-primary fw-700">{{ home_discounted_base_price($flash_deal_product->product) }}</span>
                                                        @if (home_base_price($flash_deal_product->product) != home_discounted_base_price($flash_deal_product->product))
                                                            <del
                                                                class="d-block fw-400 text-secondary">{{ home_base_price($flash_deal_product->product) }}</del>
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

<style>
    .home_categories_grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
        gap: 10px;
        margin-bottom: 50px;
        margin-top: 30px
    }
    </style>
    <div class="container">
        <h4 class="text-center">Explore Categories</h4>
        <div class="home_categories_grid">
            @php
                // Fetch categories with level = 0 and status = 1 directly in the view
                $categories = \App\Models\Category::where('level', 0)->get();
            @endphp
                @foreach ($categories as $category )
                   
                        <a href="{{ route('products.category', $category->slug) }}" class="d-flex flex-column align-items-center justify-content-center">
                            <img src="{{uploaded_asset($category->icon)}}" class="me-2 p-1 rounded-circle border-1 border" style="width: 65px;height: auto;aspect-ratio: 1 / 1;" >
                            <p class="mt-2">   {{$category->name}}</p>
                        </a>
                   
                @endforeach

           
        </div>


    </div>


    @include('frontend/megamart/partials/toggle_tabs');
    
    <!-- Today's deal -->
    @php
        $todays_deal_section_bg = get_setting('todays_deal_section_bg_color');

    @endphp
    <div id="todays_deal" @if(get_setting('todays_deal_section_bg') == 1) style="background: {{ $todays_deal_section_bg }};" @endif>

    </div>


    <!-- Banner section 2 -->
    @php $homeBanner2Images = get_setting('home_banner2_images', null, $lang);   @endphp
    @if ($homeBanner2Images != null)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                @php
                    $banner_2_imags = json_decode($homeBanner2Images);
                    $data_md = count($banner_2_imags) >= 2 ? 2 : 1;
                    $home_banner2_links = get_setting('home_banner2_links', null, $lang);
                @endphp
                <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                    data-items="{{ count($banner_2_imags) }}" data-xxl-items="{{ count($banner_2_imags) }}"
                    data-xl-items="{{ count($banner_2_imags) }}" data-lg-items="{{ $data_md }}"
                    data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                    data-dots="false">
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="carousel-box overflow-hidden hov-scale-img">
                            <a href="{{ isset(json_decode($home_banner2_links, true)[$key]) ? json_decode($home_banner2_links, true)[$key] : '' }}"
                                class="d-block text-reset overflow-hidden">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                    class="img-fluid lazyload w-100 has-transition"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Best Selling, New Products, Banner section 2 -->
    @php
        $homeBanner3Images = get_setting('home_banner3_images', null, $lang);
        $col_val = 6;
        if ($homeBanner3Images != null){
            $col_val = 4;
        }
    @endphp

    <style>
         .skeleton_grid{
            display: grid;
            width: 100%;
            grid-template-columns:  1fr 1fr 1fr 1fr 1fr;
            gap: 20px; margin: 0 15px
        }
          .skeleton {
            background: #dedede;
            background-size: 200% 100%;
            animation: pulse 1.5s infinite ease-in-out;
        }
        .skeleton.image {
            width: 100%;
            border-radius: 10px;
            aspect-ratio: 1 / 1.3;
        }
        .skeleton.text {
    height: 18px;
    margin: 10px 0;
    border-radius: 10px;
}
        .skeleton.text.short {
            width: 50%;
        }
        .skeleton.text.medium {
            width: 80%;
        }
        .skeleton.text.long {
            width: 100%;
        }
        .skeleton.stars {
            width: 70%;
            height: 20px;
            border-radius: 5px;
        }
        @keyframes pulse {
      0% {
        opacity: 1;
      }
      50% {
        opacity: 0.4;
      }
      100% {
        opacity: 1;
      }
    }
        </style>

    <div class="container ">
        
        <div class="row ">
            <div class="col-12">

            </div>
            <div class="col-xl-{{ $col_val }} mb-2 mb-md-3 mt-2 mt-md-3">
                <!-- Best Selling  -->
                <div id="section_best_selling" class="d-none">

                </div>
            </div>

            <div class="col-xl-{{ $col_val }} mb-2 mb-md-3 mt-2 mt-md-3">
                <!-- New Products -->
               
            </div>

            <!-- Banner section 3 -->
            @if ($homeBanner3Images != null)
                <div class="col-xl-4 mb-2 mb-md-3 mt-2 mt-md-3 d-none d-xl-block">
                    @php
                        $banner_3_imags = json_decode($homeBanner3Images);
                        $home_banner3_links = get_setting('home_banner3_links', null, $lang);
                    @endphp
                    <div class="aiz-carousel overflow-hidden arrow-inactive-none arrow-dark arrow-x-0"
                        data-items="1" data-arrows="true" data-dots="false" data-autoplay="true">
                        @foreach ($banner_3_imags as $key => $value)
                            <div class="carousel-box overflow-hidden hov-scale-img">
                                <a href="{{ isset(json_decode($home_banner3_links, true)[$key]) ? json_decode($home_banner3_links, true)[$key] : '' }}"
                                    class="d-block text-reset overflow-hidden" style="height: 685px;">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                        class="img-fit h-100 lazyload has-transition"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
                
    </div>
        
<div class="mx-5">
<div class="container-fluid py-5">
  <div class="row text-center d-flex align-items-end">
    <!-- First Feature -->
    <div class="col-md-3">
      <div>
      <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor" class="bi bi-telephone-outbound" viewBox="0 0 16 16">
  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1H11.5a.5.5 0 0 1-.5-.5"/>
</svg>
      </div>
      <h5 class="mt-3">24/7 Customer Service</h5>
      <p class="text-muted">We're here to help you with any questions or concerns you have, 24/7.</p>
    </div>

    <!-- Second Feature -->
    <div class="col-md-3">
      <div>
      <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor" class="bi bi-box2" viewBox="0 0 16 16">
  <path d="M2.95.4a1 1 0 0 1 .8-.4h8.5a1 1 0 0 1 .8.4l2.85 3.8a.5.5 0 0 1 .1.3V15a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4.5a.5.5 0 0 1 .1-.3zM7.5 1H3.75L1.5 4h6zm1 0v3h6l-2.25-3zM15 5H1v10h14z"/>
</svg>
      </div>
      <h5 class="mt-3">14-Day Money Back</h5>
      <p class="text-muted">If you're not satisfied with your purchase, simply return it within 14 days for a refund.</p>
    </div>

    <!-- Third Feature -->
    <div class="col-md-3">
      <div>
      <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor" class="bi bi-patch-check" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
  <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z"/>
</svg>
      </div>
      <h5 class="mt-3">Our Guarantee</h5>
      <p class="text-muted">We stand behind our products and services and guarantee your satisfaction.</p>
    </div>

    <!-- Fourth Feature -->
    <div class="col-md-3">
      <div>
      <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
</svg>
      </div>
      <h5 class="mt-3">Shipping Worldwide</h5>
      <p class="text-muted">We ship our products worldwide, making them accessible to customers everywhere.</p>
    </div>
  </div>
</div>
</div>

    <!-- Banner section 4, Top Sellers -->
    @if (get_setting('vendor_system_activation') == 1)
        @php
            $best_selers = get_best_sellers(10);
            $homeBanner4Images = get_setting('home_banner4_images', null, $lang);
            $data_rows = 1;
            $xxl_items = 5;
            $xl_items = 4;
            $lg_items = 3.4;
            $md_items = 2.5;
            if ($homeBanner4Images != null){
                $data_rows = 2;
                $xxl_items = 2;
                $xl_items = 2;
                $lg_items = 2;
                $md_items = 3;
            }
        @endphp
        @if (count($best_selers) > 0)
        <section class="">
            <div class="container">
                <div class="row">
                    <!-- Banner section 4 -->
                    @if ($homeBanner4Images != null)
                        <div class="col-xl-8 col-lg-6 mb-2 mb-md-3 mt-2 mt-md-3 d-none d-lg-block">
                            @php
                                $banner_4_imags = json_decode($homeBanner4Images);
                                $home_banner4_links = get_setting('home_banner4_links', null, $lang);
                            @endphp
                            <div class="aiz-carousel overflow-hidden arrow-inactive-none arrow-dark arrow-x-0"
                                data-items="1" data-arrows="true" data-dots="false" data-autoplay="true">
                                @foreach ($banner_4_imags as $key => $value)
                                    <div class="carousel-box overflow-hidden hov-scale-img">
                                        <a href="{{ isset(json_decode($home_banner4_links, true)[$key]) ? json_decode($home_banner4_links, true)[$key] : '' }}"
                                            class="d-block text-reset overflow-hidden" style="height: 650px;">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                                class="img-fit h-100 lazyload has-transition"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Top Sellers -->
                    <div class="col mb-2 mb-md-3 mt-2 mt-md-3">
                        <div class="h-100 d-none" id="section_top_sellers">
                            <div class="border px-3 py-2rem">
                                <!-- Top Section -->
                                <div class="d-flex mb-3 mb-md-4 align-items-baseline justify-content-between">
                                    <!-- Title -->
                                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                    </h3>
                                    <!-- Links -->
                                    <div class="d-flex">
                                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                    </div>
                                </div>
                                <!-- Sellers Section -->
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-rows="{{ $data_rows }}" data-items="{{ $xxl_items }}" data-xxl-items="{{ $xxl_items }}"
                                    data-xl-items="{{ $xl_items }}" data-lg-items="{{ $lg_items }}" data-md-items="{{ $md_items }}" data-sm-items="2" data-xs-items="1.4"
                                    data-arrows="true" data-dots="false">
                                    @foreach ($best_selers as $key => $seller)
                                        @if ($seller->user != null)
                                            <div
                                                class="carousel-box h-100 position-relative text-center has-transition hov-animate-outline">
                                                <div class="position-relative px-3 px-xl-2 py-3">
                                                    <!-- Shop logo & Verification Status -->
                                                    <div class="mx-auto size-100px">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="d-flex mx-auto justify-content-center align-item-center size-100px border overflow-hidden hov-scale-img"
                                                            tabindex="0"
                                                            style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($seller->logo) }}" alt="{{ $seller->name }}"
                                                                class="img-fit lazyload has-transition"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                        </a>
                                                    </div>
                                                    <!-- Shop name -->
                                                    <h2 class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="text-reset hov-text-primary" tabindex="0">{{ $seller->name }}</a>
                                                    </h2>
                                                    <!-- Shop Rating -->
                                                    <div class="rating rating-mr-2 text-dark mb-3">
                                                        {{ renderStarRating($seller->rating) }} <br>
                                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                                            {{ translate('Reviews') }})</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        @endif
    @endif

    <!-- Top Brands, Banner section 5, Banner section 6 -->
    @if (get_setting('top_brands') != null)
        @php
            $top_brands = json_decode(get_setting('top_brands'));
            $brands = get_brands($top_brands);
            $homeBanner5Images = get_setting('home_banner5_images', null, $lang);
            $homeBanner6Images = get_setting('home_banner6_images', null, $lang);
            $col_val = 'col-xl-4';
            $data_rows = 3;
            $xxl_items = 2;
            $xl_items = 2;
            $lg_items = 4;
            $md_items = 3;
            $sm_items = 2;
            $xs_items = 1.4;
            if ($homeBanner5Images == null && $homeBanner6Images == null){
                $data_rows = 2;
                $xxl_items = 6;
                $xl_items = 5;
            } elseif ($homeBanner5Images == null || $homeBanner6Images == null) {
                $col_val = 'col-xxl-8 col-xl-6';
                $data_rows = 3;
                $xxl_items = 2;
                $xl_items = 3;
            }
        @endphp
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                <div class="row">

                    <!-- Top Brands -->
                    <div class="col py-3 py-lg-0">
                        <div class="h-100" id="section_top_brands">
                            <div class="border px-3 pt-3">
                                <!-- Top Section -->
                                <div class="d-flex mb-3 mb-md-4 align-items-baseline justify-content-between">
                                    <!-- Title -->
                                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                        <span class="pb-3">{{ translate('Top Brands') }}</span>
                                    </h3>
                                    <!-- Links -->
                                    <div class="d-flex">
                                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                            href="{{ route('brands.all') }}">{{ translate('View All Brands') }}</a>
                                    </div>
                                </div>
                                <!-- Brands Section -->
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none py-4" data-rows="{{ $data_rows }}" data-items="{{ $xxl_items }}" data-xxl-items="{{ $xxl_items }}"
                                    data-xl-items="{{ $xl_items }}" data-lg-items="{{ $lg_items }}" data-md-items="{{ $md_items }}" data-sm-items="{{ $sm_items }}" data-xs-items="{{ $xs_items }}"
                                    data-arrows="true" data-dots="false">
                                    @foreach ($brands as $brand)
                                        <div class="carousel-box position-relative text-center hov-scale-img has-transition hov-shadow-out z-1">
                                            <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-sm-2">
                                                <img src="{{ $brand->logo != null ? uploaded_asset($brand->logo) : static_asset('assets/img/placeholder.jpg') }}"
                                                    class="lazyload h-100px h-md-110px mx-auto has-transition p-2 p-sm-4"
                                                    alt="{{ $brand->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                <p class="text-center text-dark fs-12 fs-md-14 fw-700 mt-2 mb-2 text-truncate" title="{{ $brand->getTranslation('name') }}">
                                                    {{ $brand->getTranslation('name') }}
                                                </p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Banner section 5 -->
                    @if ($homeBanner5Images != null)
                        @php
                            $banner_5_imags = json_decode($homeBanner5Images);
                            $home_banner5_links = get_setting('home_banner5_links', null, $lang);
                        @endphp
                        <div class="{{ $col_val }} d-none d-xl-block">
                            <div class="aiz-carousel overflow-hidden arrow-inactive-none arrow-dark arrow-x-0"
                                data-items="1" data-arrows="true" data-dots="false" data-autoplay="true">
                                @foreach ($banner_5_imags as $key => $value)
                                    <div class="carousel-box overflow-hidden hov-scale-img">
                                        <a href="{{ isset(json_decode($home_banner5_links, true)[$key]) ? json_decode($home_banner5_links, true)[$key] : '' }}"
                                            class="d-block text-reset overflow-hidden" style="height: 605px;">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                                class="img-fit h-100 lazyload has-transition"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Banner section 6 -->
                    @if ($homeBanner6Images != null)
                        @php
                            $banner_6_imags = json_decode($homeBanner6Images);
                            $home_banner6_links = get_setting('home_banner6_links', null, $lang);
                        @endphp
                        <div class="{{ $col_val }} d-none d-xl-block"><div class="aiz-carousel overflow-hidden arrow-inactive-none arrow-dark arrow-x-0"
                            data-items="1" data-arrows="true" data-dots="false" data-autoplay="true">
                                @foreach ($banner_6_imags as $key => $value)
                                    <div class="carousel-box overflow-hidden hov-scale-img">
                                        <a href="{{ isset(json_decode($home_banner6_links, true)[$key]) ? json_decode($home_banner6_links, true)[$key] : '' }}"
                                            class="d-block text-reset overflow-hidden" style="height: 605px;">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                                class="img-fit h-100 lazyload has-transition"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endif

    <!-- Auction Product -->
    @if (addon_is_activated('auction'))
        <div id="auction_products">

        </div>
    @endif

    <!-- Cupon -->
    @if (get_setting('coupon_system') == 1)
        <div class="mt-2 mt-md-3 mb-2 mb-md-3">
            <div class="container">
                <div class="position-relative py-5 px-3 px-sm-4 px-lg-5" style="background-color: {{ get_setting('cupon_background_color', '#292933') }}">
                    <div class="text-center text-xl-left position-relative z-5">
                        <div class="d-lg-flex justify-content-lg-between">
                            <div class="order-lg-1 mb-3 mb-lg-0">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="206.12" height="175.997" viewBox="0 0 206.12 175.997">
                                    <defs>
                                      <clipPath id="clip-path">
                                        <path id="Union_10" data-name="Union 10" d="M-.008,77.361l142.979-.327-22.578.051.176-77.132L143.148-.1l-.177,77.132-.064,28.218L-.072,105.58Z" transform="translate(0 0)" fill="none" stroke="#000" stroke-width="2"/>
                                      </clipPath>
                                    </defs>
                                    <g id="Group_24326" data-name="Group 24326" transform="translate(-274.202 -5254.612)" opacity="0.5">
                                      <g id="Mask_Group_23" data-name="Mask Group 23" transform="translate(304.445 5355.902) rotate(-45)" clip-path="url(#clip-path)">
                                        <g id="Group_24322" data-name="Group 24322" transform="translate(7.681 5.856)">
                                          <g id="Subtraction_167" data-name="Subtraction 167" transform="translate(0 0)" fill="none">
                                            <path d="M127.451,90.3H8a8.009,8.009,0,0,1-8-8V60.2a14.953,14.953,0,0,0,10.642-4.408A14.951,14.951,0,0,0,15.05,45.15a14.953,14.953,0,0,0-4.408-10.643A14.951,14.951,0,0,0,0,30.1V8A8.009,8.009,0,0,1,8,0H127.451a8.009,8.009,0,0,1,8,8V29.79a15.05,15.05,0,1,0,0,30.1V82.3A8.009,8.009,0,0,1,127.451,90.3Z" stroke="none"/>
                                            <path d="M 127.450813293457 88.30060577392578 C 130.75927734375 88.30060577392578 133.4509124755859 85.60896301269531 133.4509124755859 82.30050659179688 L 133.4508972167969 61.77521514892578 C 129.6533966064453 61.33430480957031 126.1383361816406 59.64068222045898 123.394172668457 56.89652252197266 C 120.1737594604492 53.67610168457031 118.4001998901367 49.39426422119141 118.4001998901367 44.83980178833008 C 118.4001998901367 40.28572463989258 120.1737747192383 36.0041618347168 123.3942184448242 32.78384399414062 C 126.1376495361328 30.04052734375 129.6527099609375 28.34706115722656 133.4509124755859 27.9056282043457 L 133.4509124755859 8.000102996826172 C 133.4509124755859 4.691642761230469 130.75927734375 2.000002861022949 127.450813293457 2.000002861022949 L 8.000096321105957 2.000002861022949 C 4.691636085510254 2.000002861022949 1.999996185302734 4.691642761230469 1.999996185302734 8.000102996826172 L 1.999996185302734 28.21491050720215 C 5.797210216522217 28.65582466125488 9.31190013885498 30.34944725036621 12.05595588684082 33.09362411499023 C 15.27627658843994 36.31408309936523 17.04979705810547 40.59588241577148 17.04979705810547 45.15030288696289 C 17.04979705810547 49.70434188842773 15.27627658843994 53.98588180541992 12.05591583251953 57.20624160766602 C 9.312583923339844 59.94955825805664 5.797909259796143 61.64302062988281 1.999996185302734 62.08445739746094 L 1.999996185302734 82.30050659179688 C 1.999996185302734 85.60896301269531 4.691636085510254 88.30060577392578 8.000096321105957 88.30060577392578 L 127.450813293457 88.30060577392578 M 127.450813293457 90.30060577392578 L 8.000096321105957 90.30060577392578 C 3.588836193084717 90.30060577392578 -3.762207143154228e-06 86.71176147460938 -3.762207143154228e-06 82.30050659179688 L -3.762207143154228e-06 60.20010375976562 C 4.022176265716553 60.19910430908203 7.799756050109863 58.63396453857422 10.64171600341797 55.79202270507812 C 13.48431587219238 52.94942474365234 15.04979610443115 49.17012405395508 15.04979610443115 45.15030288696289 C 15.04979610443115 41.13010406494141 13.48431587219238 37.35052108764648 10.64171600341797 34.5078010559082 C 7.799176216125488 31.66514205932617 4.019876003265381 30.0996036529541 -3.762207143154228e-06 30.0996036529541 L -3.762207143154228e-06 8.000102996826172 C -3.762207143154228e-06 3.588842868804932 3.588836193084717 2.886962874981691e-06 8.000096321105957 2.886962874981691e-06 L 127.450813293457 2.886962874981691e-06 C 131.8620758056641 2.886962874981691e-06 135.4509124755859 3.588842868804932 135.4509124755859 8.000102996826172 L 135.4509124755859 29.79000282287598 C 131.4283294677734 29.79100227355957 127.6504745483398 31.35614204406738 124.8083953857422 34.19808197021484 C 121.9657363891602 37.04064178466797 120.4001998901367 40.81994247436523 120.4001998901367 44.83980178833008 C 120.4001998901367 48.86006164550781 121.9657363891602 52.63964462280273 124.8083953857422 55.48230361938477 C 127.6510543823242 58.3249626159668 131.4306488037109 59.8905029296875 135.4508972167969 59.8905029296875 L 135.4509124755859 82.30050659179688 C 135.4509124755859 86.71176147460938 131.8620758056641 90.30060577392578 127.450813293457 90.30060577392578 Z" stroke="none" fill="#000"/>
                                          </g>
                                        </g>
                                      </g>
                                      <g id="Group_24321" data-name="Group 24321" transform="translate(274.202 5357.276) rotate(-45)">
                                        <g id="Subtraction_167-2" data-name="Subtraction 167" transform="translate(0 0)" fill="none">
                                          <path d="M127.451,90.3H8a8.009,8.009,0,0,1-8-8V60.2a14.953,14.953,0,0,0,10.642-4.408A14.951,14.951,0,0,0,15.05,45.15a14.953,14.953,0,0,0-4.408-10.643A14.951,14.951,0,0,0,0,30.1V8A8.009,8.009,0,0,1,8,0H127.451a8.009,8.009,0,0,1,8,8V29.79a15.05,15.05,0,1,0,0,30.1V82.3A8.009,8.009,0,0,1,127.451,90.3Z" stroke="none"/>
                                          <path d="M 127.450813293457 88.30060577392578 C 130.75927734375 88.30060577392578 133.4509124755859 85.60896301269531 133.4509124755859 82.30050659179688 L 133.4508972167969 61.77521514892578 C 129.6533966064453 61.33430480957031 126.1383361816406 59.64068222045898 123.394172668457 56.89652252197266 C 120.1737594604492 53.67610168457031 118.4001998901367 49.39426422119141 118.4001998901367 44.83980178833008 C 118.4001998901367 40.28572463989258 120.1737747192383 36.0041618347168 123.3942184448242 32.78384399414062 C 126.1376495361328 30.04052734375 129.6527099609375 28.34706115722656 133.4509124755859 27.9056282043457 L 133.4509124755859 8.000102996826172 C 133.4509124755859 4.691642761230469 130.75927734375 2.000002861022949 127.450813293457 2.000002861022949 L 8.000096321105957 2.000002861022949 C 4.691636085510254 2.000002861022949 1.999996185302734 4.691642761230469 1.999996185302734 8.000102996826172 L 1.999996185302734 28.21491050720215 C 5.797210216522217 28.65582466125488 9.31190013885498 30.34944725036621 12.05595588684082 33.09362411499023 C 15.27627658843994 36.31408309936523 17.04979705810547 40.59588241577148 17.04979705810547 45.15030288696289 C 17.04979705810547 49.70434188842773 15.27627658843994 53.98588180541992 12.05591583251953 57.20624160766602 C 9.312583923339844 59.94955825805664 5.797909259796143 61.64302062988281 1.999996185302734 62.08445739746094 L 1.999996185302734 82.30050659179688 C 1.999996185302734 85.60896301269531 4.691636085510254 88.30060577392578 8.000096321105957 88.30060577392578 L 127.450813293457 88.30060577392578 M 127.450813293457 90.30060577392578 L 8.000096321105957 90.30060577392578 C 3.588836193084717 90.30060577392578 -3.762207143154228e-06 86.71176147460938 -3.762207143154228e-06 82.30050659179688 L -3.762207143154228e-06 60.20010375976562 C 4.022176265716553 60.19910430908203 7.799756050109863 58.63396453857422 10.64171600341797 55.79202270507812 C 13.48431587219238 52.94942474365234 15.04979610443115 49.17012405395508 15.04979610443115 45.15030288696289 C 15.04979610443115 41.13010406494141 13.48431587219238 37.35052108764648 10.64171600341797 34.5078010559082 C 7.799176216125488 31.66514205932617 4.019876003265381 30.0996036529541 -3.762207143154228e-06 30.0996036529541 L -3.762207143154228e-06 8.000102996826172 C -3.762207143154228e-06 3.588842868804932 3.588836193084717 2.886962874981691e-06 8.000096321105957 2.886962874981691e-06 L 127.450813293457 2.886962874981691e-06 C 131.8620758056641 2.886962874981691e-06 135.4509124755859 3.588842868804932 135.4509124755859 8.000102996826172 L 135.4509124755859 29.79000282287598 C 131.4283294677734 29.79100227355957 127.6504745483398 31.35614204406738 124.8083953857422 34.19808197021484 C 121.9657363891602 37.04064178466797 120.4001998901367 40.81994247436523 120.4001998901367 44.83980178833008 C 120.4001998901367 48.86006164550781 121.9657363891602 52.63964462280273 124.8083953857422 55.48230361938477 C 127.6510543823242 58.3249626159668 131.4306488037109 59.8905029296875 135.4508972167969 59.8905029296875 L 135.4509124755859 82.30050659179688 C 135.4509124755859 86.71176147460938 131.8620758056641 90.30060577392578 127.450813293457 90.30060577392578 Z" stroke="none" fill="#000"/>
                                        </g>
                                        <g id="Group_24325" data-name="Group 24325" transform="translate(26.233 43.075)">
                                          <path id="Path_41600" data-name="Path 41600" d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z" transform="translate(22.575 0.058)"/>
                                          <path id="Path_41601" data-name="Path 41601" d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z" transform="translate(45.151 0.006)"/>
                                          <path id="Path_41602" data-name="Path 41602" d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z" transform="translate(67.725 -0.046)"/>
                                          <path id="Path_41603" data-name="Path 41603" d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z" transform="translate(0 0.11)"/>
                                        </g>
                                      </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="">
                                <h5 class="fs-36 fw-400 text-dark mb-3">{{ translate(get_setting('cupon_title')) }}</h5>
                                <h5 class="fs-20 fw-400 text-dark">{{ translate(get_setting('cupon_subtitle')) }}</h5>
                                <div class="mt-5">
                                    <a href="{{ route('coupons.all') }}"
                                        class="btn btn-dark fs-16 px-5 rounded-4"
                                        style="box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.16);">{{ translate('View All Coupons') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Classified Product -->
    @if (get_setting('classified_product') == 1)
        @php
            $classified_products = get_home_page_classified_products(6);
        @endphp
        @if (count($classified_products) > 0)
            <section class="py-3" style="">
                <div class="container">
                    <div class="border">
                        <!-- Top Section -->
                        <div class="d-flex p-3 p-sm-4 align-items-baseline justify-content-between">
                            <!-- Title -->
                            <h3 class="fs-16 fs-md-20 fw-700 mb-0">
                                <span class="">{{ translate('Classified Ads') }}</span>
                            </h3>
                            <!-- Links -->
                            <div class="d-flex">
                                <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                    href="{{ route('customer.products') }}">{{ translate('View All Products') }}</a>
                            </div>
                        </div>
                        <div class="d-sm-flex bg-white pb-3 pb-md-4">
                            <!-- Banner -->
                            @php
                                $classifiedBannerImage = get_setting('classified_banner_image_small', null, $lang);
                            @endphp
                            <div class="px-3 px-sm-4">
                                <div class="w-sm-270px h-320px mx-auto">
                                    <a href="{{ route('customer.products') }}" class="d-block h-100 w-100 w-xl-auto hov-scale-img overflow-hidden">
                                        <img src="{{ uploaded_asset($classifiedBannerImage) }}"
                                            alt="{{ translate('Classified Ads') }}"
                                            class="img-fit h-100 has-transition"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    </a>
                                </div>
                            </div>
                            <!-- Products -->
                            <div class="px-0 px-sm-4 w-100 overflow-hidden">
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5"
                                    data-xxl-items="5" data-xl-items="3.5" data-lg-items="3" data-md-items="2" data-sm-items="1"
                                    data-xs-items="2" data-arrows='true' data-infinite='false'>
                                    @foreach ($classified_products as $key => $classified_product)
                                        <div class="px-3">
                                            <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                class="d-block overflow-hidden h-140px h-md-170px text-center hov-scale-img mb-3">
                                                <img class="img-fluid lazyload mx-auto has-transition"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ isset($classified_product->thumbnail->file_name) ? my_asset($classified_product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                    alt="{{ $classified_product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </a>
                                            <h3
                                                class="fw-400 fs-14 text-dark text-truncate-2 lh-1-4 mb-3 h-35px d-none d-sm-block">
                                                <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                    class="d-block text-reset hov-text-primary">{{ $classified_product->getTranslation('name') }}</a>
                                            </h3>
                                            <div class="fs-14 mb-3">
                                                <span
                                                    class="text-secondary">{{ $classified_product->user ? $classified_product->user->name : '' }}</span><br>
                                                <span
                                                    class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                            </div>
                                            @if ($classified_product->conditon == 'new')
                                                <span
                                                    class="badge badge-inline badge-soft-info fs-13 fw-700 px-3 py-2 text-info"
                                                    style="border-radius: 20px;">{{ translate('New') }}</span>
                                            @elseif($classified_product->conditon == 'used')
                                                <span
                                                    class="badge badge-inline badge-soft-secondary-base fs-13 fw-700 px-3 py-2 text-danger"
                                                    style="border-radius: 20px;">{{ translate('Used') }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif


    @include('frontend/megamart/partials/brand_slider');
    
    









@endsection



@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
<script>
    $(document).ready(function(){
        $('.brand-logos-slider').slick({
            slidesToShow: 7,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: { slidesToShow: 3 }
                },
                {
                    breakpoint: 520,
                    settings: { slidesToShow: 2 }
                }
            ]
        });
    });

    function showTab(tabId, index) {
        // Remove active class from all tabs
        document.querySelectorAll('.custom-tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('d-none');
        });

        // Move the bubble to the selected tab
        document.querySelector('.bubble').style.transform = `translateX(${index * 100}%)`;

        // Show the selected content and activate the tab
        document.getElementById(tabId).classList.remove('d-none');
        document.querySelectorAll('.custom-tab')[index].classList.add('active');
    }
</script>
@endsection