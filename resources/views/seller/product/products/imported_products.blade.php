@extends('seller.layouts.app')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Imported Products') }}</h1>
        </div>
      </div>
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
                            <th data-breakpoints="md">{{ translate('Category')}}</th>
                            
                            <th>{{ translate('Profit Per Quantity')}}</th>
                            <th data-breakpoints="md" class="text-right">{{ translate('Options')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($product_ids as $key => $imported_product)

                        @php
                            $product = \App\Models\Product::find($imported_product->product_id);
                        
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

                                    <div class="d-flex align-items-center ">
                                        <div class="w-40px h-40px ">
                                            <img src="{{ !empty($product->thumbnail) ? uploaded_asset($product->thumbnail) : static_asset('assets/img/avatar-place.png') }}" class="w-100 h-100 object-cover rounded-3 ">
                                        </div>
                                        <div class="ml-2">
                                            
                                            
                                            <a href="{{ route('product.skin_url', [$product->slug, $imported_product->encrypted_hash]) }}" target="_blank" class="text-reset">
                                                {{ $product->getTranslation('name') }}
                                            </a>
                                        </div>
                                       
                                        
                                    </div>

                                    
                                </td>
                                <td>
                                    @if ($product->main_category != null)
                                    <span class="badge badge-inline badge-info">{{ $product->main_category->getTranslation('name') }}</span>
                                    @endif
                                </td>
                               
                                <td>{{ single_price($seller_profit)  }}</td>
                                
                                
                                <td class="text-right">
                               
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('seller.imported_products.destroy', $imported_product->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $product_ids->links() }}
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
