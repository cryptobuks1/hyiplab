@extends('layouts.customer')
@section('title', 'FAQ')

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

    <!-- FAQ wrapper start -->
    <div class="inner_faq_wrapper fixed_portion float_left">
        <div class="container">
            @include('customer.blocks.notification')
            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper heading_wrapper_dark dark_heading">
                        <h4>FAQ section</h4>
                        <h3>Frequently Asked Questions</h3>

                    </div>
                </div>
            </div>
            <div id="accordion" role="tablist" class="inner_faq_section">
                <div class="row">
                    @include('customer.wrappers.faq')
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ wrapper end -->
    <!-- answer wrapper start -->
    <div class="contact_section float_left">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper heading_wrapper_dark dark_heading">
                        <h3>{{ __('did_not_found_answer') }}</h3>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('customer.blocks.notification')
                    @include('customer.blocks.support-form')
                </div>
            </div>
        </div>
    </div>
    <!-- answer wrapper end -->

    @include('customer.blocks.footer')
@endsection