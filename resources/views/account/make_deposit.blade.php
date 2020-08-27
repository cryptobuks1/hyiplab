@extends('layouts.account')
@section('title', __('Create_deposit'))

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
        <!--  profile wrapper start -->
        <div class="plan_investment_wrapper float_left">
            @include('account.blocks.notification')

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>{{ __('Choose_rate') }}</h3>

                    </div>

                </div>
                @foreach(\App\Models\Rate::where('active', 1)->orderBy('min')->get() as $rate)
                <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6 col-12">
                    <div class="investment_box_wrapper sv_pricing_border float_left">
                        <div class="investment_icon_circle">
                            <i class="flaticon-movie-tickets"></i>
                        </div>
                        <div class="investment_border_wrapper"></div>
                        <div class="investment_content_wrapper">
                            <h1>{{ $rate->name }}</h1>
                            <p>{{ __('Min_investment') }}: {{ amountWithPrecisionByCurrencyCode($rate->min, 'USD') }}{{ $rate->currency->symbol }}
                                <br>{{ __('Max_investment') }} : {{ amountWithPrecisionByCurrencyCode($rate->max, 'USD') }}{{ $rate->currency->symbol }}
                                <br> {{ __('Currency') }}: {{ $rate->currency->code }}
                                <br> {{ __('percent_earnings_per_day') }}: {{ $rate->daily }}
                                <br> {{ __('Duration') }}: {{ $rate->duration }} {{ __('days') }}
                                <br> {{ __('Body_return') }}: {{ $rate->payout }}%
                                <br> {{ __('Autoclose') }}: {{ $rate->autoclose == 1 ? __('yes') : __('no') }}</p>
                        </div>
                        <div class="about_btn plans_btn">
                            <ul>
                                <li>
                                    <a href="#details" rate-id="{{ $rate->id }}" rate-name="{{ $rate->name }}" rate-min="{{ $rate->min }}" class="choosePlan">{{ __('choose_rate') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        <!--  profile wrapper end -->
        <!--  payment mode wrapper start -->
        <div class="payment_mode_wrapper">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3 id="details">{{ __('Details') }}</h3>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="investment_box_wrapper col-lg-6" style="text-align:left;">
                    <form action="{{ route('account.make-deposit.handle') }}" method="POST" target="_top">
                        {{ csrf_field() }}

                        <input type="hidden" name="rate_id" value="" id="rate_id">

                        <div class="form-group" id="rateContent" style="display:none;">
                            <div class="alert alert-success" role="alert">
                                <div class="iq-alert-icon">
                                    <i class="ri-alert-line"></i>
                                </div>
                                <div class="iq-alert-text" id="rateName"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="wallet_id">{{ __('Choose_wallet') }}:</label>
                            <select class="form-control" name="wallet_id" id="wallet_id">
                                @foreach(auth()->user()->wallets()->get() as $wallet)
                                    <option value="{{ $wallet->id }}">{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }}:
                                        {{ __('balance') }} {{ amountWithPrecision($wallet->balance, $wallet->currency) }}{{ $wallet->currency->symbol }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="amount">{{ __('Investment_amount') }}:</label>
                            <input type="number" step="any" name="amount" id="amount" class="form-control" value="0" placeholder="0">
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="pay_from">{{ __('Pay') }}:</label>
                            <select class="form-control" name="pay_from" id="pay_from">
                                <option value="payment_system">{{ __('With_payment_system') }}</option>
                                <option value="balance">{{ __('From_balance') }}</option>
                            </select>
                        </div>

                        <hr>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="{{ __('create_deposit') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <!--  payment mode wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.choosePlan').click(function(){
                $('#rate_id').val($(this).attr('rate-id'));
                $('#rateName').html('{{ __('Rate_selected') }}: '+$(this).attr('rate-name'));
                $('#amount').val($(this).attr('rate-min'));
                $('#rateContent').fadeIn(100);
            });
        });
    </script>
@endsection