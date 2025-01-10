@php
function printCategories($categories, $prefix = '') {
    foreach ($categories as $category) {
        echo '<option value="' . $category->id . '"' . (request('category_id') == $category->id ? ' selected' : '') . '>' . $prefix . $category->getTranslation('name') . '</option>';
    }
}
function printSubCategories($categories, $prefix = '') {
    foreach ($categories as $category) {
        echo '<option value="' . $category->id . '"' . (request('category_id') == $category->id ? ' selected' : '') . '>' . $prefix . $category->getTranslation('name') . '</option>';
    }
}
@endphp
@extends('seller.layouts.app')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Products') }}</h1>
        </div>
      </div>
    </div>

    <div class="row gutters-10 justify-content-center">
        @if (addon_is_activated('seller_subscription'))
            <div class="col-md-4 mx-auto mb-3" >
                <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                  <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                      <i class="las la-upload la-2x text-white"></i>
                  </span>
                  <div class="px-3 pt-3 pb-3">
                      <div class="h4 fw-700 text-center">{{ max(0, auth()->user()->shop->product_upload_limit - auth()->user()->products()->count()) }}</div>
                      <div class="opacity-50 text-center">{{  translate('Remaining Uploads') }}</div>
                  </div>
                </div>
            </div>
        @endif

        <div class="col-md-4 mx-auto mb-3" >
            <a href="{{ route('seller.products.create')}}">
              <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                  <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                      <i class="las la-plus la-3x text-white"></i>
                  </span>
                  <div class="fs-18 text-primary">{{ translate('Add New Product') }}</div>
              </div>
            </a>
        </div>

        @if (addon_is_activated('seller_subscription'))
        @php
            $seller_package = \App\Models\SellerPackage::find(Auth::user()->shop->seller_package_id);
        @endphp
        <div class="col-md-4">
            <a href="{{ route('seller.seller_packages_list') }}" class="text-center bg-white shadow-sm hov-shadow-lg text-center d-block p-3 rounded">
                @if($seller_package != null)
                    <img src="{{ uploaded_asset($seller_package->logo) }}" height="44" class="mw-100 mx-auto">
                    <span class="d-block sub-title mb-2">{{ translate('Current Package')}}: {{ $seller_package->getTranslation('name') }}</span>
                @else
                    <i class="la la-frown-o mb-2 la-3x"></i>
                    <div class="d-block sub-title mb-2">{{ translate('No Package Found')}}</div>
                @endif
                <div class="btn btn-outline-primary py-1">{{ translate('Upgrade Package')}}</div>
            </a>
        </div>
        @endif

    </div>
        <a class="btn btn-primary" href="{{ route('seller.products', ['all' => 'true']) }}">
            <h5 class="mb-md-0 h6">{{ translate('All Products') }}</h5>
        </a>
    <div class="card">
        <form class="" id="sort_products" action="{{ route('seller.products') }}" method="GET">
            <div class="card-header row gutters-5">
                <!--<div class="col-md-2">-->
                <!--    <h5 class="mb-md-0 h6">{{ translate('All Products') }}</h5>-->
                <!--</div>-->
                    <div class="first-row w-100 d-flex flex-wrap">
                <div class="dropdown col-md-3 mb-4 mb-md-0">
                    <select class="form-control aiz-selectpicker" name="category_id" id="category" data-live-search="true">
                        <option value="">Category</option>
                        @php printCategories($categories); @endphp
                    </select>
                </div>
                <div class="dropdown col-md-3 mb-4 mb-md-0">
                    <select class="form-control aiz-selectpicker" name="subcategory" id="subcategory" data-live-search="true">
                        <option value="">SubCategory</option>
                        <!-- AJAX will populate options here -->
                    </select>
                </div>
                <div class="dropdown col-md-3 mb-4 mb-md-0">
                    <select class="form-control aiz-selectpicker" name="subcategory2" id="subcategory2" data-live-search="true">
                        <option value="">SubCategory2</option>
                        <!-- AJAX will populate options here -->
                    </select>
                </div>
                <div class="dropdown col-md-3 mb-2 mb-md-0">
                    <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id" data-live-search="true">
                        <option value="">{{ translate('Select Brand') }}</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @if ($brand->id == request('brand_id')) selected @endif>{{ $brand->getTranslation('name') }}</option>
                        @endforeach
                    </select>
                </div>
                    </div>
                    <div class="second-row w-100 d-flex mt-2">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search" @isset($search) value="{{ $search }}" @endisset placeholder="{{ translate('Search product') }}">
                    </div>
                </div>
                <div class="dropdown col-md-4 mb-2 mb-md-0" style="margin-right: -80px;">
                    <button type="submit" class="btn btn-primary">{{ translate('Search') }}</button>
                </div>
                <br>
                <div class="col-md-4 d-flex justify-content-lg-end align-items-start mt-4 mt-lg-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{translate('Bulk Action')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item confirm-alert" href="javascript:void(0)"  data-target="#bulk-delete-modal"> {{translate('Delete selection')}}</a>
                    </div>
            </div>
                    </div>
        </div>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-all">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                            <th width="30%">{{ translate('Name')}}</th>
                            {{-- <th data-breakpoints="md">{{ translate('Category')}}</th> --}}
                            <th data-breakpoints="md">{{ translate('Current Qty')}}</th>
                            <th>{{ translate('Base Price')}}</th>
                            @if(get_setting('product_approve_by_admin') == 1)
                                <th data-breakpoints="md">{{ translate('Approval')}}</th>
                            @endif
                            <th data-breakpoints="md">{{ translate('Published')}}</th>
                            <th data-breakpoints="md">{{ translate('Featured')}}</th>
                            <th data-breakpoints="md" class="text-right">{{ translate('Options')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="{{$product->id}}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('product', $product->slug) }}" target="_blank" class="text-reset">
                                        {{ $product->getTranslation('name') }}
                                    </a>
                                </td>
                                {{-- <td>
                                    @if ($product->main_category != null)
                                        {{ $product->main_category->getTranslation('name') }}
                                    @endif
                                </td> --}}
                                <td>
                                    @php
                                        $qty = 0;
                                        foreach ($product->stocks as $key => $stock) {
                                            $qty += $stock->qty;
                                        }
                                        echo $qty;
                                    @endphp
                                </td>
                                <td>{{ $product->unit_price }}</td>
                                @if(get_setting('product_approve_by_admin') == 1)
                                    <td>
                                        @if ($product->approved == 1)
                                            <span class="badge badge-inline badge-success">{{ translate('Approved')}}</span>
                                        @else
                                            <span class="badge badge-inline badge-info">{{ translate('Pending')}}</span>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->published == 1) echo "checked";?> >
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->seller_featured == 1) echo "checked";?> >
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('seller.products.edit', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')])}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="{{route('seller.products.duplicate', $product->id)}}" class="btn btn-soft-success btn-icon btn-circle btn-sm"  title="{{ translate('Duplicate') }}">
                                    <i class="las la-copy"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('seller.products.destroy', $product->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                 @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="aiz-pagination">
                        {{ $products->appends(request()->except('page'))->links() }}
                    </div>
                @endif
            </div>
        </form>
    </div>

@endsection

@section('modal')
    <!-- Delete modal -->
    @include('modals.delete_modal')
    <!-- Bulk Delete modal -->
    @include('modals.bulk_delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;                       
                });
            }
          
        });

        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('seller.products.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Featured products updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    location.reload();
                }
            });
        }

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('seller.products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                }
                else if(data == 2){
                    AIZ.plugins.notify('danger', '{{ translate('Please upgrade your package.') }}');
                    location.reload();
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    location.reload();
                }
            });
        }

        function bulk_delete() {
            var data = new FormData($('#sort_products')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('seller.products.bulk-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }

        $('#category').on('change', function() {
            var categoryId = $(this).val();
            $.ajax({
                url: '{{ route("seller.subcategories.get") }}',
                type: 'GET',
                 data: { category_id: categoryId },
                    success: function(data) {
                        var subcategorySelect = $('#subcategory');
                        subcategorySelect.empty().append('<option value="">SubCategory</option>');
                        $.each(data, function(i, subcategory) {
                            subcategorySelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                        $('.aiz-selectpicker').selectpicker('refresh'); // Refresh the AizSelectPicker to show new options
        }
    });
});

$('#subcategory').on('change', function() {
            var categoryId = $(this).val();
            $.ajax({
                url: '{{ route("seller.subcategories.get") }}',
                type: 'GET',
                 data: { category_id: categoryId },
                    success: function(data) {
                        var subcategorySelect = $('#subcategory2');
                        subcategorySelect.empty().append('<option value="">SubCategory2</option>');
                        $.each(data, function(i, subcategory) {
                            subcategorySelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                        $('.aiz-selectpicker').selectpicker('refresh'); // Refresh the AizSelectPicker to show new options
        }
    });
});

$(document).ready(function() {
    // Event listener for category change
    $('#category').change(function() {
        updateProducts();
    });

    // Similarly, add for subcategory, subcategory2, and brand_id
    $('#subcategory, #subcategory2, #brand_id').change(function() {
        updateProducts();
    });
});
    function updateProducts(page = 1) {
        $.ajax({
            url: "{{ route('seller.products') }}", // Adjust if you have a specific endpoint for AJAX
            type: 'GET',
            dataType: 'json',
            data: {
                category_id: $('#category').val(),
                subcategory: $('#subcategory').val(),
                subcategory2: $('#subcategory2').val(),
                brand_id: $('#brand_id').val(),
                search: $('#search').val(), // Include search term if necessary
                page : page
            },
            success: function(data) {
                // Call function to update table with new data
                populateTable(data);
                updatePagination(data);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    }

function populateTable(products) {
    var tbody = $('table.aiz-table > tbody');
    tbody.empty(); // Clear current table body
    // Assuming products.data is the correct array to iterate over
    $.each(products.data, function(index, product) {
        // Construct the URL for edit, duplicate, and delete actions dynamically
        var editUrl = "{{ route('seller.products.edit', '') }}/" + product.id; // Adjust based on your routing
        var duplicateUrl = "{{ route('seller.products.duplicate', '') }}/" + product.id; // Adjust based on your routing
        var deleteUrl = "{{ route('seller.products.destroy', '') }}/" + product.id; // Adjust based on your routing

        var row = $('<tr>').append(
            $('<td>').addClass('footable-first-visible').css('display', 'table-cell').append(
                $('<div>').addClass('form-group d-inline-block').append(
                    $('<label>').addClass('aiz-checkbox').append(
                        $('<input>').attr({
                            type: 'checkbox',
                            class: 'check-one',
                            name: 'id[]',
                            value: product.id
                        }),
                        $('<span>').addClass('aiz-square-check')
                    )
                )
            ),
            $('<td>').css('display', 'table-cell').append(
                $('<a>').attr({
                    href: product.slug, // Assuming 'slug' is the correct URL
                    target: '_blank',
                    class: 'text-reset'
                }).text(product.name)
            ),
            $('<td>').css('display', 'table-cell').text(product.qty),
            $('<td>').css('display', 'table-cell').text(product.unit_price),
            $('<td>').css('display', 'table-cell').append(
                $('<label>').addClass('aiz-switch aiz-switch-success mb-0').append(
                    $('<input>').attr({
                        onchange: 'update_published(this)',
                        value: product.id,
                        type: 'checkbox',
                        checked: product.published // Assumes 'published' is a boolean
                    }),
                    $('<span>').addClass('slider round')
                )
            ),
            $('<td>').css('display', 'table-cell').append(
                $('<label>').addClass('aiz-switch aiz-switch-success mb-0').append(
                    $('<input>').attr({
                        onchange: 'update_featured(this)',
                        value: product.id,
                        type: 'checkbox',
                        checked: product.featured // Assumes 'featured' is a boolean
                    }),
                    $('<span>').addClass('slider round')
                )
            ),
            $('<td>').addClass('text-right footable-last-visible').css('display', 'table-cell').append(
                $('<a>').addClass('btn btn-soft-info btn-icon btn-circle btn-sm').attr({
                    href: 'https://allaaddin.com/seller/product/' + product.id + '/edit?lang=en', // Adjust the URL as needed
                    title: 'Edit'
                }).append($('<i>').addClass('las la-edit')),
                $('<a>').addClass('btn btn-soft-success btn-icon btn-circle btn-sm').attr({
                    href: 'https://allaaddin.com/seller/products/duplicate/' + product.id, // Adjust the URL as needed
                    title: 'Duplicate'
                }).append($('<i>').addClass('las la-copy')),
                $('<a>').addClass('btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete').attr({
                    href: '#',
                    'data-href': 'https://allaaddin.com/seller/products/destroy/' + product.id, // Adjust the URL as needed
                    title: 'Delete'
                }).append($('<i>').addClass('las la-trash'))
            )
        );

        tbody.append(row);
    });
}

function updatePagination(paginationData) {
    var $paginationUl = $('.pagination');
    $paginationUl.empty(); 

    paginationData.links.forEach(function(link) {
        var $li = $('<li>').addClass('page-item');
        if (link.active) $li.addClass('active');
        if (!link.url) $li.addClass('disabled');

        var $a = $('<a>').addClass('page-link').attr('href', link.url ? link.url : '#').html(link.label);

        
        if (link.url) {
            $a.on('click', function(e) {
                e.preventDefault(); 
                var pageQuery = new URL(link.url).searchParams.get('page');
                updateProducts(pageQuery); 
            });
        }

        $li.append($a);
        $paginationUl.append($li);
    });
}




    </script>
@endsection
