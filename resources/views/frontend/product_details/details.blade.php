
@php

$product_stock = 0;

@endphp
<style>
    #short_description, #short_description p {
        font-size: 17px;
        letter-spacing: 0.2px;
    }
    .aun {
      display: flex;
      flex-direction: row;
      align-items: flex-start;
      gap: 30px;
      max-width: 1200px;
      width: 100%;
    }

    .blue {
      width: 60%;
    }

    .paisa {
      width: 35%;
    }



    .pr {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .prise {
      color: #fb2364;
      font-size: 17px;
      font-weight: 600;
    }

    .price {
      font-size: 40px;
      color: #1c1c1c;
      font-weight: 800;
    }

    .upcoming-price {
      font-size: 22px;
      color: white;
      font-weight: 550;
    }

    .mm {
      display: flex;
      color: #fd4680;
      background-color: #fff2f2;
      padding: 10px 20px;
      align-items: center;
      border-radius: 5px;
      margin: 10px 0;
    }

    .pink {
      color: #f53a72;
    }

    .title {
      margin: 15px 0;
      font-size: 18px;
      line-height: 1.6;
      font-weight: 600;
    }

    .reviews {
      margin: 15px 0;
      font-weight: 549;
      font-size: 17px;
      padding-bottom: 15px;
      color: #000000;
    }

    .me {
      font-weight: 549;
      color: #000000;
      padding-top: 10px;
    }

    .image-section img {
      width: 80px;
      margin-right: 10px;
      padding-top: 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    .product-container {
      width: 100%;
      padding: 10px 20px;
      background: #fff;
      /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
    }

    .seller-info,
    .shipping-info,
    .security-info,
    .quantity,
    .actions,
    .social-share {
      margin-bottom: 10px;
    }

    .quantity-selector {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .quantity-selector button {
      padding: 5px 10px;
      border: 1px solid #ddd;
      background: #f5f5f5;
      cursor: pointer;
      border-radius: 4px;
    }

    .quantity-selector input {
      width: 40px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .actions {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .add-to-cart, .buy-now {
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
        height: 50px;
        font-size: 15px !important;
    }
    .add-to-cart i , .buy-now i {
        font-size: 25px ;
    }
    .social-share {
      display: flex;
      justify-content: space-between;
      font-size: 15px;
      color: #000000;
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 768px) {
      .aun {
        flex-direction: column;
        gap: 20px;
      }

      .blue,
      .paisa {
        width: 100%;
      }

      .price {
        font-size: 30px;
      }

      .container {
        padding: 10px 15px;
      }

      .image-section img {
        width: 60px;
      }

      .buy-now,
      .add-to-cart {
        font-size: 14px;
        padding: 10px;
      }

      .social-share {
        flex-direction: column;
        gap: 5px;
        text-align: center;
      }
    }

    @media (max-width: 480px) {
      .price {
        font-size: 24px;
      }

      .prise {
        font-size: 14px;
      }

      .upcoming-price {
        font-size: 18px;
      }

      .mm {
        padding: 8px 15px;
        font-size: 14px;
      }

      .title {
        font-size: 16px;
      }

      .reviews {
        font-size: 14px;
      }

      .image-section img {
        width: 50px;
      }

      .quantity-selector input {
        width: 35px;
      }
    }

    .rating i {
    
        font-size: 1.3rem;

    }

.social-share {
    text-align: center;
    margin-top: 20px;
    display: flex;
    align-items: center;
   
}
.share-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    border: none;
    background-color: #fff;
    color: #333;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s ease, background-color 0.3s ease;
    justify-content: center;
}

.share-btn i {
    transition: color 0.3s ease, transform 0.3s ease;
}

.share-btn:hover {
    color: var(--primary); /* Change text color on hover */
}

.share-btn:hover i {
    color: var(--primary);/* Change icon color on hover */
    transform: scale(1.1); /* Slightly enlarge icon */
}

.wishlist-icon {
    font-size: 20px;
    margin-right: 5px;
    cursor: pointer;
    color: #333; /* Default color */
    transition: color 0.3s ease, background-color 0.3s ease;
}

.wishlist-icon.active {
    color: var(--primary);/* Active color when clicked */
    transform: scale(1.2);
}

/* Popup Styles */
.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.popup-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 300px;
    position: relative;
}

.close-btn {
    position: absolute;
    top: 0px;
    bottom: 10px;
    right: 15px;
    font-size: 30px;
    cursor: pointer;
}

#qrCode {
    margin: 15px 0;
}

/* Social Icons */
.social-links {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.social-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: 0.3s ease-in-out;
}

/* Different Colors for Each Icon */
.facebook { background: #1877F2; }
.twitter { background: #1DA1F2; }
.linkedin { background: #0077B5; }
.whatsapp { background: #25D366; }

/* Hover Effects */
.social-icon:hover {
    opacity: 0.8;
}


  </style>

  <div class="row">
    <div class="col-md-7">
        <h4 class="mb-0"> {{ $detailedProduct->getTranslation('name') }}</h4>
       
        <!-- Discount percentage -->
       
       
        <br>
        @if ($detailedProduct->auction_product != 1)
            @php
                $skin = get_product_full_skin_no($detailedProduct->user, $detailedProduct);
                // dd($skin);
                $total = 0;
                $total += $detailedProduct->reviews->where('status', 1)->count();
            @endphp
            <span class="rating rating-mr-2">
                {{ renderStarRating($detailedProduct->rating) }}
            </span>
            <span class="ml-1 opacity-50 fs-15" onclick="change_tab('reviews', true)" style="cursor: pointer;">
                ({{ $total }} {{ translate('reviews') }})
            </span>

        @endif
        <br>
        {{ $detailedProduct->stocks()->first()->sku}}
        <br>
        @if ($detailedProduct->unit != null)
            <span class="opacity-70 mt-1">( {{ $detailedProduct->weight." ".$detailedProduct->getTranslation('unit') }} )</span>
        @endif
        <br>
        <br>
        @if (home_price($detailedProduct) != home_discounted_price($detailedProduct))
        <div class="d-flex align-items-end ">
            
            
            <div class="pr m-0" style="justify-content: start; gap:10px; align-items:end">
                <div class="price" style="line-height: 0.8em;">    {{ home_discounted_price($detailedProduct) }}</div>
                <span class="fs-14 text-gray" style="margin-left: -8px"> / pc</span>
                <h5 class="text-secondary  mb-0" style="text-decoration: line-through">{{ home_price($detailedProduct) }}</h5>
                <!-- <div class="prise">Starts: 23 47 16</div> -->
                @if (discount_in_percentage($detailedProduct) > 0)
                    <span class="bg-primary  text-center py-1 px-3 rounded-2 text-white fs-17 font-weight-bold"
                        style="">{{ discount_in_percentage($detailedProduct) }}% Off</span>
                @endif
            </div>

        </div>
           
        @else
            <div class="pr" style="justify-content: start; gap:10px; align-items:end">
                <div class="price" style="line-height: 0.8em;">{{ home_price($detailedProduct) }}</div>
                <span class="fs-14 text-gray" style="margin-left: -8px"> / pc</span>
                <!-- <div class="prise">Starts: 23 47 16</div> -->
                
            </div>
            
        @endif

       
            <div id="short_description" class="mt-3">
            {!! $detailedProduct->short_description !!}
            </div>
       
      <!-- <div class="sale-price">PKR 852 each, 10 pieces</div>
      <div class="change">Tax excluded, add at checkout if applicable. Extra 5% off with coins.</div>
      <br>
      <div class="mm">
        <div class="pink">☰ PKR 836 off over PKR 13,932</div>
      </div>
      <div class="title">
        Uworld Irregular Stacking Rings: With Irregular Shapes Irregular Dainty Ring Textured Thick Thin Band Fall
        Essentials Gift For He.
      </div> -->
     
       
      <hr>
      <!-- <div class="me"><strong>Main Stone Color: JDRW2405031</strong></div>
      <div class="image-section">
        <img src="https://via.placeholder.com/80" alt="Product Image">
        <img src="https://via.placeholder.com/80" alt="Product Image">
        <img src="https://via.placeholder.com/80" alt="Product Image">
      </div> -->
      <hr>
    </div>
    <div class="col-md-5">
        <div class="product-container border border-1">
            @if (get_setting('conversation_system') == 1)
                <div class="d-none">
                    <button class="btn btn-sm btn-soft-secondary-base btn-outline-secondary-base hov-svg-white hov-text-white rounded-4"
                        onclick="show_chat_modal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            class="mr-2 has-transition">
                            <g id="Group_23918" data-name="Group 23918" transform="translate(1053.151 256.688)">
                                <path id="Path_3012" data-name="Path 3012"
                                    d="M134.849,88.312h-8a2,2,0,0,0-2,2v5a2,2,0,0,0,2,2v3l2.4-3h5.6a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2m1,7a1,1,0,0,1-1,1h-8a1,1,0,0,1-1-1v-5a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z"
                                    transform="translate(-1178 -341)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                                <path id="Path_3013" data-name="Path 3013"
                                    d="M134.849,81.312h8a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h-.5a.5.5,0,0,0,0,1h.5a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2h-8a2,2,0,0,0-2,2v.5a.5.5,0,0,0,1,0v-.5a1,1,0,0,1,1-1"
                                    transform="translate(-1182 -337)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                                <path id="Path_3014" data-name="Path 3014"
                                    d="M131.349,93.312h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                    transform="translate(-1181 -343.5)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                                <path id="Path_3015" data-name="Path 3015"
                                    d="M131.349,99.312h5a.5.5,0,1,1,0,1h-5a.5.5,0,1,1,0-1"
                                    transform="translate(-1181 -346.5)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                            </g>
                        </svg>

                        {{ translate('Message Seller') }}
                    </button>
                </div>
            @endif
            
            @if(!empty($product_child_seller))
                <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                    <h6 class="mb-0">Sold by </h6><a href="{{ route('shop.visit', $product_child_seller->shop->slug) }}" class="fs-15">{{ $product_child_seller->shop->name }}<i class="fa fa-chevron-right ms-2"></i></a>
                </div>
            @else
                @if ($detailedProduct->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                    <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                        <h6 class="mb-0">Sold by </h6><a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}" class="fs-15">{{ $detailedProduct->user->shop->name }}<i class="fa fa-chevron-right ms-2"></i></a>
                    </div>
                @endif
            @endif
            @if ($detailedProduct->brand != null)
                <div class="d-flex align-items-center justify-content-between py-2">
                    <h6 class="mb-0">Brand </h6><a href="{{ route('products.brand', $detailedProduct->brand->slug) }}" class="fs-15">{{ $detailedProduct->brand->name }}<i class="fa fa-chevron-right ms-2"></i></a>
                </div>
            @endif
            <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                <h6 class="mb-0">Net Price </h6><a href="javascript:void(0);" class="fs-15">{{ single_price($detailedProduct->unit_price) }}</a>
            </div>
            @php
                $firstTax = null;
                $firstTaxModel = $detailedProduct->taxes()->first();
                $firstTaxAmount = 0;
                if ($firstTaxModel) {
                    $firstTax = $firstTaxModel->tax;
                    if($firstTaxModel->tax_type == 'percent') {    
                        $firstTaxAmount = ($detailedProduct->unit_price * $firstTax) / 100;
                    } else {
                        $firstTaxAmount = $firstTax;
                    }


                }
            @endphp 
            @if($firstTaxModel)
                <div class="d-flex align-items-center justify-content-between border-bottom py-2"> 
                    <h6 class="mb-0">Tax @if($firstTaxModel->tax_type == 'percent') {{ '('.$detailedProduct->taxes()->first()->tax.'%)' }} @else  @endif</h6><a href="javascript:void(0);" class="fs-15">{{ single_price($firstTaxAmount) }}</a>
                </div>
            @endif
            <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                <h6 class="mb-0">Gross Price </h6><a href="javascript:void(0);" class="fs-15">{{ home_base_price($detailedProduct, true)}}</a>
            </div>
            <div class="row  my-3">
                
                <div class="col-12">
                        @php
                            $qty = 0;
                            
                            foreach ($detailedProduct->stocks as $key => $stock) {
                                $qty += $stock->qty;
                                
                            }
                            $product_stock = $qty;
                        @endphp
                    <h6>Quantity</h6>
                    <div class="product-quantity">
                        <div class="row align-items-center aiz-plus-minus mr-3 ml-0" style="width: 130px;">
                            <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                data-type="minus" data-field="quantity">
                                <i class="las la-minus"></i>
                            </button>
                            <input id="g-detail-quantity" type="number" name="quantity"
                                class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                value="1" min="1"
                                max="{{ $product_stock }}"
                                lang="en">
                            <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                data-type="plus" data-field="quantity">
                                <i class="las la-plus"></i>
                            </button>
                        </div>
                        

                        
                        <p class="avialable-amount opacity-60 mb-0 mt-1">
                            @if ($detailedProduct->stock_visibility_state == 'quantity')
                                (Only <span id="available-quantity">{{ $qty }}</span> left
                                )
                            @elseif($detailedProduct->stock_visibility_state == 'text' && $qty >= 1)
                                (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                            @endif
                        </p>
                    </div>
                </div>
            </div>
                <div class="mt-3">

                    @php
                        $show_cart_btn = true;    
                    @endphp
                    @auth
                        @php
                            $show_cart_btn = show_global_cart() ??  false;
                        @endphp
                    
                    @endauth


                    @if($show_cart_btn)
                        @if ($detailedProduct->digital == 0)
                            @if (((get_setting('product_external_link_for_seller') == 1) && ($detailedProduct->added_by == "seller") && ($detailedProduct->external_link != null)) ||
                                (($detailedProduct->added_by != "seller") && ($detailedProduct->external_link != null)))
                                <a type="button" class="btn btn-primary buy-now fw-600 add-to-cart px-4 rounded-0"
                                    href="{{ $detailedProduct->external_link }}">
                                    <i class="la la-share"></i> {{ translate($detailedProduct->external_link_btn) }}
                                </a>
                            @else
                            
                                <button type="button" class="btn  btn-light text-dark border border-dark py-2 w-100  buy-now fw-600 add-to-cart min-w-150px rounded-0 g-buy-now" data-id="{{ $detailedProduct->id }}" data-skin_code="{{ $detailpage_skin }}">
                                    {{ translate('Buy Now') }}
                                </button>
                                <button type="button" data-id="{{ $detailedProduct->id }}" data-skin_code="{{ $detailpage_skin }}" class="btn py-2 btn-primary w-100 mt-2 add-to-cart fw-600  rounded-0  g-add-to-cart">
                                    <i class="las las la-shopping-cart"></i> {{ translate('Add to cart') }}
                                </button>
                            @endif
                            <button type="button" class="btn btn-secondary out-of-stock fw-600 d-none"  disabled>
                                <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock') }}
                            </button>
                        @elseif ($detailedProduct->digital == 1)
                            <button type="button"  class="btn btn-primary buy-now fw-600 add-to-cart min-w-150px rounded-0"
                                @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                                <i class="la la-shopping-cart"></i> {{ translate('Buy Now') }}
                            </button>
                            <button type="button"
                                class="btn btn-secondary-base mt-2  mr-2 add-to-cart fw-600 min-w-150px rounded-0 text-white"
                                @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                                <i class="las la-shopping-bag"></i> {{ translate('Add to cart') }}
                            </button>
                            
                        @endif

                    @else
                        @auth

                            @php
                                $seller_type = auth()->user()->seller_type;   
                                $seller_imported_flag = (int) \App\Models\ProductSellerMap::where('product_id', $detailedProduct->id)->where('seller_id', auth()->user()->id)->count();
                            @endphp

                            <div class="d-flex">
                                @if($seller_type != 'brand_partner')
                                    @if($seller_imported_flag)
                                        <button type="button" data-id="{{ $detailedProduct->id }}" style="background: #eee" class="btn text-dark  buy-now fw-600  min-w-150px rounded-0 g-import-to-seller w-100">
                                            <i class="la la-plus"></i> {{ translate('Import') }}
                                        </button>
                                    @else
                                        <button type="button" data-id="{{ $detailedProduct->id }}" style="background: #eee" class="btn text-dark buy-now fw-600  min-w-150px rounded-0  w-100 fs-16" disabled>
                                            <i class="la la-check"></i> Imported
                                        </button>
                                    @endif
                                @endif
                                @if($seller_type != 'store_partner')
                                    <a href="{{ url('/seller/product/create') }}" class="btn btn-primary buy-now fw-600 min-w-150px rounded-0  w-100 g-add-to-cart" >
                                        <i class="la la-plus"></i> New Listing
                                    </a>
                                @endif
                            </div>

                        @endauth  
                    @endif
                </div>
                <div class="social-share">
                    <button class="share-btn" onclick="openSharePopup()">
                        <i class="fa-solid fa-share"> </i>Share
                    </button>
                    <div>
                        <i class="fa-solid fa-heart wishlist-icon"></i> Add to Wishlist
                    </div>
                
                    <!-- Popup Modal -->
                    <div id="sharePopup" class="popup">
                        <div class="popup-content">
                            <span class="close-btn" onclick="closeSharePopup()">&times;</span>
                            <h3>Scan & Share</h3>
                            <div id="capture" class="py-4">
                                <!-- QR Code -->
                                <div id="qrCode">
                                    <div style="    aspect-ratio: 1 / 1;
                                    width: 200px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    margin: 0 auto;position: relative">
                                        @php
                                            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate(url()->full()));
                                        @endphp
                                        <img src="data:image/png;base64,{{ $qrCode }}" style="width: 100%; height: 100%; aspect-ratio: 1 / 1;" />
                                        <div style="   
                                        position: absolute;
                                        top: 0;
                                        /* background-color: #fde6ff; */
                                        border-radius: 50%;
                                        /* width: 50px; */
                                        /* height: 50px; */
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        /* border: 1px solid #8722d2; */
                                        left: 5revert-layer;
                                        left: 0;
                                        right: 0;
                                        bottom: 0;
                                        ">
                                        <img src="{{ uploaded_asset(get_setting('site_icon')) }}" class="ms-2" style="width: 26px; height: auto; background-color: #fff; border-radius: 50%;;" alt="Discover">
                                        </div>
                                    </div>
                                    <p>
                                        @if(!empty($product_child_seller))
                                            
                                                {{ $product_child_seller->shop->name }}
                                        
                                        @else
                                            {{ $detailedProduct->user->shop->name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                
                           <div class="social-links">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('product', $detailedProduct->slug)) }}" target="_blank" class="social-icon facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>

                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('product', $detailedProduct->slug)) }}&text={{ urlencode($detailedProduct->meta_title) }}" target="_blank" class="social-icon twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>

                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('product', $detailedProduct->slug)) }}" target="_blank" class="social-icon linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>

                                <a href="https://api.whatsapp.com/send?text={{ urlencode($detailedProduct->meta_title.' '.route('product', $detailedProduct->slug)) }}" target="_blank" class="social-icon whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>

                            </div>
                            <button id="downloadBtn" class="btn btn-primary mt-3" style="   margin: 0 auto; padding: 10px 20px !important;;">Download as Image</button>

                        </div>
                    </div>
                </div>
                
                
        </div>
    </div>
  </div>
</body>


<div class=" d-none">
    <!-- Product Name -->
    <h2 class="mb-4 fs-16 fw-700 text-dark">
        {{ $detailedProduct->getTranslation('name') }}
    </h2>

    <div class="row align-items-center mb-3">
        <!-- Review -->
        @if ($detailedProduct->auction_product != 1)
            <div class="col-12">
                @php
                    $total = 0;
                    $total += $detailedProduct->reviews->where('status', 1)->count();
                @endphp
                <span class="rating rating-mr-2">
                    {{ renderStarRating($detailedProduct->rating) }}
                </span>
                <span class="ml-1 opacity-50 fs-14">({{ $total }}
                    {{ translate('reviews') }})</span>
            </div>
        @endif
        <!-- Estimate Shipping Time -->
        @if ($detailedProduct->est_shipping_days)
            <div class="col-auto fs-14 mt-1">
                <small class="mr-1 opacity-50 fs-14">{{ translate('Estimate Shipping Time') }}:</small>
                <span class="fw-500">{{ $detailedProduct->est_shipping_days }} {{ translate('Days') }}</span>
            </div>
        @endif
        <!-- In stock -->
        @if ($detailedProduct->digital == 1)
            <div class="col-12 mt-1">
                <span class="badge badge-md badge-inline badge-pill badge-success">{{ translate('In stock') }}</span>
            </div>
        @endif
    </div>
    <div class="row align-items-center">
        @if(get_setting('product_query_activation') == 1)
            <!-- Ask about this product -->
            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-4 mb-3">
                <a href="javascript:void();" onclick="goToView('product_query')" class="text-primary fs-14 fw-600 d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                        <g id="Group_25571" data-name="Group 25571" transform="translate(-975 -411)">
                            <g id="Path_32843" data-name="Path 32843" transform="translate(975 411)" fill="#fff">
                                <path
                                    d="M 16 31 C 11.9933500289917 31 8.226519584655762 29.43972969055176 5.393400192260742 26.60659980773926 C 2.560270071029663 23.77347946166992 1 20.00665092468262 1 16 C 1 11.9933500289917 2.560270071029663 8.226519584655762 5.393400192260742 5.393400192260742 C 8.226519584655762 2.560270071029663 11.9933500289917 1 16 1 C 20.00665092468262 1 23.77347946166992 2.560270071029663 26.60659980773926 5.393400192260742 C 29.43972969055176 8.226519584655762 31 11.9933500289917 31 16 C 31 20.00665092468262 29.43972969055176 23.77347946166992 26.60659980773926 26.60659980773926 C 23.77347946166992 29.43972969055176 20.00665092468262 31 16 31 Z"
                                    stroke="none" />
                                <path
                                    d="M 16 2 C 12.26045989990234 2 8.744749069213867 3.456249237060547 6.100500106811523 6.100500106811523 C 3.456249237060547 8.744749069213867 2 12.26045989990234 2 16 C 2 19.73954010009766 3.456249237060547 23.2552490234375 6.100500106811523 25.89949989318848 C 8.744749069213867 28.54375076293945 12.26045989990234 30 16 30 C 19.73954010009766 30 23.2552490234375 28.54375076293945 25.89949989318848 25.89949989318848 C 28.54375076293945 23.2552490234375 30 19.73954010009766 30 16 C 30 12.26045989990234 28.54375076293945 8.744749069213867 25.89949989318848 6.100500106811523 C 23.2552490234375 3.456249237060547 19.73954010009766 2 16 2 M 16 0 C 24.8365592956543 0 32 7.163440704345703 32 16 C 32 24.8365592956543 24.8365592956543 32 16 32 C 7.163440704345703 32 0 24.8365592956543 0 16 C 0 7.163440704345703 7.163440704345703 0 16 0 Z"
                                    stroke="none" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                            </g>
                            <path id="Path_32842" data-name="Path 32842"
                                d="M28.738,30.935a1.185,1.185,0,0,1-1.185-1.185,3.964,3.964,0,0,1,.942-2.613c.089-.095.213-.207.361-.344.735-.658,2.252-2.032,2.252-3.555a2.228,2.228,0,0,0-2.37-2.37,2.228,2.228,0,0,0-2.37,2.37,1.185,1.185,0,1,1-2.37,0,4.592,4.592,0,0,1,4.74-4.74,4.592,4.592,0,0,1,4.74,4.74c0,2.577-2.044,4.432-3.028,5.333l-.284.255a1.89,1.89,0,0,0-.243.948A1.185,1.185,0,0,1,28.738,30.935Zm0,3.561a1.185,1.185,0,0,1-.835-2.026,1.226,1.226,0,0,1,1.671,0,1.061,1.061,0,0,1,.148.184,1.345,1.345,0,0,1,.113.2,1.41,1.41,0,0,1,.065.225,1.138,1.138,0,0,1,0,.462,1.338,1.338,0,0,1-.065.219,1.185,1.185,0,0,1-.113.207,1.06,1.06,0,0,1-.148.184A1.185,1.185,0,0,1,28.738,34.5Z"
                                transform="translate(962.004 400.504)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                        </g>
                    </svg>
                    <span class="ml-2 text-primary animate-underline-blue">{{ translate('Product Inquiry') }}</span>
                </a>
            </div>
        @endif
        <div class="col mb-3">
            @if ($detailedProduct->auction_product != 1)
                <div class="d-flex">
                    <!-- Add to wishlist button -->
                    <a href="javascript:void(0)" onclick="addToWishList({{ $detailedProduct->id }})"
                        class="mr-3 fs-14 text-dark opacity-60 has-transitiuon hov-opacity-100">
                        <i class="la la-heart-o mr-1"></i>
                        {{ translate('Add to Wishlist') }}
                    </a>
                    <!-- Add to compare button -->
                    <a href="javascript:void(0)" onclick="addToCompare({{ $detailedProduct->id }})"
                        class="fs-14 text-dark opacity-60 has-transitiuon hov-opacity-100">
                        <i class="las la-sync mr-1"></i>
                        {{ translate('Add to Compare') }}
                    </a>
                </div>
            @endif
        </div>
    </div>


    <!-- Brand Logo & Name -->
    @if ($detailedProduct->brand != null)
        <div class="d-flex flex-wrap align-items-center mb-3">
            <span class="text-secondary fs-14 fw-400 mr-4 w-80px">{{ translate('Brand') }}</span><br>
            <a href="{{ route('products.brand', $detailedProduct->brand->slug) }}"
                class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedProduct->brand->name }}</a>
        </div>
    @endif

    {{-- Warranty --}}
    @if ($detailedProduct->has_warranty == 1 && $detailedProduct->warranty_id != null)
        <div class="d-flex flex-wrap align-items-center mb-3">
            <span class="text-secondary fs-14 fw-400 mr-4 w-80px">{{ translate('Warranty') }}</span><br>
            <img src="{{ uploaded_asset($detailedProduct->warranty->logo) }}" height="40">
            <span class="border border-secondary-base btn fs-12 ml-3 px-3 py-1 rounded-1 text-secondary">
                {{ $detailedProduct->warranty->getTranslation('text')}}
                @if($detailedProduct->warranty_note_id != null)
                    <span href="javascript:void(1);" 
                        data-toggle="modal" data-target="#warranty-note-modal"
                        class="border-bottom border-bottom-4 ml-2 text-secondary-base">
                        {{ translate('View Details') }}
                    </span>
                @endif
            </span>
        </div>
    @endif

    <!-- Seller Info -->
    <div class="d-flex flex-wrap align-items-center">
        <div class="d-flex align-items-center mr-4">
            <!-- Shop Name -->
            @if ($detailedProduct->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                <span class="text-secondary fs-14 fw-400 mr-4 w-80px">{{ translate('Sold by') }}</span>
                <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                    class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedProduct->user->shop->name }}</a>
            @else
                <p class="mb-0 fs-14 fw-700">{{ translate('Inhouse product') }}</p>
            @endif
        </div>
        <!-- Messase to seller -->
        @if (get_setting('conversation_system') == 1)
            <div class="">
                <button class="btn btn-sm btn-soft-secondary-base btn-outline-secondary-base hov-svg-white hov-text-white rounded-4"
                    onclick="show_chat_modal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        class="mr-2 has-transition">
                        <g id="Group_23918" data-name="Group 23918" transform="translate(1053.151 256.688)">
                            <path id="Path_3012" data-name="Path 3012"
                                d="M134.849,88.312h-8a2,2,0,0,0-2,2v5a2,2,0,0,0,2,2v3l2.4-3h5.6a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2m1,7a1,1,0,0,1-1,1h-8a1,1,0,0,1-1-1v-5a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z"
                                transform="translate(-1178 -341)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                            <path id="Path_3013" data-name="Path 3013"
                                d="M134.849,81.312h8a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h-.5a.5.5,0,0,0,0,1h.5a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2h-8a2,2,0,0,0-2,2v.5a.5.5,0,0,0,1,0v-.5a1,1,0,0,1,1-1"
                                transform="translate(-1182 -337)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                            <path id="Path_3014" data-name="Path 3014"
                                d="M131.349,93.312h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                transform="translate(-1181 -343.5)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                            <path id="Path_3015" data-name="Path 3015"
                                d="M131.349,99.312h5a.5.5,0,1,1,0,1h-5a.5.5,0,1,1,0-1"
                                transform="translate(-1181 -346.5)" fill="{{ get_setting('secondary_base_color', '#ffc519') }}" />
                        </g>
                    </svg>

                    {{ translate('Message Seller') }}
                </button>
            </div>
        @endif
        <!-- Size guide -->
        @php
            $sizeChartId = ($detailedProduct->main_category && $detailedProduct->main_category->sizeChart) ? $detailedProduct->main_category->sizeChart->id : 0;
            $sizeChartName = ($detailedProduct->main_category && $detailedProduct->main_category->sizeChart) ? $detailedProduct->main_category->sizeChart->name : null;
        @endphp
        @if($sizeChartId != 0)
            <div class=" ml-4">
                <a href="javascript:void(1);" onclick='showSizeChartDetail({{ $sizeChartId }}, "{{ $sizeChartName }}")' class="animate-underline-primary">{{ translate('Show size guide') }}</a>
            </div>
        @endif
    </div>

    <hr>

    <!-- For auction product -->
    @if ($detailedProduct->auction_product)
        <div class="row no-gutters mb-3">
            <div class="col-sm-2">
                <div class="text-secondary fs-14 fw-400 mt-1">{{ translate('Auction Will End') }}</div>
            </div>
            <div class="col-sm-10">
                @if ($detailedProduct->auction_end_date > strtotime('now'))
                    <div class="aiz-count-down align-items-center"
                        data-date="{{ date('Y/m/d H:i:s', $detailedProduct->auction_end_date) }}"></div>
                @else
                    <p>{{ translate('Ended') }}</p>
                @endif

            </div>
        </div>

        <div class="row no-gutters mb-3">
            <div class="col-sm-2">
                <div class="text-secondary fs-14 fw-400 mt-1">{{ translate('Starting Bid') }}</div>
            </div>
            <div class="col-sm-10">
                <span class="opacity-50 fs-20">
                    {{ single_price($detailedProduct->starting_bid) }}
                </span>
                @if ($detailedProduct->unit != null)
                    <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                @endif
            </div>
        </div>

        @if (Auth::check() &&
                Auth::user()->product_bids->where('product_id', $detailedProduct->id)->first() != null)
            <div class="row no-gutters mb-3">
                <div class="col-sm-2">
                    <div class="text-secondary fs-14 fw-400 mt-1">{{ translate('My Bidded Amount') }}</div>
                </div>
                <div class="col-sm-10">
                    <span class="opacity-50 fs-20">
                        {{ single_price(Auth::user()->product_bids->where('product_id', $detailedProduct->id)->first()->amount) }}
                    </span>
                </div>
            </div>
            <hr>
        @endif

        @php $highest_bid = $detailedProduct->bids->max('amount'); @endphp
        <div class="row no-gutters my-2 mb-3">
            <div class="col-sm-2">
                <div class="text-secondary fs-14 fw-400 mt-1">{{ translate('Highest Bid') }}</div>
            </div>
            <div class="col-sm-10">
                <strong class="h3 fw-600 text-primary">
                    @if ($highest_bid != null)
                        {{ single_price($highest_bid) }}
                    @endif
                </strong>
            </div>
        </div>
    @else
        <!-- Without auction product -->
        @if ($detailedProduct->wholesale_product == 1)
            <!-- Wholesale -->
            <table class="table mb-3">
                <thead>
                    <tr>
                        <th class="border-top-0">{{ translate('Min Qty') }}</th>
                        <th class="border-top-0">{{ translate('Max Qty') }}</th>
                        <th class="border-top-0">{{ translate('Unit Price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailedProduct->stocks->first()->wholesalePrices as $wholesalePrice)
                        <tr>
                            <td>{{ $wholesalePrice->min_qty }}</td>
                            <td>{{ $wholesalePrice->max_qty }}</td>
                            <td>{{ single_price($wholesalePrice->price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <!-- Without Wholesale -->
            @if (home_price($detailedProduct) != home_discounted_price($detailedProduct))
                <div class="row no-gutters mb-3">
                    <div class="col-sm-2">
                        <div class="text-secondary fs-14 fw-400">{{ translate('Price') }}</div>
                    </div>
                    <div class="col-sm-10">
                        <div class="d-flex align-items-center">
                            <!-- Discount Price -->
                            <strong class="fs-16 fw-700 text-primary">
                                {{ home_discounted_price($detailedProduct) }}
                            </strong>
                            <!-- Home Price -->
                            <del class="fs-14 opacity-60 ml-2">
                                {{ home_price($detailedProduct) }}
                            </del>
                            <!-- Unit -->
                            @if ($detailedProduct->unit != null)
                                <span class="opacity-70 ml-1">/{{ $detailedProduct->getTranslation('unit') }}</span>
                            @endif
                            <!-- Discount percentage -->
                            @if (discount_in_percentage($detailedProduct) > 0)
                                <span class="bg-primary ml-2 fs-11 fw-700 text-white w-35px text-center p-1"
                                    style="padding-top:2px;padding-bottom:2px;">-{{ discount_in_percentage($detailedProduct) }}%</span>
                            @endif
                            <!-- Club Point -->
                            @if (addon_is_activated('club_point') && $detailedProduct->earn_point > 0)
                                <div class="ml-2 bg-secondary-base d-flex justify-content-center align-items-center px-3 py-1"
                                    style="width: fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <g id="Group_23922" data-name="Group 23922" transform="translate(-973 -633)">
                                            <circle id="Ellipse_39" data-name="Ellipse 39" cx="6"
                                                cy="6" r="6" transform="translate(973 633)"
                                                fill="#fff" />
                                            <g id="Group_23920" data-name="Group 23920"
                                                transform="translate(973 633)">
                                                <path id="Path_28698" data-name="Path 28698"
                                                    d="M7.667,3H4.333L3,5,6,9,9,5Z" transform="translate(0 0)"
                                                    fill="#f3af3d" />
                                                <path id="Path_28699" data-name="Path 28699"
                                                    d="M5.33,3h-1L3,5,6,9,4.331,5Z" transform="translate(0 0)"
                                                    fill="#f3af3d" opacity="0.5" />
                                                <path id="Path_28700" data-name="Path 28700"
                                                    d="M12.666,3h1L15,5,12,9l1.664-4Z" transform="translate(-5.995 0)"
                                                    fill="#f3af3d" />
                                            </g>
                                        </g>
                                    </svg>
                                    <small class="fs-11 fw-500 text-white ml-2">{{ translate('Club Point') }}:
                                        {{ $detailedProduct->earn_point }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="row no-gutters mb-3">
                    <div class="col-sm-2">
                        <div class="text-secondary fs-14 fw-400">{{ translate('Price') }}</div>
                    </div>
                    <div class="col-sm-10">
                        <div class="d-flex align-items-center">
                            <!-- Discount Price -->
                            <strong class="fs-16 fw-700 text-primary">
                                {{ home_discounted_price($detailedProduct) }}
                            </strong>
                            <!-- Unit -->
                            @if ($detailedProduct->unit != null)
                                <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                            @endif
                            <!-- Club Point -->
                            @if (addon_is_activated('club_point') && $detailedProduct->earn_point > 0)
                                <div class="ml-2 bg-secondary-base d-flex justify-content-center align-items-center px-3 py-1"
                                    style="width: fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <g id="Group_23922" data-name="Group 23922" transform="translate(-973 -633)">
                                            <circle id="Ellipse_39" data-name="Ellipse 39" cx="6"
                                                cy="6" r="6" transform="translate(973 633)"
                                                fill="#fff" />
                                            <g id="Group_23920" data-name="Group 23920"
                                                transform="translate(973 633)">
                                                <path id="Path_28698" data-name="Path 28698"
                                                    d="M7.667,3H4.333L3,5,6,9,9,5Z" transform="translate(0 0)"
                                                    fill="#f3af3d" />
                                                <path id="Path_28699" data-name="Path 28699"
                                                    d="M5.33,3h-1L3,5,6,9,4.331,5Z" transform="translate(0 0)"
                                                    fill="#f3af3d" opacity="0.5" />
                                                <path id="Path_28700" data-name="Path 28700"
                                                    d="M12.666,3h1L15,5,12,9l1.664-4Z" transform="translate(-5.995 0)"
                                                    fill="#f3af3d" />
                                            </g>
                                        </g>
                                    </svg>
                                    <small class="fs-11 fw-500 text-white ml-2">{{ translate('Club Point') }}:
                                        {{ $detailedProduct->earn_point }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endif

    @if ($detailedProduct->auction_product != 1)
        <form id="option-choice-form">
            @csrf
            <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

            @if ($detailedProduct->digital == 0)
                <!-- Choice Options -->
                @if ($detailedProduct->choice_options != null)
                    @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                        <div class="row no-gutters mb-3">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2 ">
                                    {{ get_single_attribute_name($choice->attribute_id) }}
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="aiz-radio-inline">
                                    @foreach ($choice->values as $key => $value)
                                        <label class="aiz-megabox pl-0 mr-2 mb-0">
                                            <input type="radio" name="attribute_id_{{ $choice->attribute_id }}"
                                                value="{{ $value }}"
                                                @if ($key == 0) checked @endif>
                                            <span
                                                class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center py-1 px-3">
                                                {{ $value }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Color Options -->
                @if ($detailedProduct->colors != null && count(json_decode($detailedProduct->colors)) > 0)
                    <div class="row no-gutters mb-3">
                        <div class="col-sm-2">
                            <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Color') }}</div>
                        </div>
                        <div class="col-sm-10">
                            <div class="aiz-radio-inline">
                                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                    <label class="aiz-megabox pl-0 mr-2 mb-0" data-toggle="tooltip"
                                        data-title="{{ get_single_color_name($color) }}">
                                        <input type="radio" name="color"
                                            value="{{ get_single_color_name($color) }}"
                                            @if ($key == 0) checked @endif>
                                        <span
                                            class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center p-1">
                                            <span class="size-25px d-inline-block rounded"
                                                style="background: {{ $color }};"></span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quantity + Add to cart -->
            @else
                <!-- Quantity -->
                <input type="hidden" name="quantity" value="1">
            @endif

            <!-- Total Price -->
            <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                <div class="col-sm-2">
                    <div class="text-secondary fs-14 fw-400 mt-1">{{ translate('Total Price') }}</div>
                </div>
                <div class="col-sm-10">
                    <div class="product-price">
                        <strong id="chosen_price" class="fs-20 fw-700 text-primary">

                        </strong>
                    </div>
                </div>
            </div>

        </form>
    @endif

    @if ($detailedProduct->auction_product)
        @php
            $highest_bid = $detailedProduct->bids->max('amount');
            $min_bid_amount = $highest_bid != null ? $highest_bid + 1 : $detailedProduct->starting_bid;
        @endphp
        @if ($detailedProduct->auction_end_date >= strtotime('now'))
            <div class="mt-4">
                @if (Auth::check() && $detailedProduct->user_id == Auth::user()->id)
                    <span
                        class="badge badge-inline badge-danger">{{ translate('Seller cannot Place Bid to His Own Product') }}</span>
                @else
                    <button type="button" class="btn btn-primary buy-now  fw-600 min-w-150px rounded-0"
                        onclick="bid_modal()">
                        <i class="las la-gavel"></i>
                        @if (Auth::check() &&
                                Auth::user()->product_bids->where('product_id', $detailedProduct->id)->first() != null)
                            {{ translate('Change Bid') }}
                        @else
                            {{ translate('Place Bid') }}
                        @endif
                    </button>
                @endif
            </div>
        @endif
    @else
        <!-- Add to cart & Buy now Buttons -->
        <div class="mt-3">

            @if(show_global_cart())
                @if ($detailedProduct->digital == 0)
                    @if (((get_setting('product_external_link_for_seller') == 1) && ($detailedProduct->added_by == "seller") && ($detailedProduct->external_link != null)) ||
                        (($detailedProduct->added_by != "seller") && ($detailedProduct->external_link != null)))
                        <a type="button" class="btn btn-primary buy-now fw-600 add-to-cart px-4 rounded-0"
                            href="{{ $detailedProduct->external_link }}">
                            <i class="la la-share"></i> {{ translate($detailedProduct->external_link_btn) }}
                        </a>
                    @else
                        <button type="button"
                            class="btn btn-secondary-base mr-2 add-to-cart fw-600 min-w-150px rounded-0 text-white"
                            @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                            <i class="las la-shopping-bag"></i> {{ translate('Add to cart') }}
                        </button>
                        <button type="button" class="btn btn-primary buy-now fw-600 add-to-cart min-w-150px rounded-0"
                            @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                            <i class="la la-shopping-cart"></i> {{ translate('Buy Now') }}
                        </button>
                    @endif
                    <button type="button" class="btn btn-secondary out-of-stock fw-600 d-none" disabled>
                        <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock') }}
                    </button>
                @elseif ($detailedProduct->digital == 1)
                    <button type="button"
                        class="btn btn-secondary-base mr-2 add-to-cart fw-600 min-w-150px rounded-0 text-white"
                        @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                        <i class="las la-shopping-bag"></i> {{ translate('Add to cart') }}
                    </button>
                    <button type="button" class="btn btn-primary buy-now fw-600 add-to-cart min-w-150px rounded-0"
                        @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                        <i class="la la-shopping-cart"></i> {{ translate('Buy Now') }}
                    </button>
                @endif
            @else

                <button type="button" data-id="{{ $detailedProduct->id }}" class="btn btn-primary buy-now fw-600 add-to-cart min-w-150px rounded-0 g-import-to-seller">
                    <i class="la la-shopping-cart"></i> {{ translate('Buy Now') }}
                </button>

            @endif
        </div>

        <!-- Promote Link -->
        <div class="d-table width-100 mt-3">
            <div class="d-table-cell">
                @if (Auth::check() &&
                        addon_is_activated('affiliate_system') &&
                        get_affliate_option_status() &&
                        Auth::user()->affiliate_user != null &&
                        Auth::user()->affiliate_user->status)
                    @php
                        if (Auth::check()) {
                            if (Auth::user()->referral_code == null) {
                                Auth::user()->referral_code = substr(Auth::user()->id . Str::random(10), 0, 10);
                                Auth::user()->save();
                            }
                            $referral_code = Auth::user()->referral_code;
                            $referral_code_url = URL::to('/product') . '/' . $detailedProduct->slug . "?product_referral_code=$referral_code";
                        }
                    @endphp
                    <div>
                        <button type="button" id="ref-cpurl-btn" class="btn btn-secondary w-200px rounded-0"
                            data-attrcpy="{{ translate('Copied') }}" onclick="CopyToClipboard(this)"
                            data-url="{{ $referral_code_url }}">{{ translate('Copy the Promote Link') }}</button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Refund -->
        @php
            $refund_sticker = get_setting('refund_sticker');
        @endphp
        @if (addon_is_activated('refund_request'))
            <div class="row no-gutters mt-3">
                <div class="col-sm-2">
                    <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Refund') }}</div>
                </div>
                <div class="col-sm-10">
                    @if ($detailedProduct->refundable == 1)
                        <a href="{{ route('returnpolicy') }}" target="_blank">
                            @if ($refund_sticker != null)
                                <img src="{{ uploaded_asset($refund_sticker) }}" height="36">
                            @else
                                <img src="{{ static_asset('assets/img/refund-sticker.jpg') }}" height="36">
                            @endif
                        </a>
                        @if($detailedProduct->refund_note_id != null)
                            <span href="javascript:void(1);" 
                                data-toggle="modal" data-target="#refund-note-modal"
                                class="border-bottom border-bottom-4 ml-2 text-secondary-base">
                                {{ translate('Refund Note') }}
                            </span>
                        @endif
                        
                        <a href="{{ route('returnpolicy') }}" class="text-blue hov-text-primary fs-14 ml-3" target="_blank">{{ translate('View Policy') }}</a>
                        
                    @else
                        <div class="text-dark fs-14 fw-400 mt-2">{{ translate('Not Applicable') }}</div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Seller Guarantees -->
        @if ($detailedProduct->digital == 1)
            @if ($detailedProduct->added_by == 'seller')
                <div class="row no-gutters mt-3">
                    <div class="col-2">
                        <div class="text-secondary fs-14 fw-400">{{ translate('Seller Guarantees') }}</div>
                    </div>
                    <div class="col-10">
                        @if ($detailedProduct->user->shop->verification_status == 1)
                            <span class="text-success fs-14 fw-700">{{ translate('Verified seller') }}</span>
                        @else
                            <span class="text-danger fs-14 fw-700">{{ translate('Non verified seller') }}</span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    @endif

    <!-- Share -->
    <div class="row no-gutters mt-4">
        <div class="col-sm-2">
            <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Share') }}</div>
        </div>
        <div class="col-sm-10">
            <div class="aiz-share"></div>
        </div>
    </div>
</div>
<!-- Add html2canvas from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.getElementById("downloadBtn").addEventListener("click", function() {
        let div = document.getElementById("capture");

        html2canvas(div).then(function(canvas) {
            // Convert to image
            let link = document.createElement("a");
            link.download = "screenshot.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
        });
    });
</script>

<script>
   function openSharePopup() {
    document.getElementById("sharePopup").style.display = "flex";
}

function closeSharePopup() {
    document.getElementById("sharePopup").style.display = "none";
}

// Close the popup when clicking outside the content
window.onclick = function(event) {
    let popup = document.getElementById("sharePopup");
    if (event.target === popup) {
        closeSharePopup();
    }
};


document.addEventListener("DOMContentLoaded", function () {
    const wishlistIcon = document.querySelector(".wishlist-icon");

    wishlistIcon.addEventListener("click", function () {
        this.classList.toggle("active"); // Toggle the active class
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const quantityInput = document.getElementById("g-detail-quantity");
    const minusBtn = document.querySelector("[data-type='minus']");
    const plusBtn = document.querySelector("[data-type='plus']");

    const minValue = parseInt(quantityInput.min) || 1;
    const maxValue = parseInt(quantityInput.max) || Infinity;

    function updateButtonStates() {
        minusBtn.disabled = parseInt(quantityInput.value) <= minValue;
        plusBtn.disabled = parseInt(quantityInput.value) >= maxValue;
    }

    minusBtn.addEventListener("click", function () {
        let currentValue = parseInt(quantityInput.value) || minValue;
        if (currentValue > minValue) {
            quantityInput.value = currentValue - 1;
            updateButtonStates();
        }
    });

    plusBtn.addEventListener("click", function () {
        let currentValue = parseInt(quantityInput.value) || minValue;
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
            updateButtonStates();
        }
    });

    quantityInput.addEventListener("input", function () {
        if (parseInt(this.value) < minValue || isNaN(this.value)) {
            this.value = minValue;
        }
        if (parseInt(this.value) > maxValue) {
            this.value = maxValue;
        }
        updateButtonStates();
    });

    updateButtonStates();
});

</script>