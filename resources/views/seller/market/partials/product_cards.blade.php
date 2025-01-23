<div class="row">
    @foreach ($products as $product)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Price: ${{ number_format($product->price, 2) }}</p>
                    <input type="checkbox" 
                           name="product_ids[]" 
                           value="{{ $product->id }}" 
                           class="product-checkbox"
                           {{ in_array($product->id, $importedProductIds) ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    @endforeach
</div>
