@extends('seller.layouts.app')

@section('panel_content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Add New Business</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.business-directory.store') }}" method="POST">
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
            <label class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" class="w-full p-2 border rounded" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Business Type -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Business Type</label>
            <select name="business_type" class="w-full p-2 border rounded" >
                <option value="">Select Business Type</option>
                <option value="distributor">Distributor</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save Business</button>
        </div>
    </form>
</div>
@endsection
