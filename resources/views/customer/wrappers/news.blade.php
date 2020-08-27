<!--our blog wrapper start -->
<div class="our_blog_wrapper float_left">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-lg-12 col-sm-12 col-12">

                <div class="sv_heading_wraper heading_wrapper_dark dark_heading index2_heading index2_heading_center index3_heading">
                    <h4>{{ __('Be_aware_of_everything') }}</h4>
                    <h3>{{ __('Our_latest_news') }}</h3>
                    <div class="line_shape line_shape2"></div>
                </div>
            </div>

            @foreach(\App\Models\News::orderBy('created_at', 'desc')->limit(3)->get() as $news)
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="blog_box_wrapper index2_blog_wrapepr index3_blog_wrapper float_left">
                    <div class="blog_img_wrapper">
                        <img src="/assets/images/blog_img1.jpg" alt="blog_img">
                        <div class="blog_date_wrapper index2_blog_date index3_blog_date">
                            @php($newsDate = \Carbon\Carbon::parse($news->created_at))
                            <p>{{ $newsDate->format('d') }}<br> <span>{{ $newsDate->format('M') }}</span></p>
                        </div>
                    </div>
                    <div class="btc_blog_indx_cont_wrapper">

                        <h5> <a href="#">{{ $news->subject }}</a></h5>
                        <p>{{ substr($news->content, 0, 255) }}</p>
                    </div>
                    <div class="btc_blog_indx_cont_bottom">
                        <div class="btc_blog_indx_cont_bottom_left">
                            <p><i class="fa fa-user"></i> &nbsp;<a href="#">by {{ \App\Models\Admin::first()->login }}</a></p>
                        </div>
                        <div class="btc_blog_indx_cont_bottom_right">
                            <p class="comments"><i class="fa fa-comments"></i> &nbsp;<a href="#">0 comments</a></p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--our blog wrapper end -->