@extends('layouts.account')
@section('title', __('Request_funds'))

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

                            <form action="{{ route('account.payment-request.handle') }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="wallet_id">{{ __('Choose_wallet') }}:</label>
                                    <select class="form-control" name="wallet_id" id="wallet_id">
                                        @foreach(auth()->user()->wallets()->get() as $wallet)
                                            <option value="{{ $wallet->id }}">{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }} : {{ amountWithPrecision($wallet->balance, $wallet->currency) }}{{ $wallet->currency->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">{{ __('Amount') }}:</label>
                                    <input class="form-control" type="number" step="any" name="amount" id="amount" placeholder="0" value="0">
                                </div>

                                <div class="form-group">
                                    <label for="external">{{ __('Wallet_address') }}:</label>
                                    <input class="form-control" type="text" name="external" id="external">
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="{{ __('order_funds') }}">
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
        $(document).ready(function(){
            $('#wallet_id').change(function(){
                var val = $(this).val();

                @foreach(auth()->user()->wallets()->get() as $wallet)
                    if (val == "{{ $wallet->id }}") {
                        $('#external').val("{{ $wallet->external }}");
                        $('#amount').val("{{ $wallet->balance }}");
                    }
                @endforeach
            });
            $('#wallet_id').first().change();
        });
    </script>
@endsection