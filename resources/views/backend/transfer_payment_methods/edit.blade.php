@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Payment Method</h2>

    <form action="{{ route('admin_transfer_payment_methods.update', $method->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <div class="col-md-3">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="bank" {{ $method->type == 'bank' ? 'selected' : '' }}>Bank</option>
                    <option value="mobile" {{ $method->type == 'mobile' ? 'selected' : '' }}>Mobile</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $method->title }}" required>
            </div>

            <div class="col-md-3">
                <label>Account Title</label>
                <input type="text" name="account_title" class="form-control" value="{{ $method->account_title }}" required>
            </div>

            <div class="col-md-3">
                <label>Account No</label>
                <input type="text" name="account_no" class="form-control" value="{{ $method->account_no }}">
            </div>

            <div class="col-md-3">
                <label>IBAN</label>
                <input type="text" name="iban" class="form-control" value="{{ $method->iban }}">
            </div>

            <div class="col-md-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $method->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$method->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Image</label><br>
                @if($method->image)
                    <img src="{{ asset('storage/'.$method->image) }}" width="60"><br>
                @endif
                <input type="file" name="image" class="form-control mt-1">
            </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-success w-100">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection
