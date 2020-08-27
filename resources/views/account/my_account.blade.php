@extends('layouts.account')
@section('title', __('My_account'))

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
        <!--  account wrapper start -->
        <div class="account_wrapper float_left">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>@yield('title')</h3>

                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                    <div class="investment_box_wrapper color_1 float_left">
                        <a href="#">
                            <div class="investment_icon_wrapper float_left">
                                <i class="far fa-money-bill-alt"></i>
                                <h1>{{ __('deposits') }}</h1>
                            </div>

                            <div class="invest_details float_left">
                                <table class="invest_table">
                                    <tbody>
                                    <tr>
                                        <td class="invest_td1">{{ __('Active_deposits') }}</td>
                                        <td class="invest_td1"> : {{ amountWithPrecisionByCurrencyCode($activeDeposits, 'USD') }} USD</td>
                                    </tr>
                                    <tr>
                                        <td class="invest_td1">{{ __('Closed_deposits') }}</td>
                                        <td class="invest_td1">: {{ amountWithPrecisionByCurrencyCode($closedDeposits, 'USD') }} USD</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                    <div class="investment_box_wrapper color_2 float_left">
                        <a href="#">
                            <div class="investment_icon_wrapper float_left">
                                <i class="far fa-money-bill-alt"></i>
                                <h1>{{ __('withdrawals') }}</h1>
                            </div>

                            <div class="invest_details float_left">
                                <table class="invest_table">
                                    <tbody>
                                    <tr>
                                        <td class="invest_td1">{{ __('pending') }}</td>
                                        <td class="invest_td1"> : {{ amountWithPrecisionByCurrencyCode($pendingWithdrawals, 'USD') }} USD</td>
                                    </tr>
                                    <tr>
                                        <td class="invest_td1">{{ __('success') }}</td>
                                        <td class="invest_td1">: {{ amountWithPrecisionByCurrencyCode($successWithdrawals, 'USD') }} USD</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                    <div class="investment_box_wrapper color_3 float_left">
                        <a href="#">
                            <div class="investment_icon_wrapper float_left">
                                <i class="far fa-money-bill-alt"></i>
                                <h1>{{ __('earnings') }}</h1>
                            </div>

                            <div class="invest_details float_left">
                                <table class="invest_table">
                                    <tbody>
                                    <tr>
                                        <td class="invest_td1">{{ __('today') }}</td>
                                        <td class="invest_td1">: {{ amountWithPrecisionByCurrencyCode($todayEarnings, 'USD') }} USD</td>
                                    </tr>
                                    <tr>
                                        <td class="invest_td1">{{ __('current_week') }}</td>
                                        <td class="invest_td1">: {{ amountWithPrecisionByCurrencyCode($thisWeekEarnings, 'USD') }} USD</td>
                                    </tr>
                                    <tr>
                                        <td class="invest_td1">{{ __('this_month') }}</td>
                                        <td class="invest_td1">: {{ amountWithPrecisionByCurrencyCode($thisMonthEarnings, 'USD') }} USD</td>
                                    </tr>
                                    <tr>
                                        <td class="invest_td1">{{ __('total') }}</td>
                                        <td class="invest_td1">: {{ amountWithPrecisionByCurrencyCode($totalEarnings, 'USD') }} USD</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 col-12">
                    <div class="investment_box_wrapper color_5 float_left">
                        <a href="#">
                            <div class="investment_icon_wrapper float_left">
                                <i class="far fa-money-bill-alt"></i>
                                <h1>{{ __('referrals') }}</h1>
                            </div>

                            <div class="invest_details float_left">
                                <table class="invest_table">
                                    <tbody>
                                    <tr>
                                        <td class="invest_td1">{{ __('today') }}</td>
                                        <td class="invest_td1">: +{{ $todayReferrals }} ({{ amountWithPrecisionByCurrencyCode($todayReferralsEarnings, 'USD') }}$)</td>
                                    </tr>
                                    <tr>
                                        <td class="invest_td1">{{ __('this_week') }}</td>
                                        <td class="invest_td1">: +{{ $thisWeekReferrals }} ({{ amountWithPrecisionByCurrencyCode($thisWeekReferralsEarnings,'USD') }}$)</td>
                                    </tr>
                                    <tr>
                                        <td class="invest_td1">{{ __('total') }}</td>
                                        <td class="invest_td1">: {{ $totalReferrals }} ({{ amountWithPrecisionByCurrencyCode($totalReferralsEarnings, 'USD') }}$)</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--  account wrapper end -->
        <!--  transactions wrapper start -->
        <div class="last_transaction_wrapper float_left">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>{{ __('Latest_operations') }}</h3>

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
        <!--  transactions wrapper end -->

        @include('account.blocks.footer')
    </div>
@endsection