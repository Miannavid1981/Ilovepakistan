@extends('backend.layouts.app')

@section('content')
    <h2>Add Banner</h2>
    <form action="{{ route('admin.home_banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Banner Image</label>
            
            {{-- AIZ uploader or your custom uploader --}}
            <div class="input-group" data-toggle="aizuploader" data-type="image">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                </div>
                <div class="form-control file-amount">Choose Image</div>
                <input type="hidden" name="image" class="selected-files">
            </div>
            <div class="file-preview box sm"></div>
        </div>
    </form>
@endsection