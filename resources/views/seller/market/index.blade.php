@extends('seller.layouts.app')

@section('panel_content')

<div class="container">
        <h1>Marketplace</h1>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-12">
                <input type="text" id="product-search" class="form-control" placeholder="Search products by name">
            </div>
        </div>

        <!-- Product Cards -->
        <div id="product-cards-container">
            @include('seller.market.partials.product_cards', ['products' => $products, 'importedProductIds' => $importedProductIds])
        </div>

        <!-- Pagination -->
        <div id="pagination-container">
            @include('seller.market.partials.pagination', ['products' => $products])
        </div>

        <!-- Fixed Import Button -->
        <button id="import-products-btn" class="btn btn-primary fixed-bottom m-4" style="right: 20px;">
            Import Selected Products
        </button>
    </div>

    <script>
        let selectedProductIds = @json($importedProductIds); // Preload selected products

        $(document).ready(function () {
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