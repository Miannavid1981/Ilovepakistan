@extends('backend.layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">

    <h4 class="text-xl font-bold mb-4">Edit Business Directory Item</h4>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin_business_directory.update', $business_directory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- City -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Seller</label>
            <select name="city_id" class="w-full p-2 border rounded">
                @foreach ($sellers as $seller)
                    <option value="{{ $seller->id }}" {{ $business_directory->user_id == $seller->id ? 'selected' : '' }}>
                        {{ $seller->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Business Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Business Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded" value="{{ $business_directory->name }}" required>
        </div>

        <!-- Contact Number -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Contact Number</label>
            <input type="text" name="phone" class="w-full p-2 border rounded" value="{{ $business_directory->phone }}" required>
        </div>

        <!-- WhatsApp Number -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">WhatsApp Number</label>
            <input type="text" name="whatsapp" class="w-full p-2 border rounded" value="{{ $business_directory->whatsapp }}">
        </div>

        <!-- Company Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Company Name</label>
            <input type="text" name="company" class="w-full p-2 border rounded" value="{{ $business_directory->company }}">
        </div>

        <!-- City -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">City</label>
            <select name="city_id" class="w-full p-2 border rounded">
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $business_directory->city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Area -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Area</label>
            <input type="text" name="area" class="w-full p-2 border rounded" value="{{ $business_directory->area }}">
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" class="w-full p-2 border rounded">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $business_directory->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Category -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Brand</label>
            <select name="brand_id" class="w-full p-2 border rounded">
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $business_directory->brand_id == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Business Type -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Business Type</label>
            <select name="business_type" class="w-full p-2 border rounded">
                <option value="manufacturer" {{ $business_directory->business_type == 'manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                <option value="exporter" {{ $business_directory->business_type == 'exporter' ? 'selected' : '' }}>Exporter</option>
                <option value="importer" {{ $business_directory->business_type == 'importer' ? 'selected' : '' }}>Importer</option>
                <option value="distributor" {{ $business_directory->business_type == 'distributor' ? 'selected' : '' }}>Distributor</option>
            </select>
        </div>

        <!-- Trust Level -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Trust Level</label>
            <select name="trust_level" class="w-full p-2 border rounded">
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $business_directory->trust_level == $i ? 'selected' : '' }}>
                        {!! str_repeat('⭐', $i) !!}
                    </option>
                @endfor
            </select>
        </div>

        <!-- Notes Upload -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Upload Notes</label>
            <input type="file" name="notes" class="w-full p-2 border rounded">
            @if ($business_directory->notes)
                <p class="mt-2">Current File: <a href="{{ asset('storage/' . $business_directory->notes) }}" class="text-blue-500" target="_blank">View File</a></p>
            @endif
        </div>
        <!-- Google Sheet URL -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Google Sheet URL</label>
            <input type="url" name="google_sheet_url" class="w-full p-2 border rounded" value="{{ $business_directory->google_sheet_url }}">
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary text-white px-4 py-2 rounded">Update Business</button>
        </div>
    </form>
</div>
@endsection
