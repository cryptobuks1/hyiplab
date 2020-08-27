@extends('layouts.account')
@section('title', __('Email_notifications'))

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
        <!--  email wrapper start -->
        <div class="email_notifcation_wrapper float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>@yield('title')</h3>

                    </div>
                </div>
            </div>
            <form action="{{ route('account.email-notification') }}" method="POST" target="_top" style="width:100%;">
                {{ csrf_field() }}

                @include('account.blocks.notification')

                <div class="row">
                    <div class="col-lg-3">
                        <ul class="job_field">
                            <li>
                                <input type="checkbox" id="c1" value="on" name="notification[login]"{{ auth()->user()->getNotificationSettings('login') == 'on' ? ' checked' : '' }}>
                                <label for="c1">{{ __('Login_to_account') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c2" value="on" name="notification[create_dep]"{{ auth()->user()->getNotificationSettings('create_dep') == 'on' ? ' checked' : '' }}>
                                <label for="c2">{{ __('Deposit_creation') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c3" value="on" name="notification[deposit_earnings]"{{ auth()->user()->getNotificationSettings('deposit_earnings') == 'on' ? ' checked' : '' }}>
                                <label for="c3">{{ __('Deposit_earnings') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c4" value="on" name="notification[deposit_close]"{{ auth()->user()->getNotificationSettings('deposit_close') == 'on' ? ' checked' : '' }}>
                                <label for="c4">{{ __('Closing_deposit') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c5" value="on" name="notification[withdraw_order]"{{ auth()->user()->getNotificationSettings('withdraw_order') == 'on' ? ' checked' : '' }}>
                                <label for="c5">{{ __('Withdraw_order') }}</label>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3">
                        <ul class="job_field">
                            <li>
                                <input type="checkbox" id="c6" value="on" name="notification[withdraw_confirmation]"{{ auth()->user()->getNotificationSettings('withdraw_confirmation') == 'on' ? ' checked' : '' }}>
                                <label for="c6">{{ __('Withdrawal_confirmation') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c7" value="on" name="notification[change_settings]"{{ auth()->user()->getNotificationSettings('change_settings') == 'on' ? ' checked' : '' }}>
                                <label for="c7">{{ __('Settings_changed') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c8" value="on" name="notification[change_wallets]"{{ auth()->user()->getNotificationSettings('change_wallets') == 'on' ? ' checked' : '' }}>
                                <label for="c8">{{ __('Changing_requisites') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c9" value="on" name="notification[change_password]"{{ auth()->user()->getNotificationSettings('change_password') == 'on' ? ' checked' : '' }}>
                                <label for="c9">{{ __('Changing_password') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c10" value="on" name="notification[change_pincode]"{{ auth()->user()->getNotificationSettings('change_pincode') == 'on' ? ' checked' : '' }}>
                                <label for="c10">{{ __('Changing_pin_code') }}</label>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        <ul class="job_field">
                            <li>
                                <input type="checkbox" id="c11" value="on" name="notification[ref_registration]"{{ auth()->user()->getNotificationSettings('ref_registration') == 'on' ? ' checked' : '' }}>
                                <label for="c11">{{ __('Referral_registration') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c12" value="on" name="notification[ref_earnings]"{{ auth()->user()->getNotificationSettings('ref_earnings') == 'on' ? ' checked' : '' }}>
                                <label for="c12">{{ __('Referral_earnings') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c13" value="on" name="notification[transfer_in]"{{ auth()->user()->getNotificationSettings('transfer_in') == 'on' ? ' checked' : '' }}>
                                <label for="c13">{{ __('Notification_about_income_transfer') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c14" value="on" name="notification[password_reset]"{{ auth()->user()->getNotificationSettings('password_reset') == 'on' ? ' checked' : '' }}>
                                <label for="c14">{{ __('Notification_about_password_reset') }}</label>
                            </li>
                            <li>
                                <input type="checkbox" id="c15" value="on" name="notification[withdraw_cancellation]"{{ auth()->user()->getNotificationSettings('withdraw_cancellation') == 'on' ? ' checked' : '' }}>
                                <label for="c15">{{ __('Withdrawal_cancellation_by_administration') }}</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row" style="margin-top:20px;">
                    <div class="about_btn account_data_btn float_left">
                        <input type="submit" class="btn btn-primary" value="{{ __('save') }}">
                    </div>
                </div>
            </form>
        </div>
        <!--  email wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection