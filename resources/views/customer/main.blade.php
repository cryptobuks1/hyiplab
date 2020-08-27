@extends('layouts.customer')
@section('title', __('Main'))

@section('content')
    @include('customer.blocks.welcome-demo')
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

    @if(session()->has('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

    <!-- navi wrapper End -->
    <!-- slider wrapper start -->
    <div class="slider-area slider_index2_wrapper slider_index3_wrapper  float_left">
        <div class="bg-animation">
            <img class="zoom-fade" src="/assets/images/pattern.png" alt="img">
        </div>
        <div class="index2_sliderbg index3_sliderbg">
            <img src="/assets/images/shape1.png" alt="img" class="img-responsive">
        </div>

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @for($i=1; $i<=3; $i++)
                    <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                        <div class="carousel-captions caption-1">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-10 col-md-12 col-sm-12 col-12">
                                        <div class="content">

                                            <h2 data-animation="animated bounceInUp">{{ __('Title') }}</h2>

                                            <h3 data-animation="animated bounceInUp">{{ __('Invest_your_money') }}  <br>
                                                {{ __('in') }} <span>{{ __('future') }}</span></h3>

                                            <p data-animation="animated bounceInUp">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute an irure dolor in voluptate velit.</p>

                                            <div class="slider_btn index2_sliderbtn index3_sliderbtn float_left">
                                                <ul>
                                                    <li data-animation="animated bounceInLeft">
                                                        <a href="{{ route('register') }}">{{ __('registration') }}</a>
                                                    </li>
                                                    <li data-animation="animated bounceInLeft">
                                                        <a href="{{ route('customer.investment') }}">{{ __('rates') }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div data-animation="animated bounceInLeft" class="social_link_foter slider_btm_icon_links">

                                                <ul>
                                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>

                                                </ul>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endfor

                <ol class="carousel-indicators">

                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"><span class="number">01</span>
                    </li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""><span class="number">02</span>
                    </li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""><span class="number">03</span>
                    </li>
                </ol>
                <div class="carousel-nevigation">
                    <a class="prev" href="#carousel-example-generic" role="button" data-slide="prev"> <span></span> <i class="flaticon-left-arrow"></i>
                    </a>
                    <a class="next" href="#carousel-example-generic" role="button" data-slide="next"> <span></span> <i class="flaticon-arrow-pointing-to-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!-- slider wrapper End -->
    <!--about us wrapper start -->
    <div class="about_us_wrapper index2_about_us_wrapper index3_about_us float_left">
        <div class="container">
            <div class="row">

                <div class="col-xl-6 col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="about_content_wrapper">
                        <div class="sv_heading_wraper index2_heading index3_heading index3_headung2">
                            <h4>{{ __('who_we_are?') }}</h4>
                            <h3>{{ __('Welcome_to_HyipLab') }}</h3>
                            <div class="line_shape line_shape2"></div>
                        </div>
                        <div class="welcone_savehiyp float_left">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <div class="welcome_save_inpvate_wrapper index3_welcome_checkbox">
                                <ul>
                                    <li class="purple_inovate"><a href="{{ route('customer.about-us') }}"><i class="flaticon-check-box"></i> We Innovate </a></li>
                                    <li class="blue_inovate"><a href="{{ route('customer.about-us') }}"><i class="flaticon-check-box"></i> Licenced & Certified </a></li>
                                    <li class="green_inovate"><a href="{{ route('customer.about-us') }}"><i class="flaticon-check-box"></i>Saving & Investments </a></li>
                                </ul>
                            </div>
                            <div class="about_btn index3_about_btn float_left">
                                <ul>
                                    <li>
                                        <a href="{{ route('customer.about-us') }}">{{ __('about_us') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="index3_about_img_wrapper">

                        <img src="/assets/images/shape2.png" alt="About" class="img-responsive">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about us wrapper end -->

    @include('customer.wrappers.plans')
    @include('customer.wrappers.transactions')

    <!-- works wrapper start -->
    <div class="works_wrapper float_left">
        <div class="work_banner_wrapper">
            <img src="/assets/images/video_bg.jpg" alt="img">
        </div>
        <div class="howwork_banner_wrapper index2_homwork_banner_wrapper index3_banner_wrapper">
            <div class="vedio_link_wrapper">
                <a class="test-popup-link button" rel='external' href='https://www.youtube.com/embed/wPD-UNfbdzc' title='title'><i class="fa fa-play"></i></a>
                <div class="work_content_wrap">
                    <h1>{{ __('How_it_works?') }}</h1>
                    <ul class="work_checklist_wrapper">
                        <li>
                            <a href="{{ route('register') }}"><i class="fas fa-dollar-sign"></i>{{ __('invest') }}</a>
                        </li>
                        <li><a href="{{ route('register') }}"><i class="far fa-money-bill-alt"></i>{{ __('take_profit') }}</a></li>
                        <li><a href="{{ route('register') }}"><i class="fas fa-plus"></i>{{ __('invite_friends') }}</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <!-- works wrapper end -->

    @include('customer.wrappers.calculator')

    <!-- global community wrapper start -->
    <div class="global_community_wrapper index2_global_community_wrapper index3_global_community float_left">
        <div class="container">
            <div class="row">
                <div class="global_comm_wraper index2_global_comm_wrapper index3_global_comm_wrapper">
                    <h1>{{ __('We_strive_to_be_the_best_on_the_market') }}</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                </div>
                <div class="zero_balance_wrapper">
                    <div class="zero_commisition">
                        <h1>{{ __('Transparency') }}</h1>
                        <h4>{{ __('All_our_actions_are_transparent') }} *</h4>
                    </div>
                    <div class="start_invest_wrap">
                        <h1>{{ __('become_investor_today') }}</h1>
                        <div class="about_btn index3_about_btn float_left">
                            <ul>
                                <li>
                                    <a href="{{ route('register') }}">{{ __('registration') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- global community wrapper end -->
    <!--our services wrapper start -->
    <div class="our_services_wrapper index2_our_service_wrapper float_left">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">

                    <div class="sv_heading_wraper heading_wrapper_dark dark_heading index2_heading index2_heading_center index3_heading ">
                        <h4>{{ __('why') }}</h4>
                        <h3>{{ __('choose us') }}</h3>
                        <div class="line_shape line_shape2"></div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box feature_box index2_service_box index3_service_box float_left">
                        <div class="investment_icon_circle">
                            <i class="flaticon-medal"></i>
                        </div>
                        <div class="investment_border_wrapper"></div>
                        <div class="investment_content_wrapper">
                            <h1><a href="#">{{ __('We_are_certified') }}</a></h1>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                            <span class="investment_index_icon index3_investment_index_icon"><a href="{{ route('register') }}"><i class="flaticon-arrow-pointing-to-right"></i></a></span>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box feature_box index2_service_box index3_service_box float_left">
                        <div class="investment_icon_circle red_info_circle">
                            <i class="flaticon-shield"></i>
                        </div>
                        <div class="investment_border_wrapper red_border_wrapper"></div>
                        <div class="investment_content_wrapper red_content_wrapper">
                            <h1><a href="#">{{ __('We_are_safe') }}</a></h1>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                            <span class="investment_index_icon index3_investment_index_icon"><a href="{{ route('register') }}"><i class="flaticon-arrow-pointing-to-right"></i></a></span>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box feature_box index2_service_box index3_service_box float_left">
                        <div class="investment_icon_circle blue_icon_circle">
                            <i class="flaticon-bars"></i>
                        </div>
                        <div class="investment_border_wrapper blue_border_wrapper"></div>
                        <div class="investment_content_wrapper blue_content_wrapper">
                            <h1><a href="#">{{ __('We_are_profitable') }}</a></h1>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                            <span class="investment_index_icon index3_investment_index_icon"><a href="{{ route('register') }}"><i class="flaticon-arrow-pointing-to-right"></i></a></span>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box feature_box index2_service_box index3_service_box float_left">
                        <div class="investment_icon_circle green_info_circle">
                            <i class="flaticon-bitcoin"></i>
                        </div>
                        <div class="investment_border_wrapper green_border_wrapper"></div>
                        <div class="investment_content_wrapper green_content_wrapper">
                            <h1><a href="#">{{ __('We_accept_cryptocurrency') }}</a></h1>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                            <span class="investment_index_icon index3_investment_index_icon"><a href="{{ route('register') }}"><i class="flaticon-arrow-pointing-to-right"></i></a></span>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box feature_box index2_service_box index3_service_box float_left">
                        <div class="investment_icon_circle pink_info_circle">
                            <i class="flaticon-headphones"></i>
                        </div>
                        <div class="investment_border_wrapper pink_border_wrapper"></div>
                        <div class="investment_content_wrapper pink_content_wrapper">
                            <h1><a href="#">{{ __('Best_support') }}</a></h1>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                            <span class="investment_index_icon index3_investment_index_icon"><a href="{{ route('register') }}"><i class="flaticon-arrow-pointing-to-right"></i></a></span>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                    <div class="investment_box_wrapper service_box feature_box index2_service_box index3_service_box float_left">
                        <div class="investment_icon_circle yellow_info_circle">
                            <i class="flaticon-language"></i>
                        </div>
                        <div class="investment_border_wrapper yellow_border_wrapper"></div>
                        <div class="investment_content_wrapper yellow_content_wrapper">
                            <h1><a href="#">{{ __('We_are_global') }}</a></h1>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Ut enim ad minim veniam</p>
                            <span class="investment_index_icon index3_investment_index_icon"><a href="{{ route('register') }}"><i class="flaticon-arrow-pointing-to-right"></i></a></span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--our services wrapper end -->

    @include('customer.wrappers.testimonials')
    @include('customer.wrappers.investors')

    <!-- newsletter wrapper start -->
    <div class="global_community_wrapper newsletter_wrapper index2_newsletter index3_newsletter float_left">
        <div class="container">
            <div class="row">
                <div class="global_comm_wraper news_cntnt">
                    <h1>{{ __('Subscribe_to_our_newsletter') }}</h1>
                    <p>{{ __('Leave_your_mailbox_and_we_will_keep_you_updated_with_all_the_news') }}:</p>

                    @include('customer.blocks.notification')

                    <div class="save_newsletter_field">
                        <form action="{{ route('subscribe.handle') }}" method="POST" target="_top">
                            {{ csrf_field() }}

                            <input type="email" name="email" placeholder="{{ __('Enter_your_email') }}">
                            <button type="submit">{{ __('subscribe') }}</button>
                        </form>
                    </div>
                </div>
                <div class="zero_balance_wrapper">
                    <div class="zero_commisition refreal_commison_section">
                        <h1>{{ __('Referral_Commission') }}</h1>
                        <p>{{ __('Get_a_ref_commission_from_users') }} </p>
                        <div class="about_btn refreal_btn index3_about_btn float_left">
                            <h3>{{ \App\Models\Referral::orderBy('percent','desc')->first()->percent ?? '0' }}%</h3>
                            <ul>
                                <li>
                                    <a href="{{ route('register') }}">{{ __('registration') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- newsletter  wrapper end -->

    @include('customer.wrappers.news')

    <!-- FAQ wrapper start -->
    <div class="faq_wrapper float_left">
        <div class="investment_overlay faq_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">

                    <div class="sv_heading_wraper heading_wrapper_dark index2_heading index2_heading_center index3_heading">
                        <h4>{{ __('FAQ') }}</h4>
                        <h3>{{ __('Frequently_asked_Questions') }}</h3>
                        <div class="line_shape line_shape2"></div>
                    </div>
                </div>
            </div>
            <div id="accordion" role="tablist">
                <div class="row">
                    @include('customer.wrappers.faq')
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="about_btn calc_btn faqq_btn index3_about_btn  float_left">
                    <ul>
                        <li>
                            <a href="{{ route('customer.contact-us') }}">{{ __('ask_your_questions') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ wrapper end -->

    @include('customer.wrappers.payments')
    @include('customer.blocks.footer')
@endsection

@section('js')
    @include('customer.wrappers.calculator-js')

    <script>
        $(document).ready(function(){
            $('.bd-welcome-demo').modal('show');
        });
    </script>
@endsection