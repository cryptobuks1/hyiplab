<!--investment plan wrapper start -->
<div class="investment_plans index2_investment_plans index3_investment_plans float_left">

    <div class="container">
        <div class="row">

            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="sv_heading_wraper heading_wrapper_dark dark_heading index2_heading index2_heading_center index3_heading ">
                    <h4> {{ __('rates') }} </h4>
                    <h3>{{ __('our_rates') }} </h3>
                    <div class="line_shape line_shape2"></div>
                </div>
            </div>
            @foreach(\App\Models\Rate::orderBy('min')->limit(4)->get() as $rate)
                <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6 col-12">
                    <div class="investment_box_wrapper index2_investment_box_Wraper index3_investment_box_Wraper float_left">
                        <img src="/assets/images/in{{ ($loop->index+1) }}.png" alt="img">
                        <div class="investment_icon_circle">
                            @if($loop->index+1 == 1)
                                <i class="flaticon-bar-chart"></i>
                            @elseif($loop->index+1 == 2)
                                <i class="flaticon-money"></i>
                            @elseif($loop->index+1 == 3)
                                <i class="fas fa-calendar-alt"></i>
                            @elseif($loop->index+1 == 4)
                                <i class="flaticon-gold"></i>
                            @endif
                        </div>
                        <div class="investment_border_wrapper"></div>
                        <div class="investment_content_wrapper">
                            <h1><a href="{{ route('register') }}">{{ $rate->name }}</a></h1>
                            <div class="line_shape line_shape2"></div>
                            <p>{{ __('Min_investment') }}: {{ amountWithPrecisionByCurrencyCode($rate->min, 'USD') }}{{ $rate->currency->symbol }}
                                <br>{{ __('Max_investment') }} : {{ amountWithPrecisionByCurrencyCode($rate->max, 'USD') }}{{ $rate->currency->symbol }}
                                <br> {{ __('Currency') }}: {{ $rate->currency->code }}
                                <br> {{ __('percent_earnings_per_day') }}: {{ $rate->daily }}
                                <br> {{ __('Duration') }}: {{ $rate->duration }} {{ __('days') }}
                                <br> {{ __('Body_return') }}: {{ $rate->payout }}%
                                <br> {{ __('Autoclose') }}: {{ $rate->autoclose == 1 ? __('yes') : __('no') }}</p>
                        </div>
                        <div class="about_btn plans_btn index2_investment_btn">
                            <ul>
                                <li>
                                    <a href="{{ route('customer.investment') }}">{{ __('more_details') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="btm_investment_wrapper float_left">
    <div class="investment_overlay"></div>
</div>
<!--investment plan wrapper end -->