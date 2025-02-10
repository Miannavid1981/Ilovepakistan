
@php

    $cart_added = [];


$product_url = route('product', $product->slug);

if ($product->auction_product == 1) {

    $product_url = route('auction-product', $product->slug);

}

if(!empty($product->product_custom_url)){

    $product_url = $product->product_custom_url;
}

@endphp
<style>

.custom_card_tag {
    background-color: #FDE683;
    border: none !important;
    border-radius: 20px;
    width: fit-content;
    background: #FDE683;
    border: none;
    padding: 1px 6px;
    letter-spacing: 1px;
    text-transform: capitalize;
    font-weight: 500;
}
.add-cart-btn { 
    transform: translateY(100%);
    transition: all .3s ease-in-out;
    
}
.aiz-card-box:hover  .add-cart-btn {
    transform: translateY(0);
    transition: all .3s ease-in-out;
}

.view-cart, .add-to-cart{
    display: flex;
    align-items: center;
    justify-content: center;
        padding: 6px;
        font-size: 12px !important;
        background: #fff !important;
        color: #000 !important;
        border-radius: 20px;
        right: 10px;
        left: unset !important;
        bottom: 10px;
        border: 1px solid #ccc;
        left: 10px !important;
        text-decoration: none !important;
        opacity: 1 !important;
        text-transform: uppercase;
        font-weight: 500 !important;
}

       .view-cart:hover ,
       .add-to-cart:hover {
        background: #000 !important;
        transition: all .3s ease-in-out;
        color: #fff !important;
    } 

    @media (min-width: 768px){
        .add-cart-btn button i {
            display: none 
        }
    }
    @media (max-width: 767px){
        .add-cart-btn button span {
            display: none !important
        }
    }
  
   
</style>
<div class="aiz-card-box h-auto py-3 ">
    {{-- <a href="{{$product_url}}" > --}}
        
  
        <div class="position-relative h-100  img-fit overflow-hidden">

        

            <!-- Image -->

            

                @php

                $pro = \App\Models\ProductStock::where('product_id', $product->id)->first();

                @endphp

                                                            

                @if(isset($pro) && $pro->qty > 0)

                    <!--<div class="absolute-top-right bg-primary ml-1 mt-1 fs-11 fw-700 text-white w-35px text-center" style="padding-top:2px;padding-bottom:2px;width: 80px;z-index: 10;">IN STOCK {{ $pro->qty }}</div>-->

                @else

                    <div class="absolute-top-right bg-danger ml-1 mt-1 fs-11 fw-700 text-white w-35px text-center" style="padding-top:2px;padding-bottom:2px;margin-right: 0px;width: 70px;z-index: 10;">SOLD OUT</div>

                @endif

                <!--<div class="absolute-top-right bg-primary ml-1 mt-1 fs-11 fw-700 text-white w-35px text-center" style="padding-top:2px;padding-bottom:2px;"></div>-->

            

                <!--<div class="absolute-top-right bg-danger ml-1 mt-1 fs-11 fw-700 text-white w-35px text-center" style="padding-top:2px;padding-bottom:2px;margin-right: 0px;width: 70px;">sold out</div>-->

            <div class="d-block h-100 position-relative">

                <img class="lazyload mx-auto img-fit has-transition " style="border: 1px solid #dbdbdb; border-radius: 15px; !important;"

                    src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"

                    alt="{{ $product->getTranslation('name') }}" title="{{ $product->getTranslation('name') }}"

                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">


                    <div class="absolute-bottom-left absolute-bottom-right d-flex justify-content-between align-items-center p-3 add-cart-btn gap-2">
                        <button class="view-cart w-100"  href="javascript:void(0)"
                            onclick="showAddToCartModal({{ $product->id }})">
                            <i class="fa-regular fa-eye fs-24 me-2"></i>   
                    <span> Quick View</span>
                    </button>
                        <button class="add-to-cart w-100 d-block g-add-to-cart" data-id="{{ $product->id }}" data-skin_code="{{ get_product_seller_map_skin($product) }}" ><i class="las la-shopping-cart fs-24 me-2"></i> <span>Add to cart</span> </button>

            </div>

            </div>
        
        
    

            @if ($product->wholesale_product)

                <span class="absolute-top-left fs-11 text-white fw-700 px-2 lh-1-8 ml-1 mt-1"

                    style="background-color: #455a64; @if (discount_in_percentage($product) > 0) top:25px; @endif">

                    {{ translate('Wholesale') }}

                </span>

            @endif

            @if ($product->auction_product == 0)

                <!-- wishlisht & compare icons -->

                <div class="absolute-top-right aiz-p-hov-icon" style="margin-top:18px">

                    <a href="javascript:void(0)" class="hov-svg-white" onclick="addToWishList({{ $product->id }})"

                        data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.4" viewBox="0 0 16 14.4">

                            <g id="_51a3dbe0e593ba390ac13cba118295e4" data-name="51a3dbe0e593ba390ac13cba118295e4"

                                transform="translate(-3.05 -4.178)">

                                <path id="Path_32649" data-name="Path 32649"

                                    d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"

                                    transform="translate(0 0)" fill="#919199" />

                                <path id="Path_32650" data-name="Path 32650"

                                    d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"

                                    transform="translate(0 0)" fill="#919199" />

                            </g>

                        </svg>

                    </a>

                    <a href="javascript:void(0)" class="hov-svg-white" onclick="addToCompare({{ $product->id }})"

                        data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">

                            <path id="_9f8e765afedd47ec9e49cea83c37dfea" data-name="9f8e765afedd47ec9e49cea83c37dfea"

                                d="M18.037,5.547v.8a.8.8,0,0,1-.8.8H7.221a.4.4,0,0,0-.4.4V9.216a.642.642,0,0,1-1.1.454L2.456,6.4a.643.643,0,0,1,0-.909L5.723,2.227a.642.642,0,0,1,1.1.454V4.342a.4.4,0,0,0,.4.4H17.234a.8.8,0,0,1,.8.8Zm-3.685,4.86a.642.642,0,0,0-1.1.454v1.661a.4.4,0,0,1-.4.4H2.84a.8.8,0,0,0-.8.8v.8a.8.8,0,0,0,.8.8H12.854a.4.4,0,0,1,.4.4V17.4a.642.642,0,0,0,1.1.454l3.267-3.268a.643.643,0,0,0,0-.909Z"

                                transform="translate(-2.037 -2.038)" fill="#919199" />

                        </svg>

                    </a>

                </div>

                <!-- add to cart -->

                <div class="d-flex justify-content-between align-items-center">
                    <!-- <a class="cart-btn aiz-p-hov-icon text-white fs-13 fw-700 d-flex justify-content-center align-items-center @if (in_array($product->id, $cart_added)) active @endif"
                    href="javascript:void(0)"
                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif>
                        <span><i class="las la-cart-plus fs-24 me-2"></i></span>
                        Buy Now
                    </a>
                    <a class="cart-btn aiz-p-hov-icon text-white fs-13 fw-700 d-flex justify-content-center align-items-center"
                    href="{{ route('cart') }}">
                        <span><i class="las la-shopping-cart fs-24 me-2"></i></span>
                        View Cart
                    </a> -->
                </div>


            @endif

            @if (

                $product->auction_product == 1 &&

                    $product->auction_start_date <= strtotime('now') &&

                    $product->auction_end_date >= strtotime('now'))

                <!-- Place Bid -->

                @php

                    $carts = get_user_cart();

                    if (count($carts) > 0) {

                        $cart_added = $carts->pluck('product_id')->toArray();

                    }

                    $highest_bid = $product->bids->max('amount');

                    $min_bid_amount = $highest_bid != null ? $highest_bid + 1 : $product->starting_bid;

                @endphp

                <a class="cart-btn absolute-bottom-left w-100 h-35px aiz-p-hov-icon text-white fs-13 fw-700 d-flex flex-column justify-content-center align-items-center @if (in_array($product->id, $cart_added)) active @endif"

                    href="javascript:void(0)" onclick="bid_single_modal({{ $product->id }}, {{ $min_bid_amount }})">

                    <span class="cart-btn-text">{{ translate('Place Bid') }}</span>

                    <br>

                    <span><i class="las la-2x la-gavel"></i></span>

                </a>

            @endif

        </div>



        <div class="py-2 py-md-3 text-left">

            <!-- Product name -->

            <!-- Product Categories -->
    @if($product->categories)
    @foreach ($product->categories as $category)
        <button class="custom_card_tag mb-1">{{ $category->getTranslation('name') }}</button>
    @endforeach
@endif
            <h3 class="fw-400 fs-18 lh-1-4 mb-0 mt-1">

                
                <a href="{{ $product_url }}" class="d-block hov-text-primary text-dark" style="font-weight: 600; line-height: 1;" title="{{ $product->getTranslation('name') }}">{{ $product->getTranslation('name') }}</a>

            </h3>
            <div class="d-flex justify-content-start align-items-center g-2 text-warning fs-18 mt-1">
                <i class="la la-star"></i>
                <i class="la la-star"></i>
                <i class="la la-star"></i>
                <i class="la la-star"></i>
                <i class="la la-star"></i>
            </div>
            <div class="d-flex ">

                @if ($product->auction_product == 0)

                    <!-- Previous price -->

                    @if (home_base_price($product) != home_discounted_base_price($product))

                        <div class="">

                            <del class="fw-400 fs-14  text-secondary mr-1">{{ home_base_price($product) }}</del>

                        </div>

                    @endif

                    <!-- price -->

                @endif

                

            </div>
            
            <div class="">
                <span class="fs-15">{{ get_system_default_currency()->code }}</span>
                <span class="fw-700 text-dark text-start fs-20" style=" font-family: "Kanit", serif !important">{{ number_format(home_discounted_base_price($product, false)) }}</span>

                    <!-- Discount percentage tag -->

                    @if (discount_in_percentage($product) > 0)

                        <span class="bg-primary ml-1 fs-15 fw-700 text-white w-35px text-center rounded-3 px-2"

                            style="padding-top:2px;padding-bottom:2px;">-{{ discount_in_percentage($product) }}%</span>

                    @endif 

            <!-- Wholesale tag -->

            </div>

            @if ($product->auction_product == 1)

                    <!-- Bid Amount -->

                    <div class="">

                        <span class="fw-700 fs-20 text-primary ">{{ single_price($product->starting_bid) }}</span>

                    </div>

                @endif

        </div>
    {{-- </a> --}}
</div>

