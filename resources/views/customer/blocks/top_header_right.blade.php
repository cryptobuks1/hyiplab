<div class="top_header_right_wrapper top_phonecalls">
    <p><i class="flaticon-phone-contact"></i> 443-702-6475</p>
    <div class="header_btn index3_header_btn">
        <ul>
            @if(!auth()->check())
                <li>
                    <a href="{{ route('register') }}"> {{ __('registration') }} </a>
                </li>
                <li>
                    <a href="{{ route('login') }}"> {{ __('login') }} </a>
                </li>
            @else
                <li>
                    <a href="{{ route('account.my-account') }}"> {{ __('my_account') }} </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"> {{ __('logout') }} </a>
                </li>
            @endif
        </ul>
    </div>
</div>