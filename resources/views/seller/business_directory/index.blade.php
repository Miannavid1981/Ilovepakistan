@extends('seller.layouts.app')

@section('panel_content')

    <a href="{{ route('seller.business-directory.create') }}" class="btn btn-primary">
        Add Item
    </a>
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
          
            <div class="card">
                <div class="card-header"> <h5 class="mb-md-0 h6">{{ translate('Business Directory') }}</h5></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Business Type</th>
                               
                                <th>Category</th>
                                <th>City</th>
                                <th>Area</th>
                                {{-- <th>Address</th> --}}
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($business_directory as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->company }}</td>
                                    <td>{{ $item->business_type }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->city->name }}</td>
                                    <td>{{ $item->area }}</td>
                                    
                                    {{-- <td>{{ $item->address }}</td> --}}
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        {{-- <a href="" class="btn btn-info btn-sm">View</a>
                                        <a href="" class="btn btn-warning btn-sm">Edit</a> --}}
                                        <form action="{{ route('seller.business-directory.destroy', ['business_directory' => $item->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                        </form>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $business_directory->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection