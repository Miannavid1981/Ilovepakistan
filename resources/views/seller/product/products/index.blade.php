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

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Products') }}</h5>
                </div>

                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{translate('Bulk Action')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item confirm-alert" href="javascript:void(0)"  data-target="#bulk-delete-modal"> {{translate('Delete selection')}}</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search" @isset($search) value="{{ $search }}" @endisset placeholder="{{ translate('Search product') }}">
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
                            <th>{{ translate('Listing Price')}}</th>
                            <th>{{ translate('Platform Fee')}}</th>
                            <th>{{ translate('Your sale')}}</th>
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
                                @php

            
                                    
                                    $item_price = discount_in_percentage($product) > 0 ? home_discounted_base_price($product, false) : home_base_price($product, false);
                                
                                    $admin_user = \App\Models\User::where('email', 'admin@bighouz.com')->first();
                                    $admin_id = $admin_user->id;

                                    $target_cat = \App\Models\Category::where("id",$product->category_id)->first();
                                        

                                    $admin_commission_type = null;
                                    $seller_commission_type = null;
                                    
                                    $admin_commission_rate = null;
                                    $seller_commission_rate = null;
                                    $brand_profit_amount = null;
                                    $seller_profit = null;
                                    $admin_profit_per_amount = null;
                                    $admin_profit_final_amount = null;
                                    $commission = 0;


                                    if($target_cat->commission == 1){
                                        $commission = 1;
                                        $admin_commission_type = $target_cat->commission_rate_type;
                                        $seller_commission_type = $target_cat->seller_commission_rate_type;

                                        $admin_commission_rate = (float) $target_cat->commision_rate;
                                        $seller_commission_rate = (float)  $target_cat->seller_commission_rate;

                                    } else {

                                        if($product->commission == 1){
                                            $commission = 1;
                                            $admin_commission_type = $product->admin_commission_type;
                                            $seller_commission_type = $product->seller_commission_type;
                                            
                                            $admin_commission_rate = (float)  $product->admin_commission_rate;
                                            $seller_commission_rate = (float)  $product->seller_commission_rate;
                                        }
                                        

                                    }
                                    
                                    
                            

                                    if($commission ) {
                                        
                                        if( !empty($admin_commission_type) && !empty($admin_commission_rate)  ){

                                            // Calculate admin profit per amount depending on the commission type (percentage or fixed amount)
                                            if ($admin_commission_type === 'percentage') {
                                                $admin_profit_per_amount = get_percentage_amount($admin_commission_rate, $item_price);
                                            } else {
                                                // If it's an amount, use it directly
                                                $admin_profit_per_amount = $admin_commission_rate;
                                            }
                                            
                                            $brand_profit_amount = $item_price - $admin_profit_per_amount;
                                    
                                            $seller_profit = 0;
                                            

                                                if( !empty($seller_commission_type) && !empty($seller_commission_rate)  ){
                                                    // Handle seller commission
                                                    if ($seller_commission_type === 'percentage') {
                                                        $seller_profit_per_amount = get_percentage_amount($seller_commission_rate, $admin_profit_per_amount);
                                                        $seller_profit = (int) ($seller_commission_rate / 100) * $admin_profit_per_amount;
                                                    } else {
                                                        // If it's a fixed amount, use the fixed value
                                                        $seller_profit_per_amount = $seller_commission_rate;
                                                        $seller_profit =  (int)  $seller_commission_rate; // Fixed amount, so no percentage calculation needed
                                                    }
                                                }
                                            
                                            
                                            // Final admin profit after subtracting seller's profit
                                            $admin_profit_final_amount = $admin_profit_per_amount - $seller_profit;
                                            
                                            // Assign final admin profit to order detail
                                        
                                            
                                            
                                            

                                        } 
                                    }


                                    $seller_id =  $product->user_id ?? null;
                                    $seller_map = \App\Models\ProductSellerMap::where('source_seller_id', $seller_id  )->where('product_id', $product->id)->first();
                                    $encrypted_skin = $seller_map->encrypted_hash ?? '';
                                    $product_url = url('/product/' . $product->slug . '/' . $encrypted_skin);
                                @endphp
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
                                    <a href="{{ $product_url }}" target="_blank" class="text-reset">
                                        {{ $product->getTranslation('name') }}
                                        <br>
                                        <b>SKIN: </b>{{ $encrypted_skin }}
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
                                <td>{{ single_price($product->unit_price) }}</td>
                                <td>@if($admin_profit_per_amount > 0)<p class="text-secondary">-{{ single_price($admin_profit_per_amount) }} <p>@endif</td>
                                <td>@if($brand_profit_amount > 0)<p class="text-success">{{ single_price($brand_profit_amount) }} </p>@endif</td>
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
                                
                                <a class="btn btn-dark fs-12 py-1 px-2  btn-sm"  href="{{route('seller.import_history', ['id'=> $product->id])}}" title="{{ translate('View') }}">
                                    Track Imports
                                </a>
                                <a class="btn btn-soft-success btn-icon btn-circle btn-sm"  href="{{ $product_url }}" target="_blank" title="{{ translate('View') }}">
                                    <i class="las la-eye"></i>
                                </a>
                                
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
                <div class="aiz-pagination">
                    {{ $products->links() }}
                </div>
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

    </script>
@endsection
