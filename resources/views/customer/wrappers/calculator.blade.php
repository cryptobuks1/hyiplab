<!--calculator plan wrapper start -->
<div class="calculator_wrapper index2_calculator_wrapper index3_calculator_wrapper float_left">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-lg-12 col-sm-12 col-12">

                <div class="sv_heading_wraper heading_wrapper_dark dark_heading index2_heading index2_heading_center index3_heading ">
                    <h4> {{ __('calculate_profit') }} </h4>
                    <h3> {{ __('with_calculator') }} </h3>
                    <div class="line_shape line_shape2"></div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="calculator_portion index3_calc_portion float_left">
                    <section class="calculate">
                        <div class="container">
                            <div class="form-block animate">
                                <form>
                                    <div class="form-block__row">
                                        <div class="form-group">
                                            <label>{{ __('Rate') }}</label>
                                            <select class="form-control" id="calculatorRate">
                                                @foreach(\App\Models\Rate::orderBy('min')->get() as $rate)
                                                    <option value="{{ $rate->id }}">{{ $rate->name }} ({{ $rate->currency->code }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Investment_amount') }}</label>
                                            <input class="form-control" id="calculatorAmount" type="number" step="any" value="0" placeholder="0">
                                        </div>
                                        <button class="btn btn-primary">{{ __('Calculate') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group" style="margin-top:15px;">
                                <div class="alert alert-info">{{ __('Your_profit_will_be') }}: <span id="calculatorResult">0$</span></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="js-graph-trafficStatistics" style="height:500px;"></div>
            </div>

        </div>
    </div>
</div>
<!--calculator plan wrapper end -->