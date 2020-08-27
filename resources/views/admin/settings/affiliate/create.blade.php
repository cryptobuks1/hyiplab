@extends('admin.app')
@section('title', __('Create_level'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.affiliate.index') }}">{{ __('Affiliate_program') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Create_level') }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Create_level') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="col-lg-12">
                                <form action="{{ route('admin.settings.affiliate.store') }}" method="POST" target="_top">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputText2">{{ __('Level') }}</label>
                                                <input type="number" step="1" class="form-control" id="exampleInputText2" name="level[level]" value="">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputText3">{{ __('Percent') }}</label>
                                                <input type="number" step="1" class="form-control" id="exampleInputText3" name="level[percent]" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('When_replenishing') }}</label>
                                                <select class="form-control" name="level[on_load]">
                                                    <option value="0">{{ __('no') }}</option>
                                                    <option value="1">{{ __('yes') }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('When_earning_on_a_deposit') }}</label>
                                                <select class="form-control" name="level[on_profit]">
                                                    <option value="0">{{ __('no') }}</option>
                                                    <option value="1">{{ __('yes') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                        </div>
                                    </div>

                                    <hr>

                                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection