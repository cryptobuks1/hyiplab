<!-- footer section start-->
<div class="footer_main_wrapper index2_footer_wrapper index3_footer_wrapper float_left">

    <div class="container">

        <div class="row">

            <div class="col-lg-4 col-md-6 col-12 col-sm-12">
                <div class="wrapper_second_about">
                    <div class="wrapper_first_image">
                        <a href="{{ route('customer.main') }}"><img src="/assets/images/logo_resp.png" style="max-width:200px;" class="img-responsive" alt="logo" style="float:left;" /></a>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <div class="counter-section">
                        <div class="ft_about_icon float_left">
                            <i class="flaticon-user"></i>
                            <div class="ft_abt_text_wrapper">
                                <p class="timer"> {{ \App\Models\User::count() }}</p>
                                <h4>{{ __('total_users') }}</h4>
                            </div>

                        </div>
                        <div class="ft_about_icon float_left">
                            <i class="flaticon-money-bag"></i>
                            <div class="ft_abt_text_wrapper">
                                <?php
                                $depositType = \App\Models\TransactionType::getByName('create_dep');
                                ?>
                                <p class="timer">{{ round(\App\Models\Transaction::where('type_id', $depositType->id)->where('approved', 1)->sum('amount'), 0) }}</p>
                                <h4>{{ __('total_deposited_USD') }}</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-12 col-sm-4">
                <div class="wrapper_second_useful">
                    <h4>{{ __('menu') }} </h4>

                    <ul>
                        <li><a href="{{ route('customer.main') }}"><i class="fa fa-angle-right"></i>{{ __('Home') }}</a></li>
                        <li><a href="{{ route('customer.about-us') }}"><i class="fa fa-angle-right"></i>{{ __('About_us') }}</a></li>
                        <li><a href="{{ route('customer.contact-us') }}"><i class="fa fa-angle-right"></i>{{ __('Contacts') }}</a></li>
                    </ul>

                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-12 col-sm-4">
                <div class="wrapper_second_useful wrapper_second_links">

                    <ul>
                        <li><a href="{{ route('customer.faq') }}"><i class="fa fa-angle-right"></i>{{ __('FAQ') }}</a></li>
                        <li><a href="{{ route('customer.investment') }}"><i class="fa fa-angle-right"></i>{{ __('Investments') }}</a></li>
                    </ul>

                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 col-sm-12">
                <div class="wrapper_second_useful wrapper_second_useful_2">
                    <h4>{{ __('Contact_with_us') }}</h4>

                    <ul>
                        <li><h1>443-702-6475</h1></li>
                        <li><a href="#"><i class="flaticon-mail"></i>{{ 'support@'.$_SERVER['HTTP_HOST'] }}</a>
                        </li>
                        <li><a href="#"><i class="flaticon-language"></i>{{ $_SERVER['HTTP_HOST'] }}</a>
                        </li>

                        <li><i class="flaticon-placeholder"></i>658 Overlook Dr.
                            North Canton, OH 44720
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="copyright_wrapper float_left">
                    <div class="copyright">
                        <p>{{ __('Copyright') }} <i class="far fa-copyright"></i> {{ date('Y') }} <a href="{{ route('customer.main') }}"> {{ config('app.name') }}</a>.
                            {{ __('All_rights_reserved_created_in_laboratory') }} <a href="https://hyiplab.net" target="_blank">HyipLab</a></p>
                    </div>
                    <div class="social_link_foter">

                        <ul>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- footer section end-->