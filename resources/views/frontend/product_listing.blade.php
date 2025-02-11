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

    /* Size Circle */
    .size-circle {
        gap: 10px;
    }

    .size {
        width: 40px;
        height: 40px;
        aspect-ratio: 1 / 1;
        border-radius: 50%;
        background: #ffffff;
        display: flex;
        border: 1px solid gray;
        justify-content: center;
        align-items: center;
    }

    /* Collapse List */
    #collapse_1 .list-group {
        border: none;
    }

    li.list-group-item.text-dark {
        border: none;
        padding: 8px 0;
    }

    /* Range Slider */
            .range-slider {
        width: 300px;
        text-align: center;
        position: relative;
        .rangeValues {
            display: block;
        }
        }

    input[type="range"] {
        -webkit-appearance: none;
        border: 1px solid white;
        width: 300px;
        position: absolute;
        left: 0;
    }

    input[type="range"]::-webkit-slider-runnable-track {
        width: 300px;
        height: 5px;
        background: #ddd;
        border: none;
        border-radius: 3px;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: var(--bs-primary);
        margin-top: -4px;
        cursor: pointer;
        position: relative;
        z-index: 1;
    }

    input[type="range"]:focus {
        outline: none;
    }

    input[type="range"]:focus::-webkit-slider-runnable-track {
        background: #ccc;
    }

    /* Firefox */
    input[type="range"]::-moz-range-track {
        width: 300px;
        height: 5px;
        background: #ddd;
        border: none;
        border-radius: 3px;
    }

    input[type="range"]::-moz-range-thumb {
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: var(--bs-primary);
    }

    input[type="range"]:-moz-focusring {
        outline: 1px solid white;
        outline-offset: -1px;
    }

    /* Internet Explorer */
    input[type="range"]::-ms-track {
        width: 300px;
        height: 5px;
        background: transparent;
        border-color: transparent;
        border-width: 6px 0;
        color: transparent;
        z-index: -4;
    }

    input[type="range"]::-ms-fill-lower {
        background: #777;
        border-radius: 10px;
    }

    input[type="range"]::-ms-fill-upper {
        background: #ddd;
        border-radius: 10px;
    }

    input[type="range"]::-ms-thumb {
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #21c1ff;
    }

    input[type="range"]:focus::-ms-fill-lower {
        background: #888;
    }

    input[type="range"]:focus::-ms-fill-upper {
        background: #ccc;
    }

    /* Color Selector */
    .color-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .color-selector input {
        display: none;
    }

    .color-selector label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border: 2px solid transparent;
        border-radius: 20px;
        cursor: pointer;
        font-size: 16px;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .color-selector label:hover {
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
    }

    .color-selector input:checked + label {
        border-color: black;
    }

    .color-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: inline-block;
    }

</style>

<section class="text-center d-flex justify-content-center align-items-center position-relative" style="height: 250px; background-color: #E8E8E8;">
    @if(isset($category_id) && $category->banner)
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('{{ asset($category->banner) }}') no-repeat center center; background-size: cover; opacity: 0.3;"></div>
    @endif
    <div class="container text-center position-relative">
        <!-- Shop Page Title -->
        <h2 class="text-dark mb-4">Shop Page</h2>
        <ul class="breadcrumb bg-transparent py-0 px-1 d-flex justify-content-center align-items-center">
            <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
            </li>
            @if(!isset($category_id))
                <li class="breadcrumb-item fw-700 text-dark">
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
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light justify-content-center w-100">         
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav justify-content-center w-100">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.category', $category->slug) }}">
                                {{ $category->getTranslation('name') }}
                            </a>
                        </li>
                    @endforeach
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
                        <h5>All Categories</h5>
                        <div class="bg-white mb-3">
                            <div class="collapse show" id="collapse_1">
                                <ul class="list-group mb-0">
                                    @if (!isset($category_id))
                                        @foreach ($categories as $category)
                                            <li class="list-group-item text-dark d-flex justify-content-between align-items-center">
                                                <a class="text-reset fs-14 hov-text-primary" href="{{ route('products.category', $category->slug) }}">
                                                    {{ $category->getTranslation('name') }}
                                                </a>
                                                <span class="category-count">({{ $category->products_count }})</span>
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
                                        
                                        @foreach ($category->childrenCategories as $immediate_children_category)
                                            <li class="list-group-item d-flex justify-content-between align-items-center ml-4">
                                                <a class="text-reset fs-14 hov-text-primary" href="{{ route('products.category', $immediate_children_category->slug) }}">
                                                    {{ $immediate_children_category->getTranslation('name') }}
                                                </a>
                                                <span class="category-count">({{ $immediate_children_category->products_count }})</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        
                        <h5 class="mt-5">Size</h5>
                        <div class="d-flex size-circle mb-5">
                            <div class="size">S</div>
                            <div class="size m">M</div>
                            <div class="size l">L</div>
                            <div class="size xl">XL</div>
                        </div>
                        
                    
                        <h5 class="mt-5">Price Range</h5>
                      
                       
                        <div class="range-slider mb-5">
                        <span class="rangeValues"></span>
                        <input value="100" min="100" max="100000" step="500" type="range">
                        <input value="100000" min="100" max="100000" step="500" type="range">

                        </div>

                        <h5 class="mt-5">Colors</h5>
                            <div class="color-selector mb-5">
                                <input type="radio" id="pink" name="color" checked>
                                <label for="pink">
                                    <span class="color-dot" style="background-color: pink;"></span> Pink
                                </label>

                                <input type="radio" id="red" name="color">
                                <label for="red">
                                    <span class="color-dot" style="background-color: red;"></span> Red
                                </label>

                                <input type="radio" id="green" name="color">
                                <label for="green">
                                    <span class="color-dot" style="background-color: lightgreen;"></span> Green
                                </label>

                                <input type="radio" id="yellow" name="color">
                                <label for="yellow">
                                    <span class="color-dot" style="background-color: gold;"></span> Yellow
                                </label>

                                <input type="radio" id="purple" name="color">
                                <label for="purple">
                                    <span class="color-dot" style="background-color: purple;"></span> Purple
                                </label>

                                <input type="radio" id="black" name="color">
                                <label for="black">
                                    <span class="color-dot" style="background-color: black;"></span> Black
                                </label>

                                <input type="radio" id="white" name="color">
                                <label for="white">
                                    <span class="color-dot" style="background-color: beige;"></span> White
                                </label>
                            </div>
                    
                     <!-- Brands Section -->
                        <h5 class="mt-3">Brands</h5>
                        <div class="bg-white mb-3">
                            <ul class="list-unstyled">
                                <!-- Example Brand Options with Count -->
                                <li class="mb-2">
                                    <div class="form-check d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="checkbox" value="brand1" id="brand_1">
                                            <label class="form-check-label" for="brand_1">Brand 1</label>
                                        </div>
                                        <span class="brand-count">(10)</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="form-check d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="checkbox" value="brand2" id="brand_2">
                                            <label class="form-check-label" for="brand_2">Brand 2</label>
                                        </div>
                                        <span class="brand-count">(5)</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="form-check d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="checkbox" value="brand3" id="brand_3">
                                            <label class="form-check-label" for="brand_3">Brand 3</label>
                                        </div>
                                        <span class="brand-count">(8)</span>
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
                                    <div class="col">
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
     
        function getVals(){
  // Get slider values
  let parent = this.parentNode;
  let slides = parent.getElementsByTagName("input");
    let slide1 = parseFloat( slides[0].value );
    let slide2 = parseFloat( slides[1].value );
  // Neither slider will clip the other, so make sure we determine which is larger
  if( slide1 > slide2 ){ let tmp = slide2; slide2 = slide1; slide1 = tmp; }
  
  let displayElement = parent.getElementsByClassName("rangeValues")[0];
      displayElement.innerHTML = "Rs " + slide1 + " - Rs " + slide2;
}

window.onload = function(){
  // Initialize Sliders
  let sliderSections = document.getElementsByClassName("range-slider");
      for( let x = 0; x < sliderSections.length; x++ ){
        let sliders = sliderSections[x].getElementsByTagName("input");
        for( let y = 0; y < sliders.length; y++ ){
          if( sliders[y].type ==="range" ){
            sliders[y].oninput = getVals;
            // Manually trigger event first time to display values
            sliders[y].oninput();
          }
        }
      }
}



    </script>
@endsection
