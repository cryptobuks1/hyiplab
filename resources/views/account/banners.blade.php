@extends('layouts.account')
@section('title', __('Banners'))

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
        <div class="banner_top_wrapper float_left">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>@yield('title')</h3>

                    </div>

                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="view_profile_wrapper float_left">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                                <div class="profile_view_img banner_img_wrapper">
                                    <img src="/assets/images/banner1.jpg" alt="post_img">

                                </div>
                                <div class="profile_width_cntnt banner_cnctnt_wrapper">
                                    <h4>JPEG or PNG 1000x1000px Thumbnail</h4>

                                    <div class="width_50">
                                        <input type="file" id="input-file-now-custom-23" class="dropify" data-height="90" /><span class="post_photo">browse image</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                                <div class="profile_view_img banner_img_wrapper gtgt">
                                    <img src="/assets/images/banner1.jpg" alt="post_img">

                                </div>
                                <div class="profile_width_cntnt banner_cnctnt_wrapper">
                                    <h4>JPEG or PNG 1000x1000px Thumbnail</h4>

                                    <div class="width_50">
                                        <input type="file" id="input-file-now-custom-3" class="dropify" data-height="90" /><span class="post_photo">browse image</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--  profile wrapper end -->

        @include('account.blocks.footer')
    </div>
@endsection