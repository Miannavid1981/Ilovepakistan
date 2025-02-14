@if (count($newest_products) > 0)
    @php
        $lang = get_system_language()->code;
        $homeBanner3Images = get_setting('home_banner3_images', null, $lang);
        $xxl_items = 3;
        $xl_items = 2.5;
        if ($homeBanner3Images != null){
            $xxl_items = 2;
            $xl_items = 1.8;
        }
    @endphp

    <style> 

    /* Desktop View: 5 Columns */
    @media (min-width: 992px) {
        .product-grid {
            grid-template-columns: repeat(6, 1fr); /* 5 columns on desktop */
        }
    }
    </style>
    <section >
        
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 mt-2 align-items-baseline justify-content-between">
                <!-- Title -->
                {{-- <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">{{ translate('New Products') }}</span>
                </h3> --}}
                <!-- Links -->
                <!-- <div class="d-flex">
                    <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_newest')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('search',['sort_by'=>'newest']) }}">{{ translate('View All') }}</a>
                    <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_newest')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                </div> -->
            </div>
            <!-- Products Section -->
            <div class="row gx-3">
                @foreach ($newest_products as $key => $new_product)
                <div class="col-6 col-md-4 col-lg product-custom-col position-relative has-transition hov-animate-outline">
                    @php
                        $seller_map = \App\Models\ProductSellerMap::where('product_id', $new_product->id)->where('seller_id', $new_product->user_id)->where('source_seller_id',$new_product->user_id )->first();
                        $encrypted_skin = $seller_map->encrypted_hash ?? '';
                        $product_url = url('/product/' . $new_product->slug . '/' . $encrypted_skin);
                        $new_product->product_custom_url = $product_url;
                    @endphp
                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $new_product])
                </div>
                @endforeach
            </div>

       
    </section>
@endif