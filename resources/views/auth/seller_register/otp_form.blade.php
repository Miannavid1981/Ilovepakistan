@extends('frontend.layouts.app')

@section('content')
<div class="container ">
    <div class="row my-5">
    
        <div class="col-4">

        </div>
        <div class="col-4">
            <h3>Enter OTP</h3>
            <p>Check your email for a 6-digit OTP code.</p>
            <form method="POST" action="{{ route('verify.otp.submit') }}">
                @csrf
                <input type="text" name="otp" class="form-control" placeholder="Enter OTP">
                @error('otp')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary mt-3">Verify</button>
            </form>
        </div>
    </div>
</div>
@endsection
