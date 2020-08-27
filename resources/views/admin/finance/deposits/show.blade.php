@extends('admin.app')
@section('title', __('Deposit_details'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.finance.deposits.index') }}">{{ __('Deposits') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Deposit_details') }}: {{ $deposit->id }}</li>
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
                                <h4 class="card-title">{{ __('Deposit_details') }}: {{ $deposit->id }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.finance.deposits.update', ['id' => $deposit->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $deposit->id }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="depositAutoclose">{{ __('Autoclose') }}</label>
                                    @if($deposit->autoclose == 1)
                                        <div class="badge badge-pill badge-success">{{ __('yes') }}</div>
                                    @else
                                        <div class="badge badge-pill badge-warning">{{ __('no') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="depositUserId">{{ __('User') }}</label>
                                    <select class="form-control" name="deposit[user_id]" id="depositUserId">
                                        @foreach(\App\Models\User::all() as $u)
                                            <option value="{{ $u->id }}"{{ $deposit->user_id == $u->id ? ' selected' : '' }}>{{ $u->login }} - {{ $u->email }} [{{ __('ref_link') }}: {{ $u->my_id }}]</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="depositCurrencyId">{{ __('Currency') }}</label>
                                    <select class="form-control" name="deposit[currency_id]" id="depositCurrencyId">
                                        @foreach(\App\Models\Currency::all() as $c)
                                            <option value="{{ $c->id }}"{{ $deposit->currency_id == $c->id ? ' selected' : '' }}>{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="depositAmount">{{ __('Deposit_body') }}</label>
                                    <input type="number" step="any" class="form-control" name="deposit[invested]" id="depositAmount" value="{{ amountWithPrecision($deposit->invested, $deposit->currency) }}">
                                </div>

                                <div class="form-group">
                                    <label for="depositBalance">{{ __('Deposit_balance_with_accruals') }}</label>
                                    <input type="number" step="any" class="form-control" name="deposit[balance]" id="depositBalance" value="{{ amountWithPrecision($deposit->balance, $deposit->currency) }}">
                                </div>

                                <div class="form-group">
                                    <label for="depositPercent">{{ __('accrual_for_1_cycle') }}</label>
                                    <input type="number" step="any" class="form-control" name="deposit[daily]" id="depositPercent" value="{{ $deposit->daily }}">
                                </div>

                                <div class="form-group">
                                    <label for="depositPaymentSystemId">{{ __('Wallet_ID') }}</label>
                                    <select class="form-control" name="deposit[wallet_id]" id="depositWalletId">
                                        @foreach(\App\Models\Wallet::all() as $w)
                                            <option value="{{ $w->id }}"{{ $deposit->wallet_id == $w->id ? ' selected' : '' }}>{{ $w->id }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="depositActive">{{ __('Deposit_active') }}</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="deposit[active]" value="1" id="depositActive" {{ $deposit->active == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="depositActive">&nbsp;</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="depositCreatedAt">{{ __('Creation date') }}</label>
                                    <input type="datetime-local" class="form-control" name="deposit[created_at]" id="depositCreatedAt" value="{{ \Carbon\Carbon::parse($deposit->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.finance.deposits.destroy', ['id' => $deposit->id]) }}')">
                                    {{ __('Delete_deposit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Accruals_planner') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            @if($deposit->queues()->count() > 0)
                                <table class="table table-striped table-dark">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Accrual_date') }}</th>
                                        <th scope="col">{{ __('Sent_to_handler') }}</th>
                                        <th scope="col">{{ __('Handled') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($queues as $queue)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($queue->available_at)->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if($queue->fired == 1)
                                                    <div class="badge badge-pill badge-success">{{ __('yes') }}</div>
                                                @else
                                                    <div class="badge badge-pill badge-warning">{{ __('no') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($queue->done == 1)
                                                    <div class="badge badge-pill badge-success">{{ __('yes') }}</div>
                                                @else
                                                    <div class="badge badge-pill badge-warning">{{ __('no') }}</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $queues->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-light" role="alert">
                                    <div class="iq-alert-icon">
                                        <i class="ri-alert-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('Planned_accruals_not_found') }}</div>
                                </div>
                            @endif
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
            $('#depositUserId').select2();
            $('#depositCurrencyId').select2();
            $('#depositWalletId').select2();
        });
    </script>
@endsection