@extends('admin.app')
@section('title', __('Transactions'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Transactions') }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Transactions_list') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-sm-12 col-md-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search_by_ID') }}" aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($transactions->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Payment_System') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Type') }}</th>
                                        <th scope="col">{{ __('Client') }}</th>
                                        <th scope="col">{{ __('Batch') }}</th>
                                        <th scope="col">{{ __('Verified') }}</th>
                                        <th scope="col">{{ __('Date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.finance.transactions.show', ['id' => $transaction->id]) }}" target="_blank">{{ $transaction->id }}</a>
                                            </td>
                                            <td>{{ $transaction->paymentSystem->name }}</td>
                                            <td>{{ amountWithPrecision($transaction->amount, $transaction->currency) }}{{ $transaction->currency->symbol }}</td>
                                            <td>{{ $transaction->type->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.clients.show', ['id' => $transaction->user->id]) }}" target="_blank">{{ $transaction->user->login }}</a>
                                            </td>
                                            <td>{!! !empty($transaction->batch_id) ? '<input type="text" value="'.$transaction->batch_id.'" readonly>' : '<span class="badge border border-warning text-warning">'.__('no_batch').'</span>' !!}</td>
                                            <td>{!! $transaction->approved ? '<span class="badge badge-success">'.__('yes').
                                            '</span>' : '<span class="badge badge-danger">'.__('no').'</span>' !!}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toDateTimeString() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $transactions->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('No_transactions_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection