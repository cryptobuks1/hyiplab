@extends('layouts.customer')
@section('title', __('Login'))

@section('content')
    @include('customer.blocks.demo-access')
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

                        <h1>{{ __('Login') }}</h1>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 col-sm-4">
                        <div class="sub_title_section">
                            <ul class="sub_title">
                                <li> <a href="{{ route('customer.main') }}"> {{ __('Main') }} </a>&nbsp; / &nbsp; </li>
                                <li>{{ __('login') }}</li>
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
                        <div class="login_banner_wrapper">
                            <img src="/assets/images/logo2.png" style="max-width:200px;" alt="logo">
                            <div class="about_btn  facebook_wrap float_left">

                                <a href="#">{{ __('Login_via_Facebook') }} <i class="fab fa-facebook-f"></i></a>

                            </div>
                            <div class="about_btn google_wrap float_left">

                                <a href="#">{{ __('Login_via_pinterest') }} <i class="fab fa-pinterest-p"></i></a>

                            </div>
                            <div class="jp_regis_center_tag_wrapper jb_register_red_or">
                                <h1>{{ __('OR') }}</h1>
                            </div>
                        </div>
                        <div class="login_form_wrapper">
                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="sv_heading_wraper heading_wrapper_dark dark_heading hwd">

                                    <h3> {{ __('with_credentials') }}</h3>

                                </div>

                                <div class="form-group icon_form comments_form">

                                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" placeholder="{{ __('Login') }}" required autofocus>

                                </div>
                                <div class="form-group icon_form comments_form">

                                    <input id="password" type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" required>

                                </div>
                                <div class="form-group icon_form comments_form">

                                    <div class="row">
                                        <div class="col-lg-5">
                                            <?= captcha_img() ?>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" name="captcha" id="captcha" placeholder="{{ __('Code_from_image') }}" class="form-control" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="login_remember_box">
                                    <label class="control control--checkbox">{{ __('Remember_me') }}
                                        <input type="checkbox" name="remember" checked="checked">
                                        <span class="control__indicator"></span>
                                    </label>
                                    <a href="{{ route('forgot_password.reset') }}" class="forget_password">
                                        {{ __('Forgot_password?') }}
                                    </a>
                                </div>
                                <div class="about_btn login_btn float_left">

                                    <input type="submit" class="btn btn-primary" value="{{ __('sign_in') }}" style="display:block; width:100%;">
                                </div>
                                <div class="dont_have_account float_left">
                                    <p>{{ __('Dont_have_account?') }} <a href="{{ route('register') }}">{{ __('Registration') }}</a></p>
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

@section('js')
    <script>
        $(document).ready(function(){
            $('.bd-demo-access').modal('show');
        });
    </script>
@endsection
