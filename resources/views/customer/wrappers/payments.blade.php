<!-- payments wrapper start -->
<div class="payments_wrapper float_left">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="sv_heading_wraper half_section_headign">
                    <h4>{{ __('Payment_options') }}</h4>
                    <h3>{{ __('list_of_payment_systems') }}</h3>

                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="payment_slider_wrapper">
                    <div class="owl-carousel owl-theme">
                        @foreach(\App\Models\PaymentSystem::get() as $paymentSystem)
                        <div class="item">
                            <div class="partner_img_wrapper float_left" style="font-size:25px;">
                                {{ $paymentSystem->name }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- payments wrapper end -->