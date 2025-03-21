@extends('seller.layouts.app')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Track Imports for') }}</h1>
            <div class="d-flex align-items-center ">

                @php
                    $out_seller_id =  $product->user_id ?? null;
                    $out_seller_map = \App\Models\ProductSellerMap::where('product_id', $product->id)->where('seller_id',  $out_seller_id )->where('source_seller_id', $out_seller_id  )->first();
                    $out_encrypted_skin = $out_seller_map->encrypted_hash ?? '';
      
                    $product_url = url('/product/' . $product->slug . '/' . $out_encrypted_skin);
                @endphp
                
                <div class="w-40px h-40px ">
                    <img src="{{ !empty($product->thumbnail) ? uploaded_asset($product->thumbnail) : static_asset('assets/img/avatar-place.png') }}" class="w-100 h-100 object-cover rounded-3 ">
                </div>
                <div class="ml-2">
                    
                    
                    <a href="{{ $product_url }}" target="_blank" class="text-reset">
                        {{ $product->getTranslation('name') }}
                    </a>
                    <br>
                    <b>SKIN: </b><span>{{ $out_seller_map->encrypted_hash }}</span>
                </div>
               
                
            </div>
        </div>
      </div>
    </div>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Imports') }}</h5>
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
                            
                            <th>{{ translate('Importer')}}</th>
                            {{-- <th data-breakpoints="md" class="text-right">{{ translate('Options')}}</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($product_ids as $key => $imported_product)

                            @php
                                $product = \App\Models\Product::find($imported_product->product_id);

                                $seller = \App\Models\User::find($imported_product->seller_id);
                            

                                $encrypted_skin = $imported_product->encrypted_hash ?? '';
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

                                    <div class="d-flex align-items-center ">
                                        <div class="w-40px h-40px ">
                                            <img src="{{ !empty($product->thumbnail) ? uploaded_asset($product->thumbnail) : static_asset('assets/img/avatar-place.png') }}" class="w-100 h-100 object-cover rounded-3 ">
                                        </div>
                                        <div class="ml-2">
                                            
                                            
                                            <a href="{{ $product_url }}" target="_blank" class="text-reset">
                                                {{ $product->getTranslation('name') }}
                                            </a>
                                            <br>
                                            <b>SKIN: </b><span>{{ $imported_product->encrypted_hash }}</span>
                                        </div>
                                       
                                        
                                    </div>

                                    
                                </td>
                                <td>
                                    @if ($product->main_category != null)
                                    <span class="badge badge-inline badge-info">{{ $product->main_category->getTranslation('name') }}</span>
                                    @endif
                                </td>
                               
                                <td>
                                    <div class="d-flex align-items-center ">
                                        <div class="w-40px h-40px ">
                                            <img src="{{ !empty($seller->avatar_original) ? uploaded_asset($seller->avatar_original) : static_asset('assets/img/avatar-place.png') }}" class="w-100 h-100 object-cover rounded-3 ">
                                        </div>
                                        <div class="ml-2">
                                            
                                            
                                            <a href="" target="_blank" class="text-reset">
                                                {{ $seller->name }}
                                            </a>
                                        </div>
                                       
                                        
                                    </div>
                                </td>
                                
                                
                                {{-- <td class="text-right">
                               
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('seller.imported_products.destroy', $imported_product->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                                </td> --}}
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
