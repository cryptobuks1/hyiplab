@extends('layouts.account')
@section('title', __('Funds_transfer'))

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

                            <form action="{{ route('account.transfer-fund.handle') }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="wallet_from_id">{{ __('The_wallet_from_which_the_transfer_is_made') }}:</label>
                                    <select class="form-control" name="wallet_from_id" id="wallet_from_id">
                                        @foreach(auth()->user()->wallets()->get() as $wallet)
                                            <option value="{{ $wallet->id }}">{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }} : {{ amountWithPrecision($wallet->balance, $wallet->currency) }}{{ $wallet->currency->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">{{ __('Send_amount') }}:</label>
                                    <input class="form-control" type="number" step="any" name="amount" id="amount" placeholder="0" value="0">
                                </div>

                                <div class="form-group">
                                    <label for="addressee">{{ __('Login_or_email_of_the_recipient') }}:</label>
                                    <input class="form-control" type="text" name="addressee" id="addressee">
                                </div>

                                <div class="form-group">
                                    <p class="help" id="jsonMessage" style="display: none; color:red; font-weight: bold;"></p>
                                    <p class="help">{{ __('The_recipient_receives_the_same_amount_of_sending_to_the_same_wallet') }}</p>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" id="transferSubmit" value="{{ __('send_transfer') }}">
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
        function checkSend()
        {
            $(document).ready(function(){
                var valFrom = $('#wallet_from_id').val();

                $('#transferSubmit').attr('disabled', 'disabled');
                $('#jsonMessage').fadeOut(0);

                $.ajax({
                    type:'GET',
                    url:'{{ route('json.get_user_exists_by_email_or_login') }}',
                    data:'_token={{ csrf_token() }}&data='+$('#addressee').val(),
                    success:function(content){
                        if(content.message.length) {
                            $('#jsonMessage').fadeIn(0).html(content.message);

                            if (content.error == 1) {
                                $('#jsonMessage').css('color', 'red');
                            } else {
                                $('#jsonMessage').css('color', 'green');
                            }
                        }

                        if (content.error != 1) {
                            $('#transferSubmit').removeAttr('disabled');
                        }
                    },
                });
            });
        }

        $(document).ready(function(){
            $('#wallet_from_id').change(function(){
                checkSend();
            });
            $('#wallet_from_id').first().change();

            $('#amount').change(function(){
                checkSend();
            });

            $('#addressee').change(function(){
                checkSend();
            });
        });
    </script>
@endsection