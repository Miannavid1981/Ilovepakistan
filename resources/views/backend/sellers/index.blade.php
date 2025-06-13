@extends('backend.layouts.app')

@section('content')

@php
    $route = Route::currentRouteName() == 'sellers.index' ? 'all_seller_route' : 'seller_rating_followers';
@endphp

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{ $route == 'all_seller_route' ? translate('All Sellers') : translate('Sellers Review & Followers ')}}</h1>
        </div>
        @if(auth()->user()->can('add_seller') && ($route == 'all_seller_route'))
            <div class="col text-right">
                <a href="{{ route('sellers.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Seller')}}</span>
                </a>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <form class="" id="sort_sellers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ $route == 'all_seller_route' ? translate('Sellers') : translate('Sellers Review & Followers ') }}</h5>
            </div>
            @if($route == 'all_seller_route')
                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{translate('Bulk Action')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @can('delete_seller')
                            <a class="dropdown-item confirm-alert" href="javascript:void(0)"  data-target="#bulk-delete-modal">{{translate('Delete selection')}}</a>
                        @endcan
                        @can('seller_commission_configuration')
                            <a class="dropdown-item confirm-alert" onclick="set_bulk_commission()">{{translate('Set Bulk Commission')}}</a>
                        @endcan
                    </div>
                </div>
                <div class="col-md-2 ml-auto">
                    <select class="form-control aiz-selectpicker" name="seller_type" id="seller_type" onchange="sort_sellers()">
                        <option value="">{{translate('Seller Type')}}</option>
                        <option value="brand_partner"  @isset($seller_type) @if($seller_type == 'brand_partner') selected @endif @endisset>{{translate('Brand Partner')}}</option>
                        <option value="seller_partner"  @isset($seller_type) @if($seller_type == 'seller_partner') selected @endif @endisset>{{translate('Seller Partner')}}</option>
                        <option value="store_partner"  @isset($seller_type) @if($seller_type == 'store_partner') selected @endif @endisset>{{translate('Store Partner')}}</option>
                    </select>
                </div>
                <div class="col-lg-2 ml-auto">
                    <select class="form-control aiz-selectpicker" name="verification_status" onchange="sort_sellers()" data-selected="{{ $verification_status }}">
                        <option value="">{{ translate('Verification Status') }}</option>
                        <option value="verified">{{ translate('Verified') }}</option>
                        <option value="un_verified">{{ translate('Unverified') }}</option>
                    </select>
                </div>
                <div class="col-md-2 ml-auto">
                    <select class="form-control aiz-selectpicker" name="approved_status" id="approved_status" onchange="sort_sellers()">
                        <option value="">{{translate('Approval')}}</option>
                        <option value="1"  @isset($approved) @if($approved == '1') selected @endif @endisset>{{translate('Approved')}}</option>
                        <option value="0"  @isset($approved) @if($approved == '0') selected @endif @endisset>{{translate('Non-Approved')}}</option>
                    </select>
                </div>

            @endif
            <div class="col-md-3">
                <div class="form-group mb-0">
                  <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name or email & Enter') }}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th>
                        @if(auth()->user()->can('delete_seller') && ($route == 'all_seller_route'))
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        @else
                            #
                        @endif
                    </th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Seller Type')}}</th>
                    <th data-breakpoints="lg">{{translate('Seller Details')}}</th>
                   
                    
                    @if($route == 'all_seller_route')
                        <th data-breakpoints="lg">{{translate('Wallet ')}}</th>
                        <th data-breakpoints="lg">{{ translate('Num. of Products') }}</th>
                        <th data-breakpoints="lg">{{ translate('SKIN Imports') }}</th>
                        <th data-breakpoints="lg">{{ translate('Business Type') }}</th>
                        <th data-breakpoints="lg">{{ translate('Company Type') }}</th>
                       
                        
                        {{-- <th data-breakpoints="lg">{{ translate('Due to seller') }}</th> --}}
                        @if(get_setting('seller_commission_type') == 'seller_based')
                            <th data-breakpoints="lg">{{ translate('Commission') }}</th>
                        @endif
                        {{-- <th data-breakpoints="lg">{{translate('Email Verification')}}</th>
                        <th data-breakpoints="lg">{{ translate('Status') }}</th> --}}
                        <th data-breakpoints="lg">{{translate('Approval')}}</th>
                        <th data-breakpoints="lg">{{translate('Business Directory')}}</th>
                        <th data-breakpoints="lg">{{translate('Type')}}</th>
                    
                    @else
                        <th data-breakpoints="lg">{{translate('Rating')}}</th>
                        <th data-breakpoints="lg">{{translate('Followers')}}</th>
                        <th data-breakpoints="lg">{{ translate('Custom Followers') }}</th>
                    @endif
                  
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shops as $key => $shop)
                    <tr>
                        <td>
                            @if(auth()->user()->can('delete_seller') && ($route == 'all_seller_route'))
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="{{$shop->id}}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            @else
                                {{ ($key+1) + ($shops->currentPage() - 1)*$shops->perPage() }}
                            @endif
                        </td>
                        <td>
                            <div class="row gutters-5  mw-100 align-items-center">
                                <div class="col-auto">
                                    
                                    <img style="object-fit:contain" src="{{ uploaded_asset($shop->logo) }}" class="size-40px border rounded-2 " alt="Image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </div>
                                <div class="col">
                                    <span class="text-truncate-2">{{ $shop->name }}</span>
                                   
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($shop->user->seller_type )
                                @php
                                    $pill_color = 'success';
                                    if($shop->user->seller_type =="brand_partner") {
                                        $pill_color = 'success';
                                    } else if($shop->user->seller_type =="verified_seller") {
                                        $pill_color = 'info';
                                    } else {
                                        $pill_color = 'dark';
                                    }
                                @endphp
                                
                                <span style="font-size: 10px" class="bg-{{ $pill_color }} rounded-2 text-light px-1 py-1 text-capitalize" style="border-radius: 20px"> {{ str_replace("_", " ", $shop->user->seller_type )}}</span>
                            @endif
                        </td>
                        <td>
                            {{$shop->user->phone}} 
                            <br>
                            {{$shop->user->email}}
                        </td>
                        @if($route == 'all_seller_route')
                            <td>
                                {{-- @if ($shop->verification_status != 1 && $shop->verification_info != null)
                                    <a href="{{ route('sellers.show_verification_request', $shop->id) }}">
                                        <span class="badge badge-inline badge-info">{{translate('Show')}}</span>
                                    </a>
                                @endif --}}
                                @php
                                    $wallet = \App\Models\Wallet::where('user_id', $shop->user->id )->first();
                                    $wallet_amount = $wallet ? $wallet->amount : 0; 
                                @endphp
                                {{  $wallet_amount  }}
                            </td>
                            
                            <td>{{ $shop->user->products->count() }}</td>
                            <td>{{ $shop->user->products->count() }}</td>
                            {{-- <td>
                                @if ($shop->admin_to_pay >= 0)
                                    {{ single_price($shop->admin_to_pay) }}
                                @else
                                    {{ single_price(abs($shop->admin_to_pay)) }} ({{ translate('Due to Admin') }})
                                @endif
                            </td> --}}
                            @if(get_setting('seller_commission_type') == 'seller_based')
                                <td>{{ $shop->commission_percentage }}%</td>
                            @endif
                            <td>
                                @if ( !empty( $shop->user->business_type) )
                                <span class="bg-dark text-light px-2 py-1 text-capitalize" style="border-radius: 20px"> {{ str_replace("_", " ",  $shop->user->business_type  )}}</span>
                                @endif
                            </td>
                            <td>
                                @if ( !empty( $shop->user->company_type) )
                                    <span class="bg-dark text-light px-2 py-1 text-capitalize" style="border-radius: 20px"> {{ str_replace("_", " ",  $shop->user->company_type  )}}</span>
                                @endif
                            </td>
                            
                            {{-- <td>
                                @if($shop->user->email_verified_at != null)
                                    <span class="badge badge-inline badge-success">{{translate('Verified')}}</span>
                                @else
                                    <span class="badge badge-inline badge-warning">{{translate('Unverified')}}</span>
                                @endif
                            </td>
                            <td>
                                @if($shop->user->banned)
                                    <span class="badge badge-inline badge-danger">{{ translate('Ban') }}</span>
                                @else
                                    <span class="badge badge-inline badge-success">{{ translate('Regular') }}</span>
                                @endif
                            </td> --}}
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input
                                        @can('approve_seller') onchange="update_approved(this)" @endcan
                                        value="{{ $shop->id }}" type="checkbox"
                                        <?php if($shop->verification_status == 1) echo "checked";?>
                                        @cannot('approve_seller') disabled @endcan
                                    >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input
                                       onchange="update_business_directory_flag(this)" 
                                        value="{{ $shop->user->id }}" type="checkbox"
                                        <?php if($shop->user->business_directory_flag == 1) echo "checked";?>
                                        
                                    >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <select class="form-control">
                                   
                                    <option>Brand Partner</option>
                                    <option>Seller Partner</option>
                                    <option>Store Partner</option>
                                </select>
                            </td>
                            <td style="text-align: left">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                        <i class="las la-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                        <a href="{{ url('/admin/all_orders?seller_id='.$shop->user->id) }}"  class="dropdown-item">
                                            Pending Orders
                                        </a>
                                        <a href="javascript:void();"  class="dropdown-item">
                                            Profit History
                                        </a>
                                        <a href="javascript:void();"  class="dropdown-item">
                                            Transaction History
                                        </a>
                                        <a href="{{ url('/admin/products/all?user_id='.$shop->user->id) }}"  class="dropdown-item">
                                            Products
                                        </a>
                                        <a href="javascript:void();"  class="dropdown-item">
                                            Imports
                                        </a>
                                        <a href="javascript:void();"  class="dropdown-item">
                                            Business Directory
                                        </a>
                                        
                                        @can('view_seller_profile')
                                            <a href="javascript:void();" onclick="show_seller_profile('{{$shop->id}}');"  class="dropdown-item">
                                                {{translate('Profile')}}
                                            </a>
                                        @endcan
                                        @can('login_as_seller')
                                            <a href="{{route('sellers.login', encrypt($shop->id))}}" class="dropdown-item">
                                                {{translate('Log in as this Seller')}}
                                            </a>
                                        @endcan
                                        @can('pay_to_seller')
                                            <a href="javascript:void();" onclick="show_seller_payment_modal('{{$shop->id}}');" class="dropdown-item">
                                                {{translate('Go to Payment')}}
                                            </a>
                                        @endcan
                                        @can('seller_payment_history')
                                            <a href="{{route('sellers.payment_history', encrypt($shop->user_id))}}" class="dropdown-item">
                                                {{translate('Payment History')}}
                                            </a>
                                        @endcan
                                        @can('seller_commission_configuration')
                                            <a href="javascript:void();" onclick="set_commission('{{ $shop->id }}');" class="dropdown-item">
                                                {{translate('Set Commission')}}
                                            </a>
                                        @endcan
                                        @can('edit_seller')
                                            <a href="{{route('sellers.edit', encrypt($shop->id))}}" class="dropdown-item">
                                                {{translate('Edit')}}
                                            </a>
                                        @endcan
                                        @can('ban_seller')
                                            @if($shop->user->banned != 1)
                                                <a href="javascript:void();" onclick="confirm_ban('{{route('sellers.ban', $shop->id)}}');" class="dropdown-item">
                                                    {{translate('Ban this seller')}}
                                                    <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void();" onclick="confirm_unban('{{route('sellers.ban', $shop->id)}}');" class="dropdown-item">
                                                    {{translate('Unban this seller')}}
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        @endcan
                                        @can('delete_seller')
                                            <a href="javascript:void();" class="dropdown-item confirm-delete" data-href="{{route('sellers.destroy', $shop->id)}}" class="">
                                                {{translate('Delete')}}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                          
                        @else
                            <td>
                                {{ $shop->rating }}
                                <span class="rating rating-sm m-0 ml-1">
                                    @for ($i=0; $i < $shop->rating; $i++)
                                        <i class="las la-star active"></i>
                                    @endfor
                                    @for ($i=0; $i < 5-$shop->rating; $i++)
                                        <i class="las la-star"></i>
                                    @endfor
                                </span>
                            </td>
                            <td>{{ $shop->followers()->count() }}</td>
                            <td>{{ $shop->custom_followers }}</td>
                            <td>
                                @if(auth()->user()->can('edit_seller_custom_followers'))
                                    <a href="javascript:void();" onclick="editCustomFollowers({{ $shop->id }}, {{ $shop->custom_followers }});" class="btn btn-primary btn-xs fs-10 fw-700">
                                        {{translate('Edit Custom Follower')}}
                                    </a>
                                @endif
                            </td>
                        @endif
                        
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
              {{ $shops->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')
	<!-- Delete Modal -->
	@include('modals.delete_modal')
    <!-- Bulk Delete modal -->
    @include('modals.bulk_delete_modal')

	<!-- Seller Profile Modal -->
	<div class="modal fade" id="profile_modal">
		<div class="modal-dialog">
			<div class="modal-content" id="profile-modal-content">

			</div>
		</div>
	</div>

	<!-- Seller Payment Modal -->
	<div class="modal fade" id="payment_modal">
	    <div class="modal-dialog">
	        <div class="modal-content" id="payment-modal-content">

	        </div>
	    </div>
	</div>

	<!-- Ban Seller Modal -->
	<div class="modal fade" id="confirm-ban">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
					<button type="button" class="close" data-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
                    <p>{{translate('Do you really want to ban this seller?')}}</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
					<a class="btn btn-primary" id="confirmation">{{translate('Proceed!')}}</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Unban Seller Modal -->
	<div class="modal fade" id="confirm-unban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                        <p>{{translate('Do you really want to unban this seller?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <a class="btn btn-primary" id="confirmationunban">{{translate('Proceed!')}}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Set Selelr Commission --}}
    <div class="modal fade" id="set_seller_commission">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Set Seller Commission')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <form class="form-horizontal" action="{{ route('set_seller_based_commission') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="seller_ids" value="" id="seller_ids">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{translate('Selle Commission')}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" lang="en" min="0" max="100" step="0.01" placeholder="{{translate('Commission Percentage')}}" name="commission_percentage" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm text-white">{{translate('save!')}}</button>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Seller Custom Followers --}}
    <div class="modal fade" id="edit_seller_custom_followers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Edit Seller Custom Followers')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <form class="form-horizontal" action="{{ route('edit_Seller_custom_followers') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="shop_id" value="" id="shop_id">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{translate('Custom Followers')}}</label>
                            <div class="col-md-9">
                                <input type="number" lang="en" min="0" step="1" placeholder="{{translate('Custom Followers')}}" value="" name="custom_followers" id="custom_followers" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm text-white">{{translate('save!')}}</button>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        function show_seller_payment_modal(id){
            $.post('{{ route('sellers.payment_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#payment_modal #payment-modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
                $('.demo-select2-placeholder').select2();
            });
        }

        function show_seller_profile(id){
            $.post('{{ route('sellers.profile_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#profile_modal #profile-modal-content').html(data);
                $('#profile_modal').modal('show', {backdrop: 'static'});
            });
        }

        function update_approved(el){
            if('{{env('DEMO_MODE')}}' == 'On'){
                AIZ.plugins.notify('info', '{{ translate('Data can not change in demo mode.') }}');
                return;
            }

            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('sellers.approved') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Approved sellers updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
        function update_business_directory_flag(el){
          

            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('sellers.updatebusinessDirectoryFlag') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Business Directory Updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sort_sellers(el){
            $('#sort_sellers').submit();
        }

        function confirm_ban(url)
        {
            if('{{env('DEMO_MODE')}}' == 'On'){
                AIZ.plugins.notify('info', '{{ translate('Data can not change in demo mode.') }}');
                return;
            }

            $('#confirm-ban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }

        function confirm_unban(url)
        {
            if('{{env('DEMO_MODE')}}' == 'On'){
                AIZ.plugins.notify('info', '{{ translate('Data can not change in demo mode.') }}');
                return;
            }

            $('#confirm-unban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationunban').setAttribute('href' , url);
        }

        function bulk_delete() {
            var data = new FormData($('#sort_sellers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-seller-delete')}}",
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

        // Set Commission
        function set_commission(shop_id){
            var sellerIds = [];
            sellerIds.push(shop_id);
            $('#seller_ids').val(sellerIds);
            $('#set_seller_commission').modal('show', {backdrop: 'static'});
        }

        // Set seller bulk commission
        function set_bulk_commission(){
            var sellerIds = [];
            $(".check-one[name='id[]']:checked").each(function() {
                sellerIds.push($(this).val());
            });
            if(sellerIds.length > 0){
                $('#seller_ids').val(sellerIds);
                $('#set_seller_commission').modal('show', {backdrop: 'static'});
            }
            else{
                AIZ.plugins.notify('danger', '{{ translate('Please Select Seller first.') }}');
            }
        }

        
        // Edit seller custom followers
        function editCustomFollowers(shop_id, custom_followers){
            $('#shop_id').val(shop_id);
            $('#custom_followers').val(custom_followers);
            $('#edit_seller_custom_followers').modal('show', {backdrop: 'static'});
        }

    </script>
@endsection
