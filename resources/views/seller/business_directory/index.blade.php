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
                                <th>Contact No</th>
                                <th>WhatsApp No</th>
                                <th>Designation</th>
                                <th>Business Name</th>
                                <th>Product Category</th>
                                <th>Business Type</th>
                                <th>Ownership Type</th>
                                <th>City</th>
                                <th>Area</th>
                                <th>Trust Level</th>
                                <th>Document Notes</th>
                                <th>Google Sheet</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($business_directory as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->whatsapp_no }}</td>
                                    <td>{{ $item->designation }}</td>
                                    <td>{{ $item->company }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->business_type }}</td>
                                    <td>{{ $item->ownership_type }}</td>
                                    <td>{{ $item->city->name }}</td>
                                    <td>{{ $item->area }}</td>
                                    <td>{!! str_repeat('⭐', $item->trust_level) !!}
                                    </td>
                                    <td>
                                        @if ($item->notes)
                                            <a href="{{ asset('storage/' . $item->notes) }}" target="_blank" class="btn btn-dark">View File</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->google_sheet_url)
                                            <a href="{{ $item->google_sheet_url }}" target="_blank" class="btn btn-light p-0"><img class="w-40px h-auto" src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Google_Sheets_logo_%282014-2020%29.svg/1200px-Google_Sheets_logo_%282014-2020%29.svg.png"></a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a href="" class="btn btn-info btn-sm">View</a>
                                        <a href="" class="btn btn-warning btn-sm">Edit</a> --}}
                                        <a href="{{ route('seller.business-directory.edit', $item->id) }}" class="btn btn-success">
                                            Edit
                                        </a>
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