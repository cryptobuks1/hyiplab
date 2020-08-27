<!-- testimonial wrapper start -->
<div class="testimonial_wrapper float_left">
    <div class="investment_overlay"></div>
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="sv_heading_wraper heading_wrapper_dark index2_heading index2_heading_center index3_heading">
                    <h4>{{ __('testimonials') }}</h4>
                    <h3>{{ __('what_people_say_about_us') }}</h3>
                    <div class="line_shape line_shape2"></div>
                </div>

            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="saying_slider index3_saying_slider">
                    <div class="owl-carousel owl-theme">
                        @foreach(\App\Models\Testimonial::orderBy('created_at', 'desc')->limit(3)->get() as $testimonial)
                            <div class="item">
                                <div class="saying_content_wrapper float_left">
                                    <div class="saying_img">
                                        <img src="/assets/images/cnt1.png" alt="img">
                                    </div>
                                    <div class="saying_img_name">
                                        <h1><a href="#">{{ $testimonial->name }}</a></h1>
                                        <p>{{ $testimonial->email }}</p>
                                    </div>
                                    <p>“{{ $testimonial->testimonial }}”</p>
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