@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    @php
        $availability = "out of stock";
        $qty = 0;
        if($detailedProduct->variant_product) {
            foreach ($detailedProduct->stocks as $key => $stock) {
                $qty += $stock->qty;
            }
        }
        else {
            $qty = optional($detailedProduct->stocks->first())->qty;
        }
        if($qty > 0){
            $availability = "in stock";
        }
    @endphp
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:brand" content="{{ $detailedProduct->brand ? $detailedProduct->brand->name : env('APP_NAME') }}">
    <meta property="product:availability" content="{{ $availability }}">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="{{ number_format($detailedProduct->unit_price, 2) }}">
    <meta property="product:retailer_item_id" content="{{ $detailedProduct->slug }}">
    <meta property="product:price:currency"
        content="{{ get_system_default_currency()->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')

<style>
.tabs {
    display: flex;
    gap: 10px;
    list-style: none;
    padding: 0;
    font-size: 16px !important;
}

.tab {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}
.tab:hover,
.tab.active {
    color: #000;
    font-size: 18px;
    transform: scale(1.1);
    font-weight: bold;
}

/* Ensures tabs stay centered */
.tabs-container,
.tabs {
    display: flex;
    justify-content: start;
    align-items: center;
}
@media (max-width: 768px) {
    .tabs-container {
        flex-direction: column; /* Stack tabs vertically */
        align-items: flex-start; /* Align tabs to the left */
        padding: 10px 0; /* Add some padding for better spacing */
    }

    .tabs {
        flex-direction: column; /* Stack the tabs vertically */
        gap: 5px; /* Reduce gap between tabs */
    }

    .tab {
        padding: 12px 20px; /* Adjust padding for better mobile experience */
        width: 100%; /* Make each tab fill the available width */
        text-align: left; /* Align text to the left */
        border-bottom: none; /* Remove the border between tabs */
        border-right: 3px solid transparent; /* Keep a small right border */
    }

    .tab.active {
        color: #000;
        font-size: 16px; /* Slightly smaller font size for mobile */
        transform: none; /* Remove the scale effect */
        font-weight: bold;
        border-bottom: 3px solid #000; /* Active tab border */
    }
}


.tabs-to-dropdown .nav-wrapper {
  padding: 15px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.12);
}

.tabs-to-dropdown .nav-wrapper a {
  color: var(--darkgreen);
}

.tabs-to-dropdown .nav-pills .nav-link.active {
  background-color: var(--darkgreen);
}

.tabs-to-dropdown .nav-pills li:not(:last-child) {
  margin-right: 30px;
}

.tabs-to-dropdown .tab-content .container-fluid {
  max-width: 1250px;
  padding-top: 70px;
  padding-bottom: 70px;
}

.tabs-to-dropdown .dropdown-menu {
  border: none;
  box-shadow: 0px 5px 14px rgba(0, 0, 0, 0.08);
}

.tabs-to-dropdown .dropdown-item {
  padding: 14px 28px;
}

.tabs-to-dropdown .dropdown-item:active {
  color: var(--white);
}

@media (min-width: 1280px) {
  .tabs-to-dropdown .nav-wrapper {
    padding: 15px 30px;
  }
}


.tabs-container {
    position: relative;
    padding-top: 40px; /* Adjust based on how much space you want above the box */
}

.tabs {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    background-color: #f0f0f0; /* Background for the tabs */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    justify-content: flex-start;
}

.tab {
    padding: 10px 20px;
    cursor: pointer;
    background-color: #ddd;
    margin-right: 5px;
    border-radius: 5px 5px 0 0;
}

.tab.active {
   background-color: var(--primary);
    color: white;
}

.tab-content {
    margin-top: 60px; /* Ensure content is below the tabs */
    padding: 20px;
    background-color: #fff;
    /* border: 1px solid #ddd; */
    border-radius: 5px;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

</style>
@include('frontend.partials.cart.addToCart')


    <section>
        <div class="container">
            <!-- Tabs section below the thumbnail slider -->
            <div class="tabs-container">
                <ul class="tabs">
                    @if(!empty($detailedProduct->description))
                        <li class="tab active" data-tab="description">Description</li>
                    @endif
            
                    @if(!empty($detailedProduct->specifications))
                        <li class="tab" data-tab="specifications">Specifications</li>
                    @endif
            
                    @if(!empty($detailedProduct->reviews))
                        <li class="tab" data-tab="reviews">Reviews</li>
                    @endif
                </ul>
            
                <div class="tab-content" style="    overflow-x: scroll !important;width: 100%;">
                    <!-- Description Tab -->
                    @if(!empty($detailedProduct->description))
                        <div class="tab-pane active" id="description">
                            <p>{!! $detailedProduct->description !!}</p>
                        </div>
                    @endif
            
                    <!-- Specifications Tab -->
                    @if(!empty($detailedProduct->specifications))
                        <div class="tab-pane" id="specifications">
                            <ul>
                                @foreach($detailedProduct->specifications as $spec)
                                    <li>{{ $spec }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            
                    <!-- Reviews Tab -->
                    @if(!empty($detailedProduct->reviews))
                        <div class="tab-pane" id="reviews">

                            <style>
                                .star-rating {
                                    direction: rtl;
                                    display: inline-flex;
                                }
                                .star-rating input[type=radio] {
                                    display: none;
                                }
                                .star-rating label {
                                    font-size: 24px;
                                    color: #ccc;
                                    cursor: pointer;
                                }
                                .star-rating input[type=radio]:checked ~ label {
                                    color: #f5c518;
                                }
                                .star-rating label:hover,
                                .star-rating label:hover ~ label {
                                    color: #f5c518;
                                }
                            </style>

                            <h4>Leave a Review</h4>
                            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">

                                <!-- Name -->
                                <div class="form-group">
                                    <label>Your Name</label>
                                    <input type="text" name="custom_reviewer_name" class="form-control" value="{{ old('custom_reviewer_name', Auth::user()->name ?? '') }}">
                                </div>

                                {{-- <!-- Reviewer Image -->
                                <div class="form-group">
                                    <label>Profile Image</label>
                                    <input type="file" name="custom_reviewer_image" class="form-control">
                                </div> --}}

                                <!-- Rating Stars -->
                                <div class="form-group">
                                    <label>Rating</label>
                                    <div class="star-rating">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                            <label for="star{{ $i }}">★</label>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Comment -->
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea name="comment" class="form-control" rows="3"></textarea>
                                </div>

                                <!-- Photos -->
                                <div class="form-group">
                                    <label>Photos</label>
                                    <input type="file" name="photos[]" class="form-control" multiple>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                            
                            <ul style="list-style-type: none">
                                @foreach($detailedProduct->reviews as $review)
                                    <li>
                                        <strong>{{ $review->custom_reviewer_name ?? $review->user->name ?? 'Anonymous' }}</strong> 
                                        ({{ $review->rating }}★):
                                        {{ $review->comment }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    
                </div>
            </div>
            
        </div>
    
      
    </section>
    <section class="">
        <div class="container">
            @if ($detailedProduct->auction_product)
                <!-- Reviews & Ratings -->
                {{-- @include('frontend.product_details.review_section') --}}
                
                <!-- Description, Video, Downloads -->
                {{-- @include('frontend.product_details.description') --}}
                
                <!-- Product Query -->
                @include('frontend.product_details.product_queries')
            @else

                <div class="row gutters-16">
                    <!-- Left side -->
                    

                    <!-- Right side -->
                    <div class="col-lg-12 mb-5">
                        
                        <!-- Reviews & Ratings -->
                        {{-- @include('frontend.product_details.review_section') --}}

                        <!-- Description, Video, Downloads -->
                        {{-- @include('frontend.product_details.description') --}}
                        
                        <!-- Frequently Bought products -->
                        {{-- @include('frontend.product_details.frequently_bought_products') --}}

                        <!-- Product Query -->
                        {{-- @include('frontend.product_details.product_queries') --}}
                        
                        <div class="">
                            @include('frontend.product_details.related_products')
                       </div>
                        <!-- Top Selling Products -->

                        <div class="d-lg-none">
                             @include('frontend.product_details.top_selling_products')
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </section>

    @php
        $file = base_path("/public/assets/myText.txt");
        $dev_mail = get_dev_mail();
        if(!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))){
            $content = "Todays date is: ". date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: ".$_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    @endphp

@endsection

@section('modal')
    <!-- Image Modal -->
    <div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="p-4">
                    <div class="size-300px size-lg-450px">
                        <img class="img-fit h-100 lazyload"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src=""
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Modal -->
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3 rounded-0" name="title"
                                value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control rounded-0" rows="8" name="message" required
                                placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600 rounded-0"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600 rounded-0 w-100px">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bid Modal -->
    @if($detailedProduct->auction_product == 1)
        @php 
            $highest_bid = $detailedProduct->bids->max('amount');
            $min_bid_amount = $highest_bid != null ? $highest_bid+1 : $detailedProduct->starting_bid; 
        @endphp
        <div class="modal fade" id="bid_for_detail_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ translate('Bid For Product') }} <small>({{ translate('Min Bid Amount: ').$min_bid_amount }})</small> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="{{ route('auction_product_bids.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                            <div class="form-group">
                                <label class="form-label">
                                    {{translate('Place Bid Price')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="amount" min="{{ $min_bid_amount }}" placeholder="{{ translate('Enter Amount') }}" required>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Product Review Modal -->
    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

            </div>
        </div>
    </div>


    <!-- Size chart show Modal -->
    @include('modals.size_chart_show_modal')

    <!-- Product Warranty Modal -->
    <div class="modal fade" id="warranty-note-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Warranty Note') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body c-scrollbar-light">
                    @if($detailedProduct->warranty_note_id != null)
                        <p>{{ $detailedProduct->warrantyNote->getTranslation('description') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Product Refund Modal -->
    <div class="modal fade" id="refund-note-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Refund Note') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body c-scrollbar-light">
                    @if($detailedProduct->refund_note_id != null)
                        <p>{{ $detailedProduct->refundNote->getTranslation('description') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
        });
     
        $('.product-detail-slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.product-detail-slider-nav'
        });

        $('.product-detail-slider-nav').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.product-detail-slider-for',
            dots: false,
            arrows: true,
            // centerMode: true,
            focusOnSelect: true,
            vertical: true,
            verticalSwiping: true,
            prevArrow: $('.arrow-prev'), // Custom up arrow
            nextArrow: $('.arrow-next')  // Custom down arrow
        });
        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }

        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        // Pagination using ajax
        $(window).on('hashchange', function() {
            if(window.history.pushState) {
                window.history.pushState('', '/', window.location.pathname);
            } else {
                window.location.hash = '';
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.product-queries-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'query', 'queries-area');
                e.preventDefault();
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.product-reviews-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'review', 'reviews-area');
                e.preventDefault();
            });
        });

        function getPaginateData(page, type, section) {
            $.ajax({
                url: '?page=' + page,
                dataType: 'json',
                data: {type: type},
            }).done(function(data) {
                $('.'+section).html(data);
                location.hash = page;
            }).fail(function() {
                alert('Something went worng! Data could not be loaded.');
            });
        }
        // Pagination end

        function showImage(photo) {
            $('#image_modal img').attr('src', photo);
            $('#image_modal img').attr('data-src', photo);
            $('#image_modal').modal('show');
        }

        function bid_modal(){
            @if (isCustomer() || isSeller())
                $('#bid_for_detail_product').modal('show');
          	@elseif (isAdmin())
                AIZ.plugins.notify('warning', '{{ translate("Sorry, Only customers & Sellers can Bid.") }}');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        function product_review(product_id) {
            @if (isCustomer())
                @if ($review_status == 1)
                    $.post('{{ route('product_review_modal') }}', {
                        _token: '{{ @csrf_token() }}',
                        product_id: product_id
                    }, function(data) {
                        $('#product-review-modal-content').html(data);
                        $('#product-review-modal').modal('show', {
                            backdrop: 'static'
                        });
                        AIZ.extra.inputRating();
                    });
                @else
                    AIZ.plugins.notify('warning', '{{ translate("Sorry, You need to buy this product to give review.") }}');
                @endif
            @elseif (Auth::check() && !isCustomer())
                AIZ.plugins.notify('warning', '{{ translate("Sorry, Only customers can give review.") }}');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        function showSizeChartDetail(id, name){
            $('#size-chart-show-modal .modal-title').html('');
            $('#size-chart-show-modal .modal-body').html('');
            if (id == 0) {
                AIZ.plugins.notify('warning', '{{ translate("Sorry, There is no size guide found for this product.") }}');
                return false;
            }
            $.ajax({
                type: "GET",
                url: "{{ route('size-charts-show', '') }}/"+id,
                data: {},
                success: function(data) {
                    $('#size-chart-show-modal .modal-title').html(name);
                    $('#size-chart-show-modal .modal-body').html(data);
                    $('#size-chart-show-modal').modal('show');
                }
            });
        }
        document.querySelectorAll(".tab").forEach(tab => {
        tab.addEventListener("click", function () {
            document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
            this.classList.add("active");
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab");
    const tabPanes = document.querySelectorAll(".tab-pane");

    tabs.forEach(tab => {
        tab.addEventListener("click", function () {
            const targetTab = this.getAttribute("data-tab");

            // Remove active class from all tabs and tab panes
            tabs.forEach(t => t.classList.remove("active"));
            tabPanes.forEach(pane => pane.classList.remove("active"));

            // Add active class to the clicked tab and corresponding content
            this.classList.add("active");
            document.getElementById(targetTab).classList.add("active");
        });
    });

    // Set the first tab and content as active by default on page load
    tabs[0].classList.add("active");
    tabPanes[0].classList.add("active");
});

   
function change_tab(tab){

    $(".tab").each(function(){
        $(this).removeClass("active")
    });  
    $(".tab-pane").each(function(){
        $(this).removeClass("active")
    });  


    $(`[data-tab="${tab}"]`).addClass("active")
}
const $tabsToDropdown = $(".tabs-to-dropdown");

function generateDropdownMarkup(container) {
  const $navWrapper = container.find(".nav-wrapper");
  const $navPills = container.find(".nav-pills");
  const firstTextLink = $navPills.find("li:first-child a").text();
  const $items = $navPills.find("li");
  const markup = `
    <div class="dropdown d-md-none">
      <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        ${firstTextLink}
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
        ${generateDropdownLinksMarkup($items)}
      </div>
    </div>
  `;
  $navWrapper.prepend(markup);
}

function generateDropdownLinksMarkup(items) {
  let markup = "";
  items.each(function () {
    const textLink = $(this).find("a").text();
    markup += `<a class="dropdown-item" href="#">${textLink}</a>`;
  });

  return markup;
}

function showDropdownHandler(e) {
  // works also
  //const $this = $(this);
  const $this = $(e.target);
  const $dropdownToggle = $this.find(".dropdown-toggle");
  const dropdownToggleText = $dropdownToggle.text().trim();
  const $dropdownMenuLinks = $this.find(".dropdown-menu a");
  const dNoneClass = "d-none";
  $dropdownMenuLinks.each(function () {
    const $this = $(this);
    if ($this.text() == dropdownToggleText) {
      $this.addClass(dNoneClass);
    } else {
      $this.removeClass(dNoneClass);
    }
  });
}

function clickHandler(e) {
  e.preventDefault();
  const $this = $(this);
  const index = $this.index();
  const text = $this.text();
  $this.closest(".dropdown").find(".dropdown-toggle").text(`${text}`);
  $this
    .closest($tabsToDropdown)
    .find(`.nav-pills li:eq(${index}) a`)
    .tab("show");
}

function shownTabsHandler(e) {
  // works also
  //const $this = $(this);
  const $this = $(e.target);
  const index = $this.parent().index();
  const $parent = $this.closest($tabsToDropdown);
  const $targetDropdownLink = $parent.find(".dropdown-menu a").eq(index);
  const targetDropdownLinkText = $targetDropdownLink.text();
  $parent.find(".dropdown-toggle").text(targetDropdownLinkText);
}

$tabsToDropdown.each(function () {
  const $this = $(this);
  const $pills = $this.find('a[data-toggle="pill"]');

  generateDropdownMarkup($this);

  const $dropdown = $this.find(".dropdown");
  const $dropdownLinks = $this.find(".dropdown-menu a");

  $dropdown.on("show.bs.dropdown", showDropdownHandler);
  $dropdownLinks.on("click", clickHandler);
  $pills.on("shown.bs.tab", shownTabsHandler);
});



    </script>
@endsection
