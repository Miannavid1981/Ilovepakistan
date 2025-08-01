@foreach($newest_products as $product)
    @include('frontend.megamart.partials.product_box_1', ['product' => $product])
@endforeach
