@extends('seller.layouts.app')

@section('panel_content')

<form method="GET" action="{{ route('seller.business-directory.index') }}">
    <div class="row mb-3">
        
        <div class="col-md-2">
            <select name="category_id" class="form-control aiz-selectpicker" data-live-search="true">
                <option value=""> Category</option>
                @foreach ($categories as $category)
                    <!-- Main category as a selectable option -->
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
        
                    <!-- If category has children, group them -->
                    @if ($category->childrenCategories->count())
                        <optgroup label="Categories">
                            @foreach ($category->childrenCategories as $child)
                                <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                    ── {{ $child->name }}
                                </option>
        
                                @if ($child->childrenCategories->count())
                                    @foreach ($child->childrenCategories as $subChild)
                                        <option value="{{ $subChild->id }}" {{ request('category_id') == $subChild->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;└── {{ $subChild->name }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
        </div>
        
        
        <!-- Brand Dropdown -->
        <div class="col-md-2">
            <select name="brand_id" class="form-control aiz-selectpicker" data-live-search="true">
                <option value=""> Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Ownership Type Filter -->
        <div class="col-md-2">
            <select name="ownership_type" class="form-control aiz-selectpicker" data-live-search="true">
                <option value=""> Ownership Type</option>
                <option value="Sole Proprietorship" {{ request('ownership_type') == 'Sole Proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                <option value="Partnership" {{ request('ownership_type') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                <option value="LLC" {{ request('ownership_type') == 'LLC' ? 'selected' : '' }}>LLC</option>
                <option value="Corporation" {{ request('ownership_type') == 'Corporation' ? 'selected' : '' }}>Corporation</option>
            </select>
        </div>

        <!-- Business Type Filter -->
        <div class="col-md-2">
            <select name="business_type" class="form-control aiz-selectpicker" data-live-search="true">
                <option value=""> Business Type</option>
                <option value="Manufacturer" {{ request('business_type') == 'Manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                <option value="Exporter" {{ request('business_type') == 'Exporter' ? 'selected' : '' }}>Exporter</option>
                <option value="Importer" {{ request('business_type') == 'Importer' ? 'selected' : '' }}>Importer</option>
                <option value="Distributor" {{ request('business_type') == 'Distributor' ? 'selected' : '' }}>Distributor</option>
                <option value="Wholeseller" {{ request('business_type') == 'Wholeseller' ? 'selected' : '' }}>Wholeseller</option>
                <option value="Dealer" {{ request('business_type') == 'Dealer' ? 'selected' : '' }}>Dealer</option>
                <option value="Agent" {{ request('business_type') == 'Agent' ? 'selected' : '' }}>Agent</option>
                <option value="Shopkeeper" {{ request('business_type') == 'Shopkeeper' ? 'selected' : '' }}>Shopkeeper</option>
                <option value="Trader" {{ request('business_type') == 'Trader' ? 'selected' : '' }}>Trader</option>
                <option value="Service Provider" {{ request('business_type') == 'Service Provider' ? 'selected' : '' }}>Service Provider</option>
            </select>
        </div>


        <!-- City Dropdown -->
        <div class="col-md-2">
            <select name="city_id" class="form-control aiz-selectpicker" data-live-search="true">
                <option value=""> City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Trust Level -->
        <div class="col-md-2">
            <select name="trust_level" class="form-control aiz-selectpicker" data-live-search="true">
                <option value=""> Trust Level</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('trust_level') == $i ? 'selected' : '' }}>
                        {{ str_repeat('⭐', $i) }}
                    </option>
                @endfor
            </select>
        </div>
    </div>

   
        
    <div class="d-flex justify-content-end w-100">
            <!-- Name Search -->
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="Search by Name" value="{{ request('name') }}">
        </div>

        <!-- Phone Search -->
        <div class="col-md-3">
            <input type="text" name="phone" class="form-control" placeholder="Search by Phone" value="{{ request('phone') }}">
        </div>
        
        <button type="submit" class="btn btn-primary mr-2">Filter</button>
        <a href="{{ route('seller.business-directory.index') }}" class="btn btn-secondary ">Reset</a>
        <a href="{{ route('seller.business-directory.export') }}" class="btn btn-success">
            Export CSV
        </a>
            
       
        
    </div>
  
</form>

 

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
          
            <div class="card">
                <div class="card-header"> <h5 class="mb-md-0 h6">{{ translate('Business Directory') }}</h5>
                    <a href="{{ route('seller.business-directory.create') }}" class="btn btn-primary">
                        Add Item
                    </a></div>
             

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-responsive" style="white-space: nowrap; overflow-x: auto;">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>WhatsApp No</th>
                                    <th>Designation</th>
                                    <th>Business Name</th>
                                    <th>Brand</th>
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
                                        <td>@if(!empty($item->brand))<span class="badge badge-dark w-auto">{{ $item->brand->name }}</span>@endif</td>
                                        <td>@if(!empty($item->category))<span class="badge badge-dark w-auto">{{ $item->category->name }}</span>@endif</td>
                                        <td>@if(!empty($item->business_type))<span class="badge badge-success w-auto text-capitalize">{{ $item->business_type }}@endif</td>
                                        <td>@if(!empty($item->ownership_type))<span class="badge badge-info w-auto text-capitalize">{{ $item->ownership_type }}@endif</td>
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
                                            <div class="d-flex ">
                                                <a href="{{ route('seller.business-directory.edit', $item->id) }}" class="btn btn-success btn-sm me-2">
                                                    <i class="la la-edit fs-15"></i>
                                                </a>
                                                <form action="{{ route('seller.business-directory.destroy', ['business_directory' => $item->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?');"><i class="la la-trash fs-15"></i></button>
                                                </form>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $business_directory->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection