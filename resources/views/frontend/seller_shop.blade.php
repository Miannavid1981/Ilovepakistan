@extends('frontend.layouts.app')

@section('meta_title'){{ $shop->meta_title }}@stop

@section('meta_description'){{ $shop->meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $shop->meta_title }}">
    <meta itemprop="description" content="{{ $shop->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($shop->logo) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="website">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $shop->meta_title }}">
    <meta name="twitter:description" content="{{ $shop->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($shop->meta_img) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $shop->meta_title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('shop.visit', $shop->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($shop->logo) }}" />
    <meta property="og:description" content="{{ $shop->meta_description }}" />
    <meta property="og:site_name" content="{{ $shop->name }}" />
@endsection

@section('content')
<style>
 .banner {
  position: relative;
  background: url('https://www.genesee.edu/wp-content/uploads/banner-solar-electric-technician.jpg') center/cover no-repeat;
  height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  text-align: center;
  background-position: left;
  background-size: cover;
}

/* Create the blurred background using a pseudo-element */
.banner::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5); /* Apply gray color with reduced opacity */
  filter: blur(2px); /* Apply blur to the background */
  z-index: 0; /* Make sure the blur is behind the text */
}


/* Ensure text remains above the blurred background */
.banner h1, .banner p {
  position: relative;
  z-index: 1; /* Bring the text above the blurred background */
}

    .live-stream img {
      border-radius: 10px;
    }
    .live-label {
      position: absolute;
      top: 10px;
      left: 10px;
      background: red;
      color: white;
      padding: 2px 8px;
      font-size: 0.9rem;
      border-radius: 4px;
    }
    .product-card {
      text-align: center;
    }
    .product-card img {
      max-height: 150px;
      object-fit: contain;
    }
    .product-card .price {
      color: #ff6600;
      font-weight: bold;
    }
    .follow-btn:hover {
    background-color: #007bff; /* Primary blue */
    color: white;
  }

 /* Keep previous styles */
.follow-btn {
  position: relative;
  display: flex;
  align-items: center;
}

.heart-icon {
  color: #0D6EFD; /* Neutral gray by default */
  transition: color 0.3s ease, transform 0.3s ease;
  cursor: pointer;
  font-size: 1.5rem;
}

.heart-icon.liked {
  color: #ff4d4d;  /* Red color for liked state */
  transform: scale(1.2); /* Slightly enlarge the icon when liked */
}

    .store_banner {
        height: 300px;
        object-fit: cover;
    }
  </style>
  <img class="store_banner" src="https://www.unitedmobile.pk/wp-content/uploads/2022/11/Samsung-Brand-Banner.webp">
    <section class="mt-3 mb-3 bg-white d-none">
        <div class="container">
            <!--  Top Menu -->
            <div class="d-flex flex-wrap justify-content-center justify-content-md-start">
                <a class="fw-700 fs-11 fs-md-13 mr-3 mr-sm-4 mr-md-5 text-dark opacity-60 hov-opacity-100 @if(!isset($type)) opacity-100 @endif"
                        href="{{ route('shop.visit', $shop->slug) }}">{{ translate('Store Home')}}</a>
                <a class="fw-700 fs-11 fs-md-13 mr-3 mr-sm-4 mr-md-5 text-dark opacity-60 hov-opacity-100 @if(isset($type) && $type == 'top-selling') opacity-100 @endif"
                        href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'top-selling']) }}">{{ translate('Top Selling')}}</a>
                <a class="fw-700 fs-11 fs-md-13 mr-3 mr-sm-4 mr-md-5 text-dark opacity-60 hov-opacity-100 @if(isset($type) && $type == 'cupons') opacity-100 @endif"
                        href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'cupons']) }}">{{ translate('Coupons')}}</a>
                <a class="fw-700 fs-11 fs-md-13 text-dark opacity-60 hov-opacity-100 @if(isset($type) && $type == 'all-products') opacity-100 @endif"
                        href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'all-products']) }}">{{ translate('All Products')}}</a>
            </div>
        </div>
    </section>



    @php
        $followed_sellers = [];
        if (Auth::check()) {
            $followed_sellers = get_followed_sellers();
        }
    @endphp

    @if (!isset($type) || $type == 'top-selling' || $type == 'cupons')
        @if ($shop->top_banner_image)
            <!-- Top Banner -->
            <section class="h-160px h-md-200px h-lg-300px h-xl-100 w-100">
                <a href="{{ $shop->top_banner_link }}">
                    <img class="d-block lazyload h-100 img-fit"
                        src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ uploaded_asset($shop->top_banner_image) }}" alt="{{ env('APP_NAME') }} offer">
                </a>
            </section>
        @endif
    @endif

    <section class="@if (!isset($type) || $type == 'top-selling' || $type == 'cupons') mb-3 @endif border-top border-bottom" >
        <div class="container">
            <!-- Seller Info -->
            <div class="py-4">
                <div class="row justify-content-md-between align-items-start">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <!-- Shop Logo -->
                            <a href="{{ route('shop.visit', $shop->slug) }}" class="overflow-hidden size-64px rounded-content" style="border: 1px solid #e5e5e5;
                                box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);min-width: fit-content;">
                                <img class="lazyload h-64px  mx-auto"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($shop->logo) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            </a>
                            <div class="ml-3 w-100">
                                <div class="d-flex justify-content-between  align-items-start">
                                    <div class="d-flex w-100">
                                        
                                        <!-- Shop Name & Verification Status -->
                                        <a href="{{ route('shop.visit', $shop->slug) }}"
                                            class="text-dark d-block fs-18 fw-700">
                                            <span>{{ $shop->name }}</span>
                                            @if ($shop->verification_status == 1)
                                            <span class="ml-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5">
                                                    <g id="Group_25616" data-name="Group 25616" transform="translate(-537.249 -1042.75)">
                                                        <path id="Union_5" data-name="Union 5" d="M0,8.75A8.75,8.75,0,1,1,8.75,17.5,8.75,8.75,0,0,1,0,8.75Zm.876,0A7.875,7.875,0,1,0,8.75.875,7.883,7.883,0,0,0,.876,8.75Zm.875,0a7,7,0,1,1,7,7A7.008,7.008,0,0,1,1.751,8.751Zm3.73-.907a.789.789,0,0,0,0,1.115l2.23,2.23a.788.788,0,0,0,1.115,0l3.717-3.717a.789.789,0,0,0,0-1.115.788.788,0,0,0-1.115,0l-3.16,3.16L6.6,7.844a.788.788,0,0,0-1.115,0Z" transform="translate(537.249 1042.75)" fill="#3490f3"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            @else
                                            <span class="ml-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5">
                                                    <g id="Group_25616" data-name="Group 25616" transform="translate(-537.249 -1042.75)">
                                                        <path id="Union_5" data-name="Union 5" d="M0,8.75A8.75,8.75,0,1,1,8.75,17.5,8.75,8.75,0,0,1,0,8.75Zm.876,0A7.875,7.875,0,1,0,8.75.875,7.883,7.883,0,0,0,.876,8.75Zm.875,0a7,7,0,1,1,7,7A7.008,7.008,0,0,1,1.751,8.751Zm3.73-.907a.789.789,0,0,0,0,1.115l2.23,2.23a.788.788,0,0,0,1.115,0l3.717-3.717a.789.789,0,0,0,0-1.115.788.788,0,0,0-1.115,0l-3.16,3.16L6.6,7.844a.788.788,0,0,0-1.115,0Z" transform="translate(537.249 1042.75)" fill="red"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            @endif
                                        </a>

                                                              
                                        
                                        @php $shopFollowers = count($shop->followers) + $shop->custom_followers; @endphp
                                        @if(in_array($shop->id, $followed_sellers))
                                            <a href="{{ route("followed_seller.remove", ['id'=>$shop->id]) }}"  data-toggle="tooltip" data-title="{{ translate('Unfollow Seller') }}" data-placement="top"
                                                class="btn btn-success d-flex align-items-center justify-content-center fs-12 w-190px follow-btn followed"
                                                style="height: 40px; border-radius: 30px !important; justify-content: center;">
                                                <i class="las la-check fs-16 mr-2"></i>
                                                <span class="fw-700">{{ translate('Following') }}</span> &nbsp; ({{ $shopFollowers }})
                                            </a>
                                        @else
                                            <a href="{{ route("followed_seller.store", ['id'=>$shop->id]) }}"
                                                class="btn d-flex align-items-center justify-content-center fs-12 w-100px btn-light border ms-2 mt-1"
                                                style="height: 23px; border-radius: 20px !important; justify-content: center;">
                                                
                                                <span class="fw-500">{{ translate('Follow') }}</span>
                                            </a>
                                        
                                        @endif

                                        
                                        
                                    </div>
                                
              
                                    <!-- follow -->
                                        <div class="d-flex flex-column justify-content-md-end pl-lg-3 pt-3 pt-lg-0 gap-2">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button
                                                class="px-1 border-0 d-flex align-items-center  fs-18 w-auto bg-white text-primary ms-2 mt-1"
                                                style="height: 23px; border-radius: 20px !important; justify-content: center;">
                                                
                                                <span class="fw-700"><i class="fa fa-heart"></i></span>
                                            </button>
                                        </div>
                               
                                    </div>

                                </div>  


                                
                                <!-- Address -->
                                <div class="location fs-12 opacity-70 text-dark mt-1">{{ $shop->address }}</div>

                              
                                 <!-- Ratting -->
                                 <div class="rating rating-mr-2 text-dark">
                                    {{ renderStarRating($shop->rating) }}
                                   
                                </div>
                                <span class="opacity-60 fs-12 text-right">({{ $shop->num_of_reviews }}
                                    {{ translate('Reviews') }})</span>
                                     <!-- Member Since -->
                                  <div class="pr-md-3 mt-2 mt-md-0">
                                    <p class="fs-10 fw-400 text-secondary ">{{ translate('Joined') }} {{ date('Y',strtotime($shop->created_at)) }}</p>
                                </div>

                            </div>
                        </div>
                   
                        <div class="d-lg-flex align-items-center justify-content-lg-end">
                            <div class="d-md-flex justify-content-md-end align-items-md-baseline">
                               
                                <!-- Social Links -->
                                @if ($shop->facebook || $shop->instagram || $shop->google || $shop->twitter || $shop->youtube)
                                    <div class="pl-md-3 pr-lg-3 mt-2 mt-md-0 border-lg-right">
                                        <span class="fs-10 fw-400 text-secondary">{{ translate('Social Media') }}</span><br>
                                        <ul class="social-md colored-light list-inline mb-0 mt-1">
                                            @if ($shop->facebook)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->facebook }}" class="facebook"
                                                    target="_blank">
                                                    <i class="lab la-facebook-f"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->instagram)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->instagram }}" class="instagram"
                                                    target="_blank">
                                                    <i class="lab la-instagram"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->google)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->google }}" class="google"
                                                    target="_blank">
                                                    <i class="lab la-google"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->twitter)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->twitter }}" class="twitter"
                                                    target="_blank">
                                                    <i class="lab la-twitter"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->youtube)
                                            <li class="list-inline-item">
                                                <a href="{{ $shop->youtube }}" class="youtube"
                                                    target="_blank">
                                                    <i class="lab la-youtube"></i>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!isset($type))

        <!-- Featured Products -->
        @php
            $feature_products = $shop->user->products->where('published', 1)->where('approved', 1)->where('seller_featured', 1);
        @endphp
        @if (count($feature_products) > 0)
            <section class="mt-3 mb-3" id="section_featured">
                <div class="container">
                <!-- Top Section -->
                <div class="d-flex mb-4 align-items-baseline justify-content-between">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-3 mb-sm-0">
                            <span class="">{{ translate('Featured Products') }}</span>
                        </h3>
                        <!-- Links -->
                        <div class="d-flex">
                            <a type="button" class="arrow-prev slide-arrow text-secondary mr-2" onclick="clickToSlide('slick-prev','section_featured')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                            <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_featured')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                        </div>
                    </div>
                    <!-- Products Section -->
                    <div class="px-sm-3">
                        <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-autoplay='true' data-infinute="true">
                            @foreach ($feature_products as $key => $product)
                            <div class="carousel-box px-3 position-relative has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                                @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Banner Slider -->
        @if ($shop->slider_images != null)
            <section class="mt-3 mb-3">
                <div class="container">
                    <div class="aiz-carousel mobile-img-auto-height" data-arrows="true" data-dots="false" data-autoplay="true">
                        @php
                            $shop_slider_images = get_slider_images(json_decode($shop->slider_images, true));
                            $shop_slider_links = json_decode($shop->slider_links, true);
                        @endphp
                        @foreach ($shop_slider_images as $key => $slider)
                            <div class="carousel-box w-100 h-140px h-md-300px h-xl-450px">
                                <a href="{{ isset($shop_slider_links[$key]) ? $shop_slider_links[$key] : '' }}">
                                    <img class="d-block lazyload h-100 img-fit" 
                                        src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                        alt="{{ $key }} offer">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif


        <!-- Coupons -->
        @php
            $coupons = get_coupons($shop->user->id);
        @endphp
        @if (count($coupons)>0)
            <section class="mt-3 mb-3" id="section_coupons">
                <div class="container">
                <!-- Top Section -->
                <div class="d-flex mb-4 align-items-baseline justify-content-between">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-3 mb-sm-0">
                            <span class="pb-3">{{ translate('Coupons') }}</span>
                        </h3>
                        <!-- Links -->
                        <div class="d-flex">
                            <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_coupons')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                            <a class="text-blue fs-12 fw-700 hov-text-primary" href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'cupons']) }}">{{ translate('View All') }}</a>
                            <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_coupons')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                        </div>
                    </div>
                    <!-- Coupons Section -->
                    <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="3" data-lg-items="2" data-sm-items="1" data-arrows='true' data-infinite='false'>
                        @foreach ($coupons->take(10) as $key => $coupon)
                            <div class="carousel-box">
                                @include('frontend.partials.coupon_box',['coupon' => $coupon])
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        
        <!-- Banner full width 1 -->
        @if ($shop->banner_full_width_1_images)
            @php
                $shop_banner_full_width_1_images = get_slider_images(json_decode($shop->banner_full_width_1_images, true));
                $shop_banner_full_width_1_links = json_decode($shop->banner_full_width_1_links, true);
            @endphp
            @foreach ($shop_banner_full_width_1_images as $key => $banner)
                <section class="container mb-3 mt-3">
                    <div class="w-100">
                        <a href="{{ isset($shop_banner_full_width_1_links[$key]) ? $shop_banner_full_width_1_links[$key] : '' }}">
                            <img class="d-block lazyload h-100 img-fit"
                                src="{{ $banner ? my_asset($banner->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                alt="{{ env('APP_NAME') }} banner">
                        </a>
                    </div>
                </section>
            @endforeach
        @endif
        
        <!-- Banner half width -->
        @if($shop->banners_half_width_images)
            @php
                $shop_banners_half_width_images = get_slider_images(json_decode($shop->banners_half_width_images, true));
                $shop_banners_half_width_links = json_decode($shop->banners_half_width_links, true);
            @endphp
            <section class="container  mb-3 mt-3">
                <div class="row gutters-16">
                    @foreach ($shop_banners_half_width_images as $key => $banner)
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="w-100">
                            <a href="{{ isset($shop_banners_half_width_links[$key]) ? $shop_banners_half_width_links[$key] : '' }}">
                                <img class="d-block lazyload h-100 img-fit"
                                    src="{{ $banner ? my_asset($banner->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                    alt="{{ env('APP_NAME') }} banner">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        @endif

    @endif
<style>
li:has(label.category_tree_item input:checked) {
    background: #fff3f3;
    border-radius: 10px;
    padding: 0 10px; 
    transition: all .1s ease-in-out;
   
}
label.category_tree_item:has(input:checked) img {
    border : unset !important;
    transition: all .1s ease-in-out
}
label.category_tree_item .checkbox_circle {
    aspect-ratio: 1 / 1;
    width: 20px;
    height: 20px !important;
    display: flex;
    align-items: center
}
label.category_tree_item:has(input:checked) .checkbox_circle {
    background: var(--primary)
}
</style>
   <div class="container">
        <div class="row">
            <div class="col-md-3">

                @php
               
//                 // Get product mappings for the authenticated seller
//                 $seller_maps = \App\Models\ProductSellerMap::where('seller_id', $shop->user->id)->get();
//                 // Extract product IDs
//                 $product_ids = $seller_maps->pluck('product_id');
//                 $category_ids = \App\Models\Product::whereIn('id',$product_ids)->pluck('id');
//                 // dd($category_ids);
//                 // Get categories of those products
//                 $all_categories = \App\Models\Category::whereIn('id', $category_ids)->get();
// dd($all_categories);

                // Get product mappings for the authenticated seller
                $preferences_cat = \App\Models\SellerCategoryPreference::where('user_id', $shop->user->id)->pluck('category_id');
                // dd($preferences_cat);
             
                $all_categories = \App\Models\Category::whereIn('id', $preferences_cat)->get();
                
                @endphp
                <h6>Categories</h6>
                <div style="max-height: 300px; overflow-y: scroll">
                    {!! renderCategoryTree($preferences_cat) !!}
                </div>
                
             

            </div>
            <div class="col-md-9">
                <section class="mb-3" id="section_types">
                    <!-- Top Section -->
                    <div class="d-flex align-items-baseline justify-content-between">
                        <!-- Title -->
                        <h6 class="fw-500 mb-3 mb-sm-0">
                            <span class="pb-3">
                                @if (!isset($type))
                                    {{ translate('Browse Store')}}
                                @elseif ($type == 'top-selling')
                                    {{ translate('Top Selling')}}
                                @elseif ($type == 'cupons')
                                    {{ translate('All Cupons')}}
                                @endif
                            </span>
                        </h6>
                        @if (!isset($type))
                            <!-- Links -->
                            <div class="d-flex">
                                <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_types')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                                <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_types')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                            </div>
                        @endif
                    </div>
                    @php
                        // Get the product IDs from the seller_imported_products table
                        $importedProductIds = \App\Models\ProductSellerMap::query()
                            ->where('seller_id', $shop->user->id)
                            ->where('imported', 1)
                            ->pluck('product_id') // Get only the product IDs
                            ->toArray();
        
                        // Get all products in one query to avoid multiple queries inside the loop
                        $importedProducts = \App\Models\Product::whereIn('id', $importedProductIds)->get();
                    @endphp
        
                    <div class="px-sm-3 pb-3">
                        <div class="sm-gutters-16 arrow-none" data-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='false' data-infinite='false'>
                            @foreach ($importedProducts as $key => $product)
                                @php
                                    // Assuming the seller is the same for all products in this loop
                                  //  $seller = \App\Models\User::find($shop->user->id);
                                
                                    $seller_map = \App\Models\ProductSellerMap::where('product_id', $product->id)->where('seller_id', $shop->user->id)->where('imported', 1)->first();
                                  
                                    $encrypted_skin = $seller_map->encrypted_hash ?? '';
                                    // Generate the URL for the product
                                    $product_url = url('/product/' . $product->slug . '/' . $encrypted_skin);
                                    $product->product_custom_url = $product_url;
                                    $product->product_skin = $seller_map->original_skin;
                                @endphp
                                <div class="carousel-box px-3 position-relative has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                                    @include('frontend.' . get_setting('homepage_select') . '.partials.product_box_1', ['product' => $product, 'product_url' => $product_url])
                                </div>
                            @endforeach
                        </div>
                    </div>
        
        
        
                    @php
                        if (!isset($type)){
                            $products = get_seller_products($shop->user->id);
                        }
                        elseif ($type == 'top-selling'){
                            $products = get_shop_best_selling_products($shop->user->id);
                        }
                        elseif ($type == 'cupons'){
                            $coupons = get_coupons($shop->user->id , 24);
                        }
                    @endphp
        
                    @if (!isset($type))
                        <!-- New Arrival Products Section -->
                        <div class="px-sm-3 pb-3">
                            <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                                @foreach ($products as $key => $product)
                                @php
                                    $seller_map = \App\Models\ProductSellerMap::where('product_id', $product->id)->where('seller_id', $product->user_id)->where('source_seller_id',$product->user_id )->first();
                                    $encrypted_skin = $seller_map->encrypted_hash ?? '';
                                    $product_url = url('/product/' . $product->slug . '/' . $encrypted_skin);
                                    $product->product_custom_url = $product_url;
                                @endphp
                                <div class="carousel-box ">
                                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                                </div>
                                @endforeach
                            </div>
                        </div>
        
                        <!-- Banner full width 2 -->
                        @if ($shop->banner_full_width_2_images)
                            @php
                                $shop_banner_full_width_2_images = get_slider_images(json_decode($shop->banner_full_width_2_images, true));
                                $shop_banner_full_width_2_links = json_decode($shop->banner_full_width_2_links, true);
                            @endphp
                            @foreach ($shop_banner_full_width_2_images as $key => $banner)
                                <div class="mt-3 mb-3 w-100">
                                    <a href="{{ isset($shop_banner_full_width_2_links[$key]) ? $shop_banner_full_width_2_links[$key] : '' }}">
                                        <img class="d-block lazyload h-100 img-fit"
                                            src="{{ $banner ? my_asset($banner->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                            alt="{{ env('APP_NAME') }} banner">
                                    </a>
                                </div>
                            @endforeach
                        @endif
        
        
                    @elseif ($type == 'cupons')
                        <!-- All Coupons Section -->
                        <div class="row gutters-16 row-cols-xl-3 row-cols-md-2 row-cols-1">
                            @foreach ($coupons as $key => $coupon)
                                <div class="col mb-4">
                                    @include('frontend.partials.coupon_box',['coupon' => $coupon])
                                </div>
                            @endforeach
                        </div>
                        <div class="aiz-pagination mt-4 mb-4">
                            {{ $coupons->links() }}
                        </div>
        
                    @elseif ($type == 'all-products')
                        <!-- All Products Section -->
                        <form class="" id="search-form" action="" method="GET">
                            <div class="row gutters-16 justify-content-center">
                                <!-- Sidebar -->
                                <div class="col-xl-3 col-md-6 col-sm-8">
        
                                    <!-- Sidebar Filters -->
                                    <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                                        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                                        <div class="collapse-sidebar c-scrollbar-light text-left">
                                            <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                                <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                                <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                                    <i class="las la-times la-2x"></i>
                                                </button>
                                            </div>
        
                                            <!-- Categories -->
                                            <div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0">
                                                <div class="fs-16 fw-700 p-3">
                                                    <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                                        {{ translate('Categories')}}
                                                    </a>
                                                </div>
                                                <div class="collapse show px-3" id="collapse_1">
                                                    @foreach (get_categories_by_products($shop->user->id) as $category)
                                                        <label class="aiz-checkbox mb-3">
                                                            <input
                                                                type="checkbox"
                                                                name="selected_categories[]"
                                                                value="{{ $category->id }}" @if (in_array($category->id, $selected_categories)) checked @endif
                                                                onchange="filter()"
                                                            >
                                                            <span class="aiz-square-check"></span>
                                                            <span class="fs-14 fw-400 text-dark">{{ $category->getTranslation('name') }}</span>
                                                        </label>
                                                        <br>
                                                    @endforeach
                                                </div>
                                            </div>
        
                                            <!-- Price range -->
                                            <div class="bg-white border mb-3">
                                                <div class="fs-16 fw-700 p-3">
                                                    {{ translate('Price range')}}
                                                </div>
                                                <div class="p-3 mr-3">
                                                    <div class="aiz-range-slider">
                                                        <div
                                                            id="input-slider-range"
                                                            data-range-value-min="@if(get_products_count($shop->user->id) < 1) 0 @else {{ get_product_min_unit_price($shop->user->id) }} @endif"
                                                            data-range-value-max="@if(get_products_count($shop->user->id) < 1) 0 @else {{ get_product_max_unit_price($shop->user->id) }} @endif"
                                                        ></div>
        
                                                        <div class="row mt-2">
                                                            <div class="col-6">
                                                                <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                                                    @if ($min_price != null)
                                                                        data-range-value-low="{{ $min_price }}"
                                                                    @elseif($products->min('unit_price') > 0)
                                                                        data-range-value-low="{{ $products->min('unit_price') }}"
                                                                    @else
                                                                        data-range-value-low="0"
                                                                    @endif
                                                                    id="input-slider-range-value-low"
                                                                ></span>
                                                            </div>
                                                            <div class="col-6 text-right">
                                                                <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                                                                    @if ($max_price != null)
                                                                        data-range-value-high="{{ $max_price }}"
                                                                    @elseif($products->max('unit_price') > 0)
                                                                        data-range-value-high="{{ $products->max('unit_price') }}"
                                                                    @else
                                                                        data-range-value-high="0"
                                                                    @endif
                                                                    id="input-slider-range-value-high"
                                                                ></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Hidden Items -->
                                                <input type="hidden" name="min_price" value="">
                                                <input type="hidden" name="max_price" value="">
                                            </div>
        
                                            <!-- Ratings -->
                                            <div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0">
                                                <div class="fs-16 fw-700 p-3">
                                                    <a href="#collapse_2" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                                        {{ translate('Ratings')}}
                                                    </a>
                                                </div>
                                                <div class="collapse show px-3" id="collapse_2">
                                                    <label class="aiz-checkbox mb-3">
                                                        <input
                                                            type="radio"
                                                            name="rating"
                                                            value="5" @if ($rating==5) checked @endif
                                                            onchange="filter()"
                                                        >
                                                        <span class="aiz-square-check"></span>
                                                        <span class="rating rating-mr-2">{{ renderStarRating(5) }}</span>
                                                    </label>
                                                    <br>
                                                    <label class="aiz-checkbox mb-3">
                                                        <input
                                                            type="radio"
                                                            name="rating"
                                                            value="4" @if ($rating==4) checked @endif
                                                            onchange="filter()"
                                                        >
                                                        <span class="aiz-square-check"></span>
                                                        <span class="rating rating-mr-2">{{ renderStarRating(4) }}</span>
                                                        <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                                    </label>
                                                    <br>
                                                    <label class="aiz-checkbox mb-3">
                                                        <input
                                                            type="radio"
                                                            name="rating"
                                                            value="3" @if ($rating==3) checked @endif
                                                            onchange="filter()"
                                                        >
                                                        <span class="aiz-square-check"></span>
                                                        <span class="rating rating-mr-2">{{ renderStarRating(3) }}</span>
                                                        <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                                    </label>
                                                    <br>
                                                    <label class="aiz-checkbox mb-3">
                                                        <input
                                                            type="radio"
                                                            name="rating"
                                                            value="2" @if ($rating==2) checked @endif
                                                            onchange="filter()"
                                                        >
                                                        <span class="aiz-square-check"></span>
                                                        <span class="rating rating-mr-2">{{ renderStarRating(2) }}</span>
                                                        <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                                    </label>
                                                    <br>
                                                    <label class="aiz-checkbox mb-3">
                                                        <input
                                                            type="radio"
                                                            name="rating"
                                                            value="1" @if ($rating==1) checked @endif
                                                            onchange="filter()"
                                                        >
                                                        <span class="aiz-square-check"></span>
                                                        <span class="rating rating-mr-2">{{ renderStarRating(1) }}</span>
                                                        <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                                    </label>
                                                    <br>
                                                </div>
                                            </div>
        
                                            <!-- Brands -->
                                            <div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0">
                                                <div class="fs-16 fw-700 p-3">
                                                    <a href="#collapse_3" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                                        {{ translate('Brands')}}
                                                    </a>
                                                </div>
                                                <div class="collapse show px-3" id="collapse_3">
                                                    <div class="row gutters-10">
                                                        @foreach (get_brands_by_products($shop->user->id) as $key => $brand)
                                                            <div class="col-6">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="{{ $brand->slug }}" type="radio" onchange="filter()"
                                                                        name="brand" @isset($brand_id) @if ($brand_id == $brand->id) checked @endif @endisset>
                                                                    <span class="d-block aiz-megabox-elem rounded-0 p-3 border-transparent hov-border-primary">
                                                                        <img src="{{ uploaded_asset($brand->logo) }}"
                                                                            class="img-fit mb-2" alt="{{ $brand->getTranslation('name') }}">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-400 fs-14">{{ $brand->getTranslation('name') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
        
                                <!-- Contents -->
                                <div class="col-xl-9">
                                    <!-- Top Filters -->
                                    <div class="text-left mb-2">
                                        <div class="row gutters-5 flex-wrap">
                                            <div class="col-lg col-10">
                                                <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                                                    {{ translate('All Products') }}
                                                </h1>
                                            </div>
                                            <div class="col-2 col-lg-auto d-xl-none mb-lg-3 text-right">
                                                <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                                    <i class="la la-filter la-2x"></i>
                                                </button>
                                            </div>
                                            <div class="col-6 col-lg-auto mb-3 w-lg-200px">
                                                <select class="form-control form-control-sm aiz-selectpicker rounded-0" name="sort_by" onchange="filter()">
                                                    <option value="">{{ translate('Sort by')}}</option>
                                                    <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                                                    <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                                                    <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                                                    <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
        
                                    <!-- Products -->
                                    <div class="px-3">
                                        <div class="row gutters-16 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2 border-top border-left">
                                            @foreach ($products as $key => $product)
                                                <div class="col border-right border-bottom has-transition hov-shadow-out z-1">
                                                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="aiz-pagination mt-4">
                                        {{ $products->appends(request()->input())->links() }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <!-- Top Selling Products Section -->
                        <div class="px-3">
                            <div class="row gutters-16 row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 border-left border-top">
                                @foreach ($products as $key => $product)
                                    <div class="col border-bottom border-right overflow-hidden has-transition hov-shadow-out z-1">
                                        @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="aiz-pagination mt-4 mb-4">
                            {{ $products->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </div>
   </div>


@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }

        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }

        document.querySelector('.heart-icon').addEventListener('click', function () {
  if (this.classList.contains('bi-heart')) {
    this.classList.remove('bi-heart'); // Remove outline version
    this.classList.add('bi-heart-fill'); // Add filled version
  } else {
    this.classList.remove('bi-heart-fill'); // Remove filled version
    this.classList.add('bi-heart'); // Add outline version
  }
});
    </script>

@endsection
