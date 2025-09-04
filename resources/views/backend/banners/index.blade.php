@extends('backend.layouts.app')

@section('content')

  <h2>Banners</h2>
<a href="{{ route('admin.home_banners.create') }}" class="btn btn-primary">Add Banner</a>
    <ul style="list-style-type: none !important;">
        @foreach($banners as $banner)
            <li>
                <img src="{{ uploaded_asset( $banner->image) }}" width="200">
                <form action="{{ route('admin.home_banners.destroy', $banner->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection