@extends('backend.layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <h3>Deposit Requests</h3>
          
            <div class="card">
                {{-- <div class="card-header"> <h5 class="mb-md-0 h6">{{ translate('Business Directory') }}</h5>  <a href="{{ route('admin_business_directory.create') }}" class="btn btn-primary">
                    Add Item
                </a></div> --}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="table-responsive"> 
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th> 
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment Method</th>
                                        <th>Payment Receipt</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deposit_requests as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                <div class="w-40px h-40px ">
                                                    <img src="{{ uploaded_asset($item->user->avatar_original) }}" class="w-100 h-100 object-cover rounded-3 ">
                                                </div>
                                                <div class="">
                                                    <span class="text-truncate-2">{{ $item->user->name }}</span>
                                                </div>
                                            </td>
                                            
                                            <td>PKR {{ $item->amount }}</td>
                                            <td>@if(!empty($item->status))<span class="badge badge-warning w-auto">{{ $item->status }}</span>@endif</td>
                                            <td>{{ $item->payment_method }}</td>
                                            <td>@if(!empty($item->payment_receipt))
                                                <a href="{{ asset('storage/' . $item->payment_receipt) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    View Receipt
                                                </a>
                                            @endif</td>
                                           
                                           
                                            <td>
                                                <div class="d-flex ">
                                                    <a href="{{ route('admin_business_directory.edit', $item->id) }}" class="btn btn-success btn-sm me-2">
                                                        <i class="la la-check fs-15"></i>
                                                    </a>
                                                    <form action="{{ route('admin_business_directory.destroy', ['business_directory' => $item->id]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?');"><i class="la la-close fs-15"></i></button>
                                                    </form>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    <div class="d-flex justify-content-center">
                        {{ $deposit_requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection