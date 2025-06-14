@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <h5 class="mb-0 h6">System Transactions</h5>
</div>

<div class="card">
    <div class="card-body">
        <table class="table aiz-table mb-4">
            <thead class="text-gray fs-12">
                <tr>
                    <th class="pl-0">#</th>
                    <th class="pl-0">Trx ID</th>
                    <th>{{ translate('User') }}</th>
                    <th>{{ translate('Type') }}</th>
                    <th>{{ translate('Amount') }}</th>
                    <th>{{ translate('Type') }}</th>
                    <th>{{ translate('Source') }}</th>
                    <th data-breakpoints="lg">{{ translate('Description') }}</th>
                    <th data-breakpoints="lg">{{ translate('Date') }}</th>
                </tr>
            </thead>
            <tbody class="fs-14">
                @foreach ($transactions as $key => $wallet)
                        @php
                            $wallet_user = \App\Models\User::find($wallet->user_id);
                        @endphp
                    <tr>
                        
                        <td class="pl-0">{{ sprintf('%02d', ($key+1)) }}</td>
                        <td class="pl-0 text-secondary">TRX00{{ sprintf('%02d', ($wallet->id)) }}</td>
                        <td>{{ $wallet_user ? $wallet_user->name : '' }}</td>
                        <td>{{ $wallet_user ? $wallet_user->user_type : ''}}</td>
                       
                        <td class="fw-700 @if($wallet->type == 'credit') text-success @else text-danger @endif">
                            {{ ($wallet->type == 'credit' ? '+' : '-') . single_price($wallet->amount) }}
                        </td>
                        <td>{{ ucfirst(str_replace('_', ' ', $wallet->type)) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $wallet->source)) }}</td>
                        <td>{{ $wallet->description }}</td>
                        <td>{{ $wallet->created_at->format('F j Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
