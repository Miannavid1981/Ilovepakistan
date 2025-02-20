@extends('seller.layouts.app')

@section('panel_content')
    <div class="card">
        <form class="" action="" id="sort_commission_history" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Commission History') }}</h5>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm aiz-date-range" id="search" name="date_range"@isset($date_range) value="{{ $date_range }}" @endisset placeholder="{{ translate('Daterange') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-breakpoints="lg">{{ translate('Order Code') }}</th>
                        <th>{{ translate('Admin Commission') }}</th>
                        <th>{{ translate('Earning') }}</th>
                        <th data-breakpoints="lg">{{ translate('Created At') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commission_history as $key => $transaction)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ date('d-m-Y', strtotime($transaction->created_at)) }}</td>
                        <td>{{ single_price($transaction->amount) }}</td>
                        <td> -{{ single_price($transaction->admin_profit ?? 0) }}</td>
                        <td>
                            @if ($transaction->status == 1)
                                <span class="badge badge-inline badge-success">{{ translate('Completed') }}</span>
                            @else
                                <span class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination mt-4">
                {{ $commission_history->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    function sort_commission_history(el){
        $('#sort_commission_history').submit();
    }
</script>
@endsection
