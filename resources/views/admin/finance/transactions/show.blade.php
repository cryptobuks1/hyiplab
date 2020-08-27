@extends('admin.app')
@section('title', __('Transactions_details'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.finance.transactions.index') }}">{{ __('Transactions') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Transactions_details') }}: {{ $transaction->id }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Transactions_details') }}: {{ $transaction->id }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.finance.transactions.update', ['id' => $transaction->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $transaction->id }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="transactionUserId">{{ __('User') }}</label>
                                    <select class="form-control" name="transaction[user_id]" id="transactionUserId">
                                        @foreach(\App\Models\User::all() as $u)
                                            <option value="{{ $u->id }}"{{ $transaction->user_id == $u->id ? ' selected' : '' }}>{{ $u->login }} - {{ $u->email }} [ref link: {{ $u->my_id }}]</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="transactionTypeId">{{ __('Transaction_type') }}</label>
                                    <select class="form-control" name="transaction[type_id]" id="transactionTypeId">
                                        @foreach(\App\Models\TransactionType::all() as $t)
                                            <option value="{{ $t->id }}"{{ $transaction->type_id == $t->id ? ' selected' : '' }}>{{ $t->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="transactionCurrencyId">{{ __('Currency') }}</label>
                                    <select class="form-control" name="transaction[currency_id]" id="transactionCurrencyId">
                                        @foreach(\App\Models\Currency::all() as $c)
                                            <option value="{{ $c->id }}"{{ $transaction->currency_id == $c->id ? ' selected' : '' }}>{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="transactionPaymentSystemId">{{ __('Payment_System') }}</label>
                                    <select class="form-control" name="transaction[payment_system_id]" id="transactionPaymentSystemId">
                                        @foreach(\App\Models\PaymentSystem::all() as $p)
                                            <option value="{{ $p->id }}"{{ $transaction->payment_system_id == $p->id ? ' selected' : '' }}>{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="transactionAmount">{{ __('Amount') }}</label>
                                    <input type="number" step="any" class="form-control" name="transaction[amount]" id="transactionAmount" value="{{ amountWithPrecision($transaction->amount, $transaction->currency) }}">
                                </div>

                                <div class="form-group">
                                    <label for="transactionPaymentSystemId">{{ __('Wallet_ID') }}</label>
                                    <select class="form-control" name="transaction[wallet_id]" id="transactionWalletId">
                                        @foreach(\App\Models\Wallet::all() as $w)
                                            <option value="{{ $w->id }}"{{ $transaction->wallet_id == $w->id ? ' selected' : '' }}>{{ $w->id }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="transactionBatchId">{{ __('Batch') }}</label>
                                    <input type="text" class="form-control" name="transaction[batch_id]" id="transactionBatchId" value="{{ $transaction->batch_id }}">
                                </div>

                                <div class="form-group">
                                    <label for="transactionBatchId">{{ __('Transaction_verified') }}</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="transaction[approved]" value="1" id="transactionApproved" {{ $transaction->approved == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="transactionApproved">&nbsp;</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="transactionResult">{{ __('Payment_system_answer') }}</label>
                                    <textarea class="form-control" id="transactionResult" name="transaction[result]" rows="5">{{ $transaction->result }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="transactionCreatedAt">{{ __('Creation date') }}</label>
                                    <input type="datetime-local" class="form-control" name="transaction[created_at]" id="transactionCreatedAt" value="{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.finance.transactions.destroy', ['id' => $transaction->id]) }}')">
                                    {{ __('Delete_transaction') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#transactionUserId').select2();
            $('#transactionTypeId').select2();
            $('#transactionCurrencyId').select2();
            $('#transactionPaymentSystemId').select2();
            $('#transactionWalletId').select2();
        });
    </script>
@endsection