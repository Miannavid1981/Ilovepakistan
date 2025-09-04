@extends('backend.layouts.app')

@section('content')
    <h2>Add Banner</h2>
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" required>
        <button class="btn btn-success">Save</button>
    </form>
@endsection