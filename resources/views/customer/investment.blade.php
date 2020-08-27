@extends('layouts.customer')
@section('title', __('Investments'))

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

    <!--investment plan wrapper start -->
    <div class="sv_pricing_paln fixed_portion  float_left">
        @include('customer.blocks.notification')
        @include('customer.wrappers.plans')
    </div>
    <!--investment plan wrapper end -->

    @include('customer.wrappers.transactions')
    @include('customer.wrappers.calculator')

    @include('customer.blocks.footer')
@endsection

@section('js')
    @include('customer.wrappers.calculator-js')
@endsection