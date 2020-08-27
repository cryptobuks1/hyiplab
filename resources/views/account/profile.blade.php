@extends('layouts.account')
@section('title', __('Profile'))

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
        <div class="view_profile_wrapper_top float_left">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>@yield('title')</h3>

                    </div>

                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    @include('account.blocks.notification')

                    <div class="view_profile_wrapper float_left">
                        <form action="{{ route('account.profile') }}" method="POST" target="_top" enctype="multipart/form-data">
                            {{ csrf_field() }}

{{--                            <div class="row">--}}
{{--                                <div class="col-md-12 col-lg-12 col-sm-12 col-12">--}}
{{--                                    <div class="profile_view_img">--}}
{{--                                        <img src="/assets/images/user.png" alt="post_img">--}}
{{--                                    </div>--}}
{{--                                    <div class="profile_width_cntnt">--}}
{{--                                        <h4>JPEG {{ __('or') }} PNG</h4>--}}

{{--                                        <div class="width_50">--}}
{{--                                            <input type="file" id="input-file-now-custom-233" class="dropify" data-height="90" name="avatar" /><span class="post_photo">browse image</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="profile_list">
                                        <li>
                                            <span class="detail_left_part">{{ __('Name') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[name]" value="{{ auth()->user()->name }}">
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Login') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[login]" value="{{ auth()->user()->login }}">
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Email') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[email]" value="{{ auth()->user()->email }}">
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Partner') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[partner_id]" value="{{ auth()->user()->partner ? auth()->user()->partner->login : __('No_parner') }}" disabled>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Ref_link') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[my_id]" value="{{ auth()->user()->my_id }}" disabled>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Phone_number') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[phone]" value="{{ auth()->user()->phone }}">
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Skype') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[skype]" value="{{ auth()->user()->skype }}">
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Gender') }}</span>
                                            <span class="detail_right_part">
                                                <select class="form-control" name="user[sex]">
                                                    <option value="man"{{ auth()->user()->isMan() ? ' selected' : '' }}>{{ __('Male') }}</option>
                                                    <option value="woman"{{ auth()->user()->isWoman() ? ' selected' : '' }}>{{ __('Famale') }}</option>
                                                </select>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('Country') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[country]" value="{{ auth()->user()->country }}">
                                            </span>
                                        </li>
                                        <li>
                                            <span class="detail_left_part">{{ __('City') }}</span>
                                            <span class="detail_right_part">
                                                <input type="text" name="user[city]" value="{{ auth()->user()->city }}">
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="profile_list">
                                        @foreach(auth()->user()->wallets()->get() as $wallet)
                                            <li>
                                                <span class="detail_left_part">{{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }}</span>
                                                <span class="detail_right_part">
                                                    <input type="text" name="wallets[{{ $wallet->id }}]" value="{{ $wallet->external }}">
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="about_btn float_left">
                                    <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--  profile wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection