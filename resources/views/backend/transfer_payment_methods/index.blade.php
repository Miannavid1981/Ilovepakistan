@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2>Transfer Payment Methods</h2>

    <form action="{{ route('admin_transfer_payment_methods.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-2">
                <select name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="bank">Bank</option>
                    <option value="mobile">Mobile</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="account_title" class="form-control" placeholder="Account Title" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="account_no" class="form-control" placeholder="Account No">
            </div>
            <div class="col-md-2">
                <input type="text" name="iban" class="form-control" placeholder="IBAN">
            </div>
            <div class="col-md-1">
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-success w-100">Add</button>
            </div>
        </div>
    </form>

    <hr>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Image</th>
                <th>Type</th>
                <th>Title</th>
                <th>Account</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($methods as $method)
                <tr>
                    <td>
                        @if($method->image)
                            <img src="{{ asset('storage/'.$method->image) }}" width="40">
                        @endif
                    </td>
                    <td>{{ ucfirst($method->type) }}</td>
                    <td>{{ $method->title }}</td>
                    <td>
                        {{ $method->account_title }}<br>
                        {{ $method->account_no }}<br>
                        {{ $method->iban }}
                    </td>
                    <td>{{ $method->status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('admin_transfer_payment_methods.edit', $method->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $methods->links() }}
</div>
@endsection
