<div class="l-sidebar">
    <div class="l-sidebar__content">
        <nav class="c-menu js-menu" id="mynavi">
            <ul class="u-list crm_drop_second_ul">
                <li class="crm_navi_icon">
                    <div class="c-menu__item__inner"><a href="{{ route('account.my-account') }}"><i class="flaticon-four-grid-layout-design-interface-symbol"></i></a>
                        <ul class="crm_hover_menu">

                        </ul>
                    </div>
                </li>
                <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                    <a href="{{ route('account.my-account') }}">
                        <div class="c-menu-item__title"><span>{{ __('Account') }}</span></div>
                    </a>
                    <ul>
                        <li><a href="{{ route('account.my-account') }}"><i class="fa fa-circle"></i> {{ __('my_account') }}</a>
                        </li>
                        <li><a href="{{ route('account.profile') }}"><i class="fa fa-circle"></i> {{ __('my_profile') }}</a>
                        </li>
                        <li><a href="{{ route('account.email-notification') }}"><i class="fa fa-circle"></i>{{ __('email_notifications') }}</a>
                        </li>
                        <li><a href="{{ route('account.change-password') }}"><i class="fa fa-circle"></i>{{ __('change_password') }}</a>
                        </li>
                        <li><a href="{{ route('account.change-pin') }}"><i class="fa fa-circle"></i>{{ __('change_pin') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="u-list crm_drop_second_ul">
                <li class="crm_navi_icon">
                    <div class="c-menu__item__inner"><a href="{{ route('account.make-deposit') }}"><i class="flaticon-movie-tickets"></i></a>
                        <ul class="crm_hover_menu">

                        </ul>
                    </div>
                </li>
                <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                    <a href="{{ route('account.make-deposit') }}">
                        <div class="c-menu-item__title"><span>{{ __('Finances') }}</span></div>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('account.make-deposit') }}"> <i class="fa fa-circle"></i>{{ __('create_deposit') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('account.deposit-list') }}"> <i class="fa fa-circle"></i> {{ __('deposits_list') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('account.payment-request') }}"> <i class="fa fa-circle"></i> {{ __('request_payment') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('account.exchange-money') }}"> <i class="fa fa-circle"></i>{{ __('exchange_funds') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('account.transfer-fund') }}"> <i class="fa fa-circle"></i>{{ __('send_transfer') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="u-list crm_drop_second_ul">
                <li class="crm_navi_icon">
                    <div class="c-menu__item__inner"><a href="{{ route('account.transactions') }}"><i class="flaticon-help"></i></a>
                        <ul class="crm_hover_menu">
                        </ul>
                    </div>
                </li>
                <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                    <a href="{{ route('account.transactions') }}">
                        <div class="c-menu-item__title"><span>{{ __('Reports') }}</span></div>
                    </a>
                    <ul>
                        <li><a href="{{ route('account.transactions') }}"><i class="fa fa-circle"></i> {{ __('all_transactions') }}</a>
                        </li>
                        <li><a href="{{ route('account.deposit-history') }}"><i class="fa fa-circle"></i>{{ __('deposits_history') }}</a>
                        </li>
                        <li><a href="{{ route('account.pending-history') }}"><i class="fa fa-circle"></i>{{ __('withdrawals_history') }}</a>
                        </li>
                        <li><a href="{{ route('account.exchange-history') }}"><i class="fa fa-circle"></i>{{ __('exchange_history') }}</a>
                        </li>
                        <li><a href="{{ route('account.earnings-history') }}"><i class="fa fa-circle"></i>{{ __('earnings_history') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
{{--            <ul class="u-list crm_drop_second_ul">--}}
{{--                <li class="crm_navi_icon">--}}
{{--                    <div class="c-menu__item__inner"><a href="{{ route('account.tickets') }}"><i class="flaticon-file"></i></a>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--                <li class="c-menu__item crm_navi_icon_cont">--}}
{{--                    <a href="{{ route('account.tickets') }}">--}}
{{--                        <div class="c-menu-item__title">{{ __('tickets') }}</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
            <ul class="u-list crm_drop_second_ul">
                <li class="crm_navi_icon">
                    <div class="c-menu__item__inner"><a href="{{ route('account.referrals') }}"><i class="flaticon-settings"></i></a>
                        <ul class="crm_hover_menu">
                        </ul>
                    </div>
                </li>
                <li class="c-menu__item is-active has-sub crm_navi_icon_cont">
                    <a href="{{ route('account.referrals') }}">
                        <div class="c-menu-item__title"><span>{{ __('referrals') }}</span><i class="no_badge">{{ auth()->user()->referrals()->count() }}</i></div>
                    </a>
                    <ul>
                        <li><a href="{{ route('account.referrals') }}"><i class="fa fa-circle"></i> {{ __('my_referrals') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('account.banners') }}"> <i class="fa fa-circle"></i>{{ __('promo_banners') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('account.referral-earnings') }}"> <i class="fa fa-circle"></i>{{ __('referral_earnings') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="u-list crm_drop_second_ul">
                <li class="crm_navi_icon">
                    <div class="c-menu__item__inner"><a href="{{ route('account.make-deposit') }}"><i class="flaticon-profile"></i></a>
                    </div>
                </li>
                <li class="c-menu__item crm_navi_icon_cont">
                    <a href="{{ route('logout') }}">
                        <div class="c-menu-item__title">{{ __('logout') }}</div>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>