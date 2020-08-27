<!--  my account wrapper start -->
<div class="account_top_information">
    <div class="account_overlay"></div>
    <div class="useriimg"><img src="/assets/images/user.png" alt="users"></div>
    <div class="userdet uderid">
        <h3>{{ auth()->user()->login }}</h3>

        <dl class="userdescc">
            <dt>{{ __('Register_date') }}</dt>
            <dd>: {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d-m-Y H:i') }}</dd>
            <dt>{{ __('Last_login') }}</dt>
            @php($lastLogin = \App\Models\ActionLog::where('user_id', auth()->user()->id)->where('action', 'login')->orderBy('created_at', 'desc')->skip(1)->first())
            <dd>: {{ $lastLogin !== null ? \Carbon\Carbon::parse($lastLogin->created_at)->format('d-m-Y H:i') : __('first_login') }}</dd>
            @php($currentLogin = \App\Models\ActionLog::where('user_id', auth()->user()->id)->where('action', 'login')->orderBy('created_at', 'desc')->first())
            <dt>{{ __('current_login') }}</dt>
            <dd>: {{ $currentLogin !== null ? \Carbon\Carbon::parse($currentLogin->created_at)->format('d-m-Y H:i') : '...' }}</dd>
            <dt>{{ __('Last_IP') }}</dt>
            <dd>: {{ $lastLogin !== null ? $lastLogin->user_ip : __('undefined') }}</dd>
            <dt>{{ __('Current_IP') }}</dt>
            <dd>: {{ $currentLogin !== null ? $currentLogin->user_ip : __('undefined') }}</dd>

        </dl>

    </div>

    <div class="userdet user_transcation">
        <h3>{{ __('Available_balances') }}</h3>
        <dl class="userdescc">
            @foreach(auth()->user()->wallets()->limit(6)->get() as $wallet)
            <dt>{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }}</dt>
            <dd>:&nbsp;&nbsp;$ {{ amountWithPrecision($wallet->balance, $wallet->currency) }}</dd>
            @endforeach
        </dl>
    </div>
    <div class="userdet user_transcation">
        <h3 class="none_headung"> &nbsp;</h3>
        <dl class="userdescc">
            @foreach(auth()->user()->wallets()->skip(6)->limit(6)->get() as $wallet)
                <dt>{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }}</dt>
                <dd>:&nbsp;&nbsp;$ {{ amountWithPrecision($wallet->balance, $wallet->currency) }}</dd>
            @endforeach
        </dl>

    </div>

</div>
<!--  my account wrapper end -->