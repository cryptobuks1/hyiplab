@extends('layouts.customer')
@section('title', __('About_us'))

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

    @include('customer.wrappers.page-title')

    <!-- about us wrapper start -->
    <div class="sv_about_wrapper fixed_portion float_left">

        <div class="container">
            @include('customer.blocks.notification')
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="border_about_wrapper float_left">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                                <div class="sv_abt_img_wrapper float_left">
                                    <img src="/assets/images/abt_img.jpg" alt="img" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                                <div class="sv_abt_content_wrapper float_left">
                                    <h1>OUR STORY</h1>
                                    <p>One of the best investing marketing
                                        <br> tools is High yield investment program.</p>
                                </div>
                                <p>Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet, we clear consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore consectetur adipiscing elit, sed do eiusmod tempor out incididunt ut labore et dolore magna aliqua. Amet facilisis magna etiam tempor orci.
                                    <br>
                                    <br> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about us wrapper end -->
    <!-- about us wrapper start -->
    <div class="sv_money_wrapper float_left">

        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="sv_money_text_wrapper float_left">
                        <h1>We Make Your</h1>
                        <h2>Invest To Grow a <br>
                            Your Money !</h2>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it hasfact that a reader will be distracted by the readable content of a page when do is nitin we done your project with new assignmentg
                            <br> Lorem Ipsum is that it hasfact that a reader will be distracted by the readable content of a page when do is nitin we done your project </p>
                        <div class="about_btn float_left inner_abt_btn">
                            <ul>
                                <li>
                                    <a href="#">get more</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">

                    <div class="sv_abt_img_wrapper float_left">
                        <img src="/assets/images/abt_1.png" alt="img" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about us wrapper end -->
    <!-- counter wrapper start-->
    <div class="counter_section float_left">
        <div class="investment_overlay"></div>
        <div class="counter-section2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12 col-sm-6">
                        <div class="counter_cntnt_box">
                            <div class="tb_icon investment_icon_circle">
                                <div class="icon"><i class="flaticon-bar-chart"></i>

                                </div>
                                <div class="investment_border_wrapper"></div>
                            </div>
                            <div class="count-description"><span class="timer">{{ \Carbon\Carbon::parse(\App\Models\User::orderBy('created_at')->first()->created_at)->diffInDays(now()) }}</span>
                                <h5 class="con1"> <a href="#">{{ __('days_online') }}</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 col-sm-6">
                        <div class="counter_cntnt_box">
                            <div class="tb_icon investment_icon_circle blue_icon_circle">
                                <div class="icon"><i class="flaticon-user"></i>

                                </div>
                                <div class="investment_border_wrapper blue_border_wrapper"></div>
                            </div>
                            <div class="count-description"> <span class="timer">{{ \App\Models\User::count() }}</span>
                                <h5 class="con2"> <a href="#"> {{ __('total_users') }} </a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 col-sm-6">
                        <div class="counter_cntnt_box">
                            <div class="tb_icon investment_icon_circle red_info_circle">
                                <div class="icon"><i class="flaticon-salary"></i>

                                </div>
                                <div class="investment_border_wrapper red_border_wrapper"></div>
                            </div>
                            <div class="count-description"> <span class="timer">{{ \App\Models\Deposit::count() }}</span>
                                <h5 class="con2"> <a href="#"> {{ __('total_deposits') }} </a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 col-sm-6">
                        <div class="counter_cntnt_box">
                            <div class="tb_icon investment_icon_circle green_info_circle">
                                <div class="icon"><i class="flaticon-withdrawal"></i>

                                </div>
                                <div class="investment_border_wrapper green_border_wrapper"></div>
                            </div>
                            <div class="count-description"> <span class="timer">{{ \App\Models\Transaction::where('type_id', \App\Models\TransactionType::getByName('withdraw')->id)->count() }}</span>
                                <h5 class="con4"> <a href="#"> {{ __('total_withdrawals') }}</a></h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- counter wrapper end-->
    <!--our services wrapper start -->
    <div class="our_services_wrapper float_left">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper heading_wrapper_dark dark_heading">
                        <h4> features</h4>
                        <h3>savehyip features</h3>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box float_left">
                        <div class="investment_icon_circle">
                            <i class="flaticon-medal"></i>
                        </div>
                        <div class="investment_border_wrapper"></div>
                        <div class="investment_content_wrapper">
                            <h1><a href="#">our mission</a></h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box float_left">
                        <div class="investment_icon_circle red_info_circle">
                            <i class="flaticon-shield"></i>
                        </div>
                        <div class="investment_border_wrapper red_border_wrapper"></div>
                        <div class="investment_content_wrapper red_content_wrapper">
                            <h1><a href="#">our vision</a></h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box float_left">
                        <div class="investment_icon_circle blue_icon_circle">
                            <i class="flaticon-bars"></i>
                        </div>
                        <div class="investment_border_wrapper blue_border_wrapper"></div>
                        <div class="investment_content_wrapper blue_content_wrapper">
                            <h1><a href="#">our value</a></h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--our services wrapper end -->
    <!-- testimonial wrapper start -->
    <div class="testimonial_wrapper float_left">
        <div class="investment_overlay"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper heading_wrapper_dark">
                        <h4>{{ __('testimonials') }}</h4>
                        <h3>{{ __('what_people_say_about_us') }}</h3>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="testimonial_slider_wrapper">
                        <div class="owl-carousel owl-theme">
                            @foreach(\App\Models\Testimonial::orderBy('created_at', 'desc')->limit(9)->get() as $testimonial)
                            <div class="item">
                                <div class="testimonial_slide_main_wrapper dark_top_testimonial">
                                    <div class="ts_client_cont_wrapper">
                                        <p>“{{ $testimonial->testimonial }}”</p>
                                    </div>
                                    <div class="ts_img_social_wrapper">
                                        <div class="ts_client_img_wrapper">
                                            <img src="/assets/images/ts1.png" class="img-responsive" alt="client_img" />
                                        </div>
                                        <div class="ts_client_social_wrapper">
                                            <p>{{ $testimonial->name }}
                                                <br> <span>{{ $testimonial->email }}</span></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonial wrapper end -->

    @include('customer.wrappers.investors')
    @include('customer.blocks.footer')
@endsection