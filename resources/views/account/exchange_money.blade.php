@extends('layouts.account')
@section('title', __('Exchange_funds'))

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
        <div class="payment_transfer_Wrapper float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper heading_center">
                        <h3>@yield('title')</h3>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-sm-12 col-12">
                    <div class="change_password_wrapper float_left">
                        <div class="change_pass_field float_left">
                            @include('account.blocks.notification')

                            <form action="{{ route('account.exchange-money.handle') }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <input type="hidden" id="rateVal" value="0">

                                <div class="form-group">
                                    <label for="wallet_from_id">{{ __('The_wallet_from_which_the_exchange_is_carried_out') }}:</label>
                                    <select class="form-control" name="wallet_from_id" id="wallet_from_id">
                                        @foreach(auth()->user()->wallets()->get() as $wallet)
                                            <option value="{{ $wallet->id }}">{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }} : {{ amountWithPrecision($wallet->balance, $wallet->currency) }}{{ $wallet->currency->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">{{ __('Exchange_amount') }}:</label>
                                    <input class="form-control" type="number" step="any" name="amount" id="amount" placeholder="0" value="0">
                                </div>

                                <div class="form-group">
                                    <label for="wallet_to_id">{{ __('Recipient_wallet') }}:</label>
                                    <select class="form-control" name="wallet_to_id" id="wallet_to_id">
                                        @foreach(auth()->user()->wallets()->get() as $wallet)
                                            <option value="{{ $wallet->id }}">{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }} : {{ amountWithPrecision($wallet->balance, $wallet->currency) }}{{ $wallet->currency->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amountReceive">{{ __('Amount_to_receive') }}:</label>
                                    <input class="form-control" type="number" step="any" readonly name="amountReceive" id="amountReceive" placeholder="0" value="0">
                                </div>

                                <div class="form-group">
                                    <p class="help" style="display: none; font-weight: bold; color:red;" id="jsonMessage"></p>
                                    <p class="help">{{ __('Exchange_rate') }}: <span id="rateInfo"></span></p>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" id="exchangeSubmit" value="{{ __('exchange_funds') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  profile wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection

@section('js')
    <script>
        function calculateExchange()
        {
            $(document).ready(function(){
                var valFrom = $('#wallet_from_id').val();
                var valTo = $('#wallet_to_id').val();

                $('#exchangeSubmit').attr('disabled', 'disabled');
                $('#jsonMessage').fadeOut(0);

                $.ajax({
                    type:'GET',
                    url:'{{ route('json.get_exchange_rate_by_wallet') }}',
                    data:'_token={{ csrf_token() }}&from='+valFrom+'&to='+valTo,
                    success:function(content){
                        if(content.message.length) {
                            $('#jsonMessage').fadeIn(0).html(content.message);

                            if (content.error == 1) {
                                $('#jsonMessage').css('color', 'red');
                            } else {
                                $('#jsonMessage').css('color', 'green');
                            }
                        }
                        var rate = 1;

                        if (content.rate > 0) {
                            rate = content.rate;
                        }

                        $('#rateInfo').html(rate);
                        $('#rateVal').val(rate);

                        var amount = $('#amount').val();
                        $('#amountReceive').val(amount*rate);

                        if (content.error != 1) {
                            $('#exchangeSubmit').removeAttr('disabled');
                        }
                    },
                });
            });
        }

        $(document).ready(function(){
            $('#wallet_from_id').change(function(){
                calculateExchange();
            });
            $('#wallet_to_id').change(function(){
                calculateExchange();
            });
            $('#wallet_from_id').first().change();

            $('#amount').keyup(function(){
                calculateExchange();
            });
        });
    </script>
@endsection