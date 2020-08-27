<div class="top_header_right_wrapper dashboard_right_Wrapper">
    <div class="crm_profile_dropbox_wrapper">
        <div class="nice-select" tabindex="0"> <span class="current"><img src="/assets/images/avatar.png" alt="img"> {{ __('Hello') }}, {{ auth()->user()->login }} ! <span class="hidden_xs_content"></span></span>
            <ul class="list">
                @if(auth()->guard('admin')->user())
                <li><a href="{{ route('admin.dashboard') }}">{{ __('Admin_panel') }}</a></li>
                @endif
                @impersonating
                <li><a href="{{ route('impersonate.leave') }}">{{ __('Come_back_to_panel') }}</a></li>
                @endImpersonating
                <li><a href="{{ route('account.my-account') }}">{{ __('My_account') }}</a></li>
                <li><a href="{{ route('user.logout') }}"><i class="flaticon-turn-off"></i> {{ __('Logout') }}</a></li>
            </ul>
        </div>
    </div>
</div>