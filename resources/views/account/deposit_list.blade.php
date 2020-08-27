@extends('layouts.account')
@section('title', __('List_of_active_deposits'))

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

                        <h3>{{ __('List_of_active_deposits') }}</h3>

                    </div>
                </div>
                @if($deposits->count() > 0)
                    <table class="table table-striped table-bordered mt-4">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Investment') }}</th>
                            <th scope="col">{{ __('Rate') }}</th>
                            <th scope="col">{{ __('Next_accrual') }}</th>
                            <th scope="col">{{ __('Created') }}</th>
                            <th scope="col">{{ __('Datetime_closing') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deposits as $deposit)
                            <tr>
                                <td>
                                    {{ $deposit->id }}
                                </td>
                                <td>{{ amountWithPrecision($deposit->invested, $deposit->currency) }}{{ $deposit->currency->symbol }}</td>
                                <td>{{ $deposit->rate->name }}</td>
                                <td>
                                    <?php
                                    $nextAccrual = \App\Models\DepositQueue::where('deposit_id', $deposit->id)
                                        ->where('type', \App\Models\DepositQueue::TYPE_ACCRUE)
                                        ->where('done', 0)
                                        ->orderBy('available_at')
                                        ->limit(1)
                                        ->first();
                                    ?>
                                    {{ null !== $nextAccrual ? __('after').' '.\Carbon\Carbon::parse($nextAccrual->available_at)->diffInHours().' '.__('h.') : __('undefined') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($deposit->created_at)->format('Y-m-d H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($deposit->datetime_closing)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {!! $deposits->appends(request()->input())->links() !!}
                @else
                    <div class="col-lg-12">
                        <div class="alert alert-secondary" role="alert">
                            <div class="iq-alert-icon">
                                <i class="ri-information-line"></i>
                            </div>
                            <div class="iq-alert-text">{{ __('Active_deposits_not_found') }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--  transactions wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection