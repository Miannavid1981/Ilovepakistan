
@php
    dd($newest_products);
@endphp
@if(count($newest_products) != 0 ) 
<div class="row gx-3">
    @foreach ($newest_products as $key => $new_product)
    <div class="col-6 col-md-4 col-lg product-custom-col position-relative has-transition hov-animate-outline">
        @php
            $seller_id =  $new_product->user_id ?? null;
            $seller_map = \App\Models\ProductSellerMap::where('product_id', $new_product->id)->where('seller_id',  $seller_id )->where('source_seller_id', $seller_id  )->first();
            $encrypted_skin = $seller_map->encrypted_hash ?? '';
            $product_url = url('/product/' . $new_product->slug . '/' . $encrypted_skin);
            $new_product->product_custom_url = $product_url;
            // dd($new_product);
            
        @endphp

        @if( $seller_id )
            @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $new_product])
        @endif
    </div>
    @endforeach
</div>
@endif
