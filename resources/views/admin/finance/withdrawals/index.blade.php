@extends('admin.app')
@section('title', __('Withdrawal_requests'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Withdrawal_requests') }}</li>
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
                                <h4 class="card-title">{{ __('Withdrawal_requests') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            @if($transactions->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Payment_System') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Client') }}</th>
                                        <th scope="col">{{ __('Date') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
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
                                            <td>
                                                <a href="{{ route('admin.clients.show', ['id' => $transaction->user->id]) }}" target="_blank">{{ $transaction->user->login }}</a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toDateTimeString() }}</td>
                                            <td>
                                                <a href="#" onclick="sureAndRedirect(this, '{{ route('admin.finance.withdrawals.approve', ['id' => $transaction->id]) }}')" class="btn btn-primary" style="display: block;">{{ __('send funds') }}</a>
                                                <a href="#" onclick="sureAndRedirect(this, '{{ route('admin.finance.withdrawals.manually', ['id' => $transaction->id]) }}')" class="btn btn-outline-info" style="display: block; margin-top:5px;">{{ __('close_order_without_return') }}</a>
                                                <a href="#" onclick="sureAndRedirect(this, '{{ route('admin.finance.withdrawals.reject', ['id' => $transaction->id]) }}')" class="btn btn-outline-info" style="display: block; margin-top:5px;">{{ __('close_order_with_return') }}</a>
                                            </td>
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
                                    <div class="iq-alert-text">{{ __('No_new_withdrawals') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection