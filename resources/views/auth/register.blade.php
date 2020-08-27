@extends('layouts.customer')
@section('title', __('Registration'))

@section('content')
    @include('customer.blocks.loader')
    @include('customer.blocks.menu')

    <div class="cp_navi_main_wrapper inner_header_wrapper float_left">
        <div class="container-fluid">
            @include('customer.blocks.logo')
            @include('customer.blocks.header')
            @include('customer.blocks.top_header_right')
            @include('customer.blocks.cp_navigation')
        </div>
    </div>

    <!-- navi wrapper End -->
    <!-- inner header wrapper start -->
    <div class="page_title_section">

        <div class="page_header">
            <div class="container">
                <div class="row">

                    <div class="col-lg-9 col-md-9 col-12 col-sm-8">

                        <h1>{{ __('Registration') }}</h1>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 col-sm-4">
                        <div class="sub_title_section">
                            <ul class="sub_title">
                                <li> <a href="{{ route('customer.main') }}"> {{ __('Home') }} </a>&nbsp; / &nbsp; </li>
                                <li>{{ __('Registration') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- inner header wrapper end -->
    <!-- login wrapper start -->
    <div class="login_wrapper fixed_portion float_left">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @include('customer.blocks.notification')

                    <div class="login_top_box float_left">
                        <div class="login_banner_wrapper register_banner_wrapper">
                            <img src="/assets/images/logo2.png" style="max-width:200px;" alt="logo">
                            <div class="about_btn  facebook_wrap float_left">

                                <a href="#">{{ __('Register_via_facebook') }} <i class="fab fa-facebook-f"></i></a>

                            </div>
                            <div class="about_btn google_wrap float_left">

                                <a href="#">{{ __('Register_via_Pinterest') }} <i class="fab fa-pinterest-p"></i></a>

                            </div>
                            <div class="jp_regis_center_tag_wrapper jb_register_red_or">
                                <h1>{{ __('OR') }}</h1>
                            </div>
                        </div>
                        <div class="login_form_wrapper register_wrapper">
                            <form method="POST" action="{{ route('register') }}" target="_top">
                                {{ csrf_field() }}

                                <div class="sv_heading_wraper heading_wrapper_dark dark_heading hwd">

                                    <h3> {{ __('Create_new_account') }}</h3>

                                </div>
                                <div class="form-group icon_form comments_form register_contact">

                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ __('Your_name') }}" required autofocus>

                                </div>
                                <div class="form-group icon_form comments_form register_contact">

                                    <input id="email" type="email" class="form-control" name="email" placeholder="{{ __('Your_email') }}" value="{{ old('email') }}" required>

                                </div>
                                <div class="form-group icon_form comments_form register_contact">

                                    <input id="login" type="text" class="form-control" name="login" placeholder="{{ __('Your_login') }}" value="{{ old('login') }}">

                                </div>
                                <div class="form-group icon_form comments_form register_contact">

                                    <input id="password" type="password" class="form-control" placeholder="{{ __('Your_password') }}" name="password" required>

                                </div>
                                <div class="form-group icon_form comments_form register_contact">

                                    <input id="password-confirm" type="password" class="form-control" placeholder="{{ __('Confirm_password') }}" name="password_confirmation" required>

                                </div>

                                <div class="login_remember_box">
                                    <label class="control control--checkbox">{{ __('I_agree_with_the_user_agreement') }}
                                        <input type="checkbox" id="agreement" name="agreement" value="1" checked>
                                        <span class="control__indicator"></span>
                                    </label>

                                </div>
                                <div class="about_btn login_btn register_btn float_left">

                                    <input type="submit" class="btn btn-primary" value="{{ __('register') }}" style="display:block; width:100%;">
                                </div>
                                <div class="about_btn login_btn register_btn float_left">

                                    <input type="submit" class="btn btn-outline-info" value="{{ __('or_login') }}" style="display:block; width:100%;">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login wrapper end -->

    @include('customer.wrappers.payments')
    @include('customer.blocks.footer')
@endsection
