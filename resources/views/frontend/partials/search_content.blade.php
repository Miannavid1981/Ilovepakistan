<div class="">
    @if (sizeof($keywords) > 0)
        <h5 class=" py-1 fw-500">{{translate('Popular Matches')}}</h5>
        <ul class="list-group list-group-raw d-flex align-items-center flex-row gap-2 mb-3" style="flex-wrap: wrap;">
            @foreach ($keywords as $key => $keyword)
                <li class="list-group-item py-1 bg-light rounded-4" style=" width: fit-content !important;">
                    <a class="text-reset hov-text-primary fs-15" href="{{ route('suggestion.search', $keyword) }}" style="text-decoration: none;">{{ $keyword }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($categories) > 0)
        <h5 class=" py-1 fw-500">{{translate('Category Suggestions')}}</h5>
        <ul class="list-group list-group-raw d-flex align-items-center flex-row gap-2 mb-3" style="flex-wrap: wrap;">
            @foreach ($categories as $key => $category)
            <li class="list-group-item py-1 bg-light rounded-4" style=" width: fit-content !important;">
                    <a class="text-reset hov-text-primary fs-15" href="{{ route('products.category', $category->slug) }}" style="text-decoration: none;">{{ $category->getTranslation('name') }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($products) > 0)
        <h5 class=" py-1 fw-500">{{translate('Products')}}</h5>
        <ul class="list-group list-group-raw">
            @foreach ($products as $key => $product)
                <li class="list-group-item">
                    <a class="text-reset" href="{{ route('product', $product->slug) }}">
                        <div class="d-flex search-product align-items-center">
                            <div class="mr-3">
                                <img class="size-40px  rounded" style="object-fit: contain" src="{{ uploaded_asset($product->thumbnail_img) }}">
                            </div>
                            <div class="flex-grow-1 overflow--hidden minw-0">
                                <div class="product-name text-truncate fs-14 mb-5px">
                                    {{  $product->getTranslation('name')  }}
                                </div>
                                <div class="">
                                    @if(home_base_price($product) != home_discounted_base_price($product))
                                        <del class="opacity-60 fs-15">{{ home_base_price($product) }}</del>
                                    @endif
                                    <span class="fw-600 fs-16 text-primary">{{ home_discounted_base_price($product) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@if(get_setting('vendor_system_activation') == 1)
    <div class="">
        @if (count($shops) > 0)
            <h5 class=" py-1  fw-500">{{translate('Shops')}}</h5>
            <ul class="list-group list-group-raw">
                @foreach ($shops as $key => $shop)
                    <li class="list-group-item">
                        <a class="text-reset" href="{{ route('shop.visit', $shop->slug) }}">
                            <div class="d-flex search-product align-items-center">
                                <div class="mr-3">
                                    <img class="size-40px rounded" style="object-fit: contain" src="{{ uploaded_asset($shop->logo) }}">
                                </div>
                                <div class="flex-grow-1 overflow--hidden">
                                    <div class="product-name text-truncate fs-14 mb-5px">
                                        {{ $shop->name }}
                                    </div>
                                    <div class="opacity-60">
                                        {{ $shop->address }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
