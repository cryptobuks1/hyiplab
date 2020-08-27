@extends('layouts.account')
@section('title', __('Change_password'))

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
        <div class="password_notify_wrapper float_left">
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

                            <form action="{{ route('account.change-password') }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="change_field">
                                    <label>{{ __('Current_password') }}:</label>
                                    <input type="password" name="password" placeholder="**********">
                                </div>
                                <div class="change_field">
                                    <label>{{ __('New_password') }}:</label>
                                    <input type="password" name="new_password" placeholder="**********">
                                </div>
                                <div class="change_field">
                                    <label>{{ __('Confirm_new_password') }}:</label>
                                    <input type="password" name="repeat_password" placeholder="**********">
                                </div>
                                <div class="about_btn float_left">
                                    <input type="submit" class="btn btn-primary" value="{{ __('change_password') }}">
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