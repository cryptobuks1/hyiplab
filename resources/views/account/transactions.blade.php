@extends('layouts.account')
@section('title', __('Transactions'))

@section('content')
    @include('account.blocks.loader')
    @include('account.blocks.cp_navigation')

    <div class="cp_navi_main_wrapper inner_header_wrapper dashboard_header_middle float_left">
        <div class="container-fluid">
            @include('account.blocks.logo')
            @include('account.blocks.header')
            @include('account.blocks.top_header_right_wrapper')
            @include('account.blocks.menu')
        </div>
    </div>

    @include('account.blocks.dashboard_title')
    @include('account.blocks.sidebar')

    <!-- Main section Start -->
    <div class="l-main">
    @include('account.blocks.account_info')
        <!--  transactions wrapper start -->
        <div class="last_transaction_wrapper float_left">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>@yield('title')</h3>

                    </div>
                </div>
                <div class="crm_customer_table_main_wrapper float_left">
                    @if($transactions->count() > 0)
                        <table class="table table-striped table-bordered mt-4">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Payment_System') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Type') }}</th>
                                <th scope="col">{{ __('Batch') }}</th>
                                <th scope="col">{{ __('Verified') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ $transaction->id }}
                                    </td>
                                    <td>{{ $transaction->paymentSystem->name }}</td>
                                    <td>{{ amountWithPrecision($transaction->amount, $transaction->currency) }}{{ $transaction->currency->symbol }}</td>
                                    <td>{{ $transaction->type->name }}</td>
                                    <td>{!! !empty($transaction->batch_id) ? '<input type="text" value="'.$transaction->batch_id.'" readonly>' : '<span class="badge border border-warning text-warning">'.__('no_batch').'</span>' !!}</td>
                                    <td>{!! $transaction->approved ? '<span class="badge badge-success">'.__('yes').'</span>' : '<span class="badge badge-danger">'.__('no').'</span>' !!}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toDateTimeString() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! $transactions->appends(request()->input())->links() !!}
                    @else
                        <div class="col-lg-12">
                            <div class="alert alert-secondary" role="alert">
                                <div class="iq-alert-icon">
                                    <i class="ri-information-line"></i>
                                </div>
                                <div class="iq-alert-text">{{ __('No_transactions_found') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!--  transactions wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection