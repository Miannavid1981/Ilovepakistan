@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = $category->meta_title;
        $meta_description = $category->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = get_single_brand($brand_id)->meta_title;
        $meta_description = get_single_brand($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')

<style> 

.size-circle{
    gap: 10px;
}
.size {
    width: 40px;
    height: 40px;
    aspect-ratio: 1 / 1;
    border-radius: 50%;
    background: #ffffff;
    display: flex;
    border: 1px solid #000;
    justify-content: center;
    align-items: center;
}
    #collapse_1 .list-group {
    border: none;
}

li.list-group-item.text-dark {
 border: none;
 padding: 8px 0px 8px 0px;
}

.range_container {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .sliders_control {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            position: absolute;
            background: transparent;
            pointer-events: none;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            background: #000;
            border: 2px solid #000;
            border-radius: 50%;
            pointer-events: all;
            cursor: pointer;
        }
        .slider-tooltip {
            position: absolute;
            top: -30px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            text-align: center;
            white-space: nowrap;
            transform: translateX(-50%);
        }
        .scale {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12px;
            color: #555;
        }

</style>
<section class="text-center d-flex justify-content-center align-items-center" style="height: 200px; background-color: #E8E8E8;">
    <div class="container text-center">
        <!-- Shop Page Title -->
        <h2 class="text-dark mb-4">Shop Page</h2>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light justify-content-center w-100">         
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav justify-content-center w-100">
                    <li class="nav-item"><a class="nav-link" href="#">T-Shirt</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Dress</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Top</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Swimwear</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Shirt</a></li>
                </ul>
            </div>
        </nav>
    </div>
</section>





    <section class="mb-4 pt-4">
        <div class="container sm-px-0 pt-2">
            <form class="" id="search-form" action="" method="GET">
                <div class="row">

                    <aside class="col-md-3">
                        <h5>Products Type</h5>
                        <div class="bg-white  mb-3">
                            {{-- <div class="fs-16 fw-700 p-3">
                                <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                    {{ translate('Categories') }}
                                </a>
                            </div> --}}
                            <div class="collapse show" id="collapse_1">
                                <ul class="list-group mb-0">
                                    @if (!isset($category_id))
                                        @foreach ($categories as $category)
                                            <li class="list-group-item text-dark">
                                                <a class="text-reset fs-14 hov-text-primary" href="{{ route('products.category', $category->slug) }}">
                                                    {{ $category->getTranslation('name') }} ({{ $category->products_count }})
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item">
                                            <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('search') }}">
                                                <i class="las la-angle-left"></i>
                                                {{ translate('All Categories') }}
                                            </a>
                                        </li>
                                        
                                        @if ($category->parent_id != 0)
                                            <li class="list-group-item">
                                                <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('products.category', get_single_category($category->parent_id)->slug) }}">
                                                    <i class="las la-angle-left"></i>
                                                    {{ get_single_category($category->parent_id)->getTranslation('name') }}
                                                </a>
                                            </li>
                                        @endif
                            
                                        <li class="list-group-item">
                                            <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('products.category', $category->slug) }}">
                                                <i class="las la-angle-left"></i>
                                                {{ $category->getTranslation('name') }}
                                            </a>
                                        </li>
                                        
                                        @foreach ($category->childrenCategories as $key => $immediate_children_category)
                                            <li class="list-group-item ml-4">
                                                <a class="text-reset fs-14 hov-text-primary" href="{{ route('products.category', $immediate_children_category->slug) }}">
                                                    {{ $immediate_children_category->getTranslation('name') }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            
                        </div>
                        
                        <h5>Size</h5>
                        <div class="d-flex size-circle">
                            <div class="size">S</div>
                            <div class="size m">M</div>
                            <div class="size l">L</div>
                            <div class="size xl">XL</div>
                        </div>
                        
                    
                        <h5 class="mt-3">Price Range</h5>
                        <p>Price Range</p>
                        <div class="range_container">
                            <div class="sliders_control">
                                <div id="fromSliderTooltip" class="slider-tooltip">0</div>
                                <input id="fromSlider" type="range" value="0" min="0" max="100000" step="500">
                                <div id="toSliderTooltip" class="slider-tooltip">100000</div>
                                <input id="toSlider" type="range" value="100000" min="0" max="100000" step="500">
                            </div>
                            <div id="scale" class="scale"></div>
                        </div>
                    
                     <!-- Brands Section -->
<h5 class="mt-3">Brands</h5>
<div class="bg-white  mb-3">
    <ul class="list-unstyled ">
        <!-- Example Brand Options (Replace with actual brand data) -->
        <li class="mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="brand1" id="brand_1">
                <label class="form-check-label" for="brand_1">
                    Brand 1
                </label>
            </div>
        </li>
        <li class="mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="brand2" id="brand_2">
                <label class="form-check-label" for="brand_2">
                    Brand 2
                </label>
            </div>
        </li>
        <li class="mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="brand3" id="brand_3">
                <label class="form-check-label" for="brand_3">
                    Brand 3
                </label>
            </div>
        </li>
        <!-- Add more brands as needed -->
    </ul>
</div>

                    </aside>
                    
                    {{-- <div class="col-xl-3">
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
                                <div class="bg-white border mb-3">
                                    <div class="fs-16 fw-700 p-3">
                                        <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                            {{ translate('Categories')}}
                                        </a>
                                    </div>
                                    <div class="collapse show" id="collapse_1">
                                        <ul class="p-3 mb-0 list-unstyled">
                                            @if (!isset($category_id))
                                                @foreach ($categories as $category)
                                                    <li class="mb-3 text-dark">
                                                        <a class="text-reset fs-14 hov-text-primary" href="{{ route('products.category', $category->slug) }}">
                                                            {{ $category->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="mb-3">
                                                    <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('search') }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ translate('All Categories')}}
                                                    </a>
                                                </li>
                                                
                                                @if ($category->parent_id != 0)
                                                    <li class="mb-3">
                                                        <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('products.category', get_single_category($category->parent_id)->slug) }}">
                                                            <i class="las la-angle-left"></i>
                                                            {{ get_single_category($category->parent_id)->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="mb-3">
                                                    <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('products.category', $category->slug) }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ $category->getTranslation('name') }}
                                                    </a>
                                                </li>
                                                @foreach ($category->childrenCategories as $key => $immediate_children_category)
                                                    <li class="ml-4 mb-3">
                                                        <a class="text-reset fs-14 hov-text-primary" href="{{ route('products.category', $immediate_children_category->slug) }}">
                                                            {{ $immediate_children_category->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <!-- Price range -->
                                <div class="bg-white border mb-3">
                                    <div class="fs-16 fw-700 p-3">
                                        {{ translate('Price range')}}
                                    </div>
                                    <div class="p-3 mr-3">
                                        @php
                                            $product_count = get_products_count()
                                        @endphp
                                        <div class="aiz-range-slider">
                                            <div
                                                id="input-slider-range"
                                                data-range-value-min="@if($product_count < 1) 0 @else {{ get_product_min_unit_price() }} @endif"
                                                data-range-value-max="@if($product_count < 1) 0 @else {{ get_product_max_unit_price() }} @endif"
                                            ></div>

                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                                        @if (isset($min_price))
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
                                                        @if (isset($max_price))
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
                                
                                <!-- Attributes -->
                                @foreach ($attributes as $attribute)
                                    <div class="bg-white border mb-3">
                                        <div class="fs-16 fw-700 p-3">
                                            <a href="#" class="dropdown-toggle text-dark filter-section collapsed d-flex align-items-center justify-content-between" 
                                                data-toggle="collapse" data-target="#collapse_{{ str_replace(' ', '_', $attribute->name) }}" style="white-space: normal;">
                                                {{ $attribute->getTranslation('name') }}
                                            </a>
                                        </div>
                                        @php
                                            $show = '';
                                            foreach ($attribute->attribute_values as $attribute_value){
                                                if(in_array($attribute_value->value, $selected_attribute_values)){
                                                    $show = 'show';
                                                }
                                            }
                                        @endphp
                                        <div class="collapse {{ $show }}" id="collapse_{{ str_replace(' ', '_', $attribute->name) }}">
                                            <div class="p-3 aiz-checkbox-list">
                                                @foreach ($attribute->attribute_values as $attribute_value)
                                                    <label class="aiz-checkbox mb-3">
                                                        <input
                                                            type="checkbox"
                                                            name="selected_attribute_values[]"
                                                            value="{{ $attribute_value->value }}" @if (in_array($attribute_value->value, $selected_attribute_values)) checked @endif
                                                            onchange="filter()"
                                                        >
                                                        <span class="aiz-square-check"></span>
                                                        <span class="fs-14 fw-400 text-dark">{{ $attribute_value->value }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    
                                <!-- Color -->
                                @if (get_setting('color_filter_activation'))
                                    <div class="bg-white border mb-3">
                                        <div class="fs-16 fw-700 p-3">
                                            <a href="#" class="dropdown-toggle text-dark filter-section collapsed d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#collapse_color">
                                                {{ translate('Filter by color')}}
                                            </a>
                                        </div>
                                        @php
                                            $show = '';
                                            foreach ($colors as $key => $color){
                                                if(isset($selected_color) && $selected_color == $color->code){
                                                    $show = 'show';
                                                }
                                            }
                                        @endphp
                                        <div class="collapse {{ $show }}" id="collapse_color">
                                            <div class="p-3 aiz-radio-inline">
                                                @foreach ($colors as $key => $color)
                                                <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ $color->name }}">
                                                    <input
                                                        type="radio"
                                                        name="color"
                                                        value="{{ $color->code }}"
                                                        onchange="filter()"
                                                        @if(isset($selected_color) && $selected_color == $color->code) checked @endif
                                                    >
                                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                        <span class="size-30px d-inline-block rounded" style="background: {{ $color->code }};"></span>
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> --}}
                    
                    <!-- Contents -->
                    <div class="col-xl-9">
                        
                        <!-- Breadcrumb -->
                        <ul class="breadcrumb bg-transparent py-0 px-1">
                            <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                                <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                            </li>
                            @if(!isset($category_id))
                                <li class="breadcrumb-item fw-700  text-dark">
                                    "{{ translate('All Categories')}}"
                                </li>
                            @else
                                <li class="breadcrumb-item opacity-50 hov-opacity-100">
                                    <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a>
                                </li>
                            @endif
                            @if(isset($category_id))
                                <li class="text-dark fw-600 breadcrumb-item">
                                    "{{ $category->getTranslation('name') }}"
                                </li>
                            @endif
                        </ul>
                        
                        <!-- Top Filters -->
                        <div class="text-left">
                            <div class="row gutters-5 flex-wrap align-items-center">
                                <div class="col-lg col-10">
                                    <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                                        @if(isset($category_id))
                                            {{ $category->getTranslation('name') }}
                                        @elseif(isset($query))
                                            {{ translate('Search result for ') }}"{{ $query }}"
                                        @else
                                            {{ translate('All Products') }}
                                        @endif
                                    </h1>
                                    <input type="hidden" name="keyword" value="{{ $query }}">
                                </div>
                                <div class="col-2 col-lg-auto d-xl-none mb-lg-3 text-right">
                                    <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                        <i class="la la-filter la-2x"></i>
                                    </button>
                                </div>
                                {{-- <div class="col-6 col-lg-auto mb-3 w-lg-200px mr-xl-4 mr-lg-3">
                                    @if (Route::currentRouteName() != 'products.brand')
                                        <select class="form-control form-control-sm aiz-selectpicker rounded-0" data-live-search="true" name="brand" onchange="filter()">
                                            <option value="">{{ translate('Brands')}}</option>
                                            @foreach (get_all_brands() as $brand)
                                                <option value="{{ $brand->slug }}" @isset($brand_id) @if ($brand_id == $brand->id) selected @endif @endisset>{{ $brand->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div> --}}
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
        </div>
    </section>

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
     
        document.addEventListener('DOMContentLoaded', () => {
            const fromSlider = document.getElementById("fromSlider");
            const toSlider = document.getElementById("toSlider");
            const fromTooltip = document.getElementById("fromSliderTooltip");
            const toTooltip = document.getElementById("toSliderTooltip");
            const scale = document.getElementById("scale");

            function updateTooltip(slider, tooltip) {
                tooltip.textContent = "Rs. " + slider.value;
                const percent = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
                tooltip.style.left = `calc(${percent}% - 10px)`;
            }
            
            function updateSlider() {
                if (parseInt(fromSlider.value) > parseInt(toSlider.value)) {
                    fromSlider.value = toSlider.value;
                }
                updateTooltip(fromSlider, fromTooltip);
                updateTooltip(toSlider, toTooltip);
            }
            
            function createScale(min, max, step) {
                scale.innerHTML = "";
                for (let i = min; i <= max; i += step) {
                    const mark = document.createElement("div");
                    mark.textContent = "Rs. " + i;
                    mark.style.flex = "1";
                    scale.appendChild(mark);
                }
            }

            fromSlider.addEventListener("input", updateSlider);
            toSlider.addEventListener("input", updateSlider);
            
            updateSlider();
            createScale(0, 100000, 20000);
        });
    </script>
@endsection
