<!-- investors wrapper start -->
<div class="investors_wrapper float_left">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="sv_heading_wraper half_section_headign">
                    <h4>{{ __('Best_investors') }}</h4>
                    <h3>{{ __('our_top_investors') }}</h3>

                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 sw_spectrm_padding">
                <div class="investors_slider_wrapper">
                    <div class="owl-carousel owl-theme">
                        <?php
                        $topUsers = \App\Models\User::withCount('deposits')
                            ->orderBy('deposits_count', 'desc')
                            ->limit(4)
                            ->get();
                        ?>
                        @foreach($topUsers as $topUser)
                        <div class="item">
                            <div class="inves_slider_cntn float_left">
                                <div class="investment_box_wrapper index_investment float_left">
                                    <div class="inves_img_wrapper">
                                        <img src="/assets/images/inves1.png" class="img-responsive" alt="img" />
                                    </div>
                                    <div class="inves_main_border float_left">
                                        <div class="investment_icon_circle inves_icon">
                                            <i class="flaticon-twitter"></i>
                                        </div>
                                        <div class="investment_border_wrapper inves_border_slider"></div>
                                        <div class="investment_content_wrapper inves_heading_txt">
                                            <h1><a href="#">{{ substr($topUser->login, 0, 10) }}</a></h1>
                                            <p>{{ amountWithPrecisionByCurrencyCode($topUser->transactions()->where('type_id', \App\Models\TransactionType::getByName('create_dep')->id ?? 0)->sum('main_currency_amount'), 'USD') }} USD</p>
                                        </div>

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
<!-- investors wrapper end -->