@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2>Delivery Types Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.delivery_types.update') }}">
        @csrf
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="personal" id="personal" {{ $setting->personal ? 'checked' : '' }}>
            <label class="form-check-label" for="personal">Personal</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="family_friends" id="family_friends" {{ $setting->family_and_friends ? 'checked' : '' }}>
            <label class="form-check-label" for="family_friends">Family and Friends</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="others" id="others" {{ $setting->others ? 'checked' : '' }}>
            <label class="form-check-label" for="others">Others</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
    </form>
</div>
@endsection
