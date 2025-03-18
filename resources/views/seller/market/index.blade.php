@extends('seller.layouts.app')

@section('panel_content')
<style>
    #import-products-btn {
        position: fixed;
        bottom: 0;
        right: 0;
        width: 100px

    }
    </style>

    <h1>Marketplace</h1>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <input type="text" id="product-search" class="form-control " style="border-radius: 30px; background: #eee" placeholder="Search products by name">
        </div>
    </div>

    <!-- Product Cards -->
    <div class="container" id="product-cards-container">
        @include('seller.market.partials.product_cards', ['products' => $products, 'importedProductIds' => $importedProductIds])
    </div>

    <!-- Pagination -->
    <div class="container" id="pagination-container">
        @include('seller.market.partials.pagination', ['products' => $products])
    </div>

    <!-- Fixed Import Button -->
    <button id="import-products-btn" class="m-4 rounded-circle p-0 border-0" style="width: 80px; height:80px; ">
        <img src="https://static.vecteezy.com/system/resources/previews/017/460/179/non_2x/add-media-button-icon-isolated-on-a-square-background-vector.jpg"  class="w-100 h-100 object-cover rounded-circle">
    </button>


@endsection

@section('script')
    <script>
        // Preload selected products

        $(document).ready(function () {

            let selectedProductIds = @json($importedProductIds);
            // Handle search
            $('#product-search').on('keyup', function () {
                const search = $(this).val();
                fetchProducts(1, search);
            });

            // Handle pagination
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                fetchProducts(page, $('#product-search').val());
            });

            // Handle product selection
            $(document).on('change', '.product-checkbox', function () {
                const productId = $(this).val();
                if ($(this).is(':checked')) {
                    if (!selectedProductIds.includes(productId)) selectedProductIds.push(productId);
                } else {
                    selectedProductIds = selectedProductIds.filter(id => id != productId);
                }
            });
         
            // Import products
            $('#import-products-btn').on('click', function () {
                $.ajax({
                    url: "{{ route('seller.imported.products.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_ids: selectedProductIds
                    },
                    success: function (response) {
                        alert(response.message);
                    }
                });
            });

            // Fetch products function
            function fetchProducts(page, search = '') {
                $.ajax({
                    url: "{{ route('seller.market') }}?page=" + page + "&search=" + search,
                    success: function (data) {
                        $('#product-cards-container').html(data.html);
                        $('#pagination-container').html(data.pagination);

                        // Re-check already selected products
                        $('.product-checkbox').each(function () {
                            if (selectedProductIds.includes($(this).val())) {
                                $(this).prop('checked', true);
                            }
                        });
                    }
                });
            }
        });
    </script>
    @endsection