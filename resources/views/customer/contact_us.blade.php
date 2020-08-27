@extends('layouts.customer')
@section('title', __('Contact_with_us'))

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

    <!-- map wrapper start -->
    <div class="map_wrapper fixed_portion float_left">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.6457860614814!2d-0.14407868421927225!3d51.50136731896525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48760520cd5b5eb5%3A0xa26abf514d902a7!2sBuckingham%20Palace!5e0!3m2!1sen!2sid!4v1596517572449!5m2!1sen!2sid" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <!-- map wrapper end -->
    <!-- contact_wrapper start -->
    <div class="contact_section float_left">
        <div class="container">
            @include('customer.blocks.notification')
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper heading_wrapper_dark dark_heading">
                        <h4>{{ __('You_have_questions?') }}</h4>
                        <h3>{{ __('Contact_with_us') }}</h3>

                    </div>

                </div>
                <div class="col-lg-10 offset-lg-1 col-md-12 col-sm-12 col-12">
                    @include('customer.blocks.notification')
                    @include('customer.blocks.support-form')
                </div>
            </div>
        </div>
    </div>
    <!-- contact_wrapper end -->

    @include('customer.wrappers.payments')
    @include('customer.blocks.footer')
@endsection