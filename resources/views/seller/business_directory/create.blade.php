@extends('seller.layouts.app')

@section('panel_content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.business-directory.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Business Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Business Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required>
        </div>

        <!-- Contact Number -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Contact Number</label>
            <input type="text" name="phone" class="w-full p-2 border rounded" required>
        </div>

        <!-- Company Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Company Name</label>
            <input type="text" name="company" class="w-full p-2 border rounded" required>
        </div>

        <!-- City -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">City</label>
            <select name="city_id" class="w-full p-2 border rounded" required>
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Area -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Area</label>
            <input type="text" name="area" class="w-full p-2 border rounded" required>
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Product Category</label>
            <select name="category_id" class="w-full p-2 border rounded" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2"> Brand</label>
            <select name="brand_id" class="w-full p-2 border rounded" required>
                <option value="">Select Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Business Type -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Business Type</label>
            <select name="business_type" class="w-full p-2 border rounded" >
                <option value="">Select Business Type</option>
                <option value="Manufacturer">Manufacturer</option>
                <option value="Exporter">Exporter</option>
                <option value="Importer">Importer</option>
                <option value="Distributor">Distributor</option>
                <option value="Wholeseller">Wholeseller</option>
                <option value="Dealer">Dealer</option>
                <option value="Agent">Agent</option>
                <option value="Shopkeeper">Shopkeeper</option>
                <option value="Trader">Trader</option>
                <option value="Service Provider">Service Provider</option>
            </select>
        </div>
        <!-- Whatsapp Number -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">WhatsApp No</label>
            <input type="text" name="whatsapp_no" class="w-full p-2 border rounded">
        </div>

        <!-- Designation -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Designation</label>
            <input type="text" name="designation" class="w-full p-2 border rounded">
        </div>

        <!-- Google Sheet URL -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Google Sheet URL</label>
            <input type="url" name="google_sheet_url" class="w-full p-2 border rounded">
        </div>

       
        <!-- Ownership Type -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Ownership Type</label>
            <select name="ownership_type" class="w-full p-2 border rounded" required>
                <option value="">Select Ownership Type</option>
                <option value="Sole Proprietor">Sole Proprietor</option>
                <option value="Partnership">Partnership</option>
                <option value="SMC Pvt Ltd">SMC Pvt Ltd</option>
                <option value="Pvt Ltd">Pvt Ltd</option>
                <option value="Public Ltd">Public Ltd</option>
            </select>
        </div>

        <!-- Trust Level -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Trust Level</label>
            <select name="trust_level" class="w-full p-2 border rounded" required>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Upload Notes</label>
            <input type="file" name="notes" class="w-full p-2 border rounded">
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary text-white px-4 py-2 rounded">Save </button>
        </div>
    </form>
</div>
@endsection
