@extends('admin.app')
@section('title', __('Register_language'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.languages.index') }}">{{ __('Languages') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Register_language') }}</li>
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
                                <h4 class="card-title">{{ __('Register_language') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="tab-content" id="myTabContent-3">
                                <form action="{{ route('admin.settings.languages.store') }}" method="POST" target="_top">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="languageCode">{{ __('Two_digit_code_latin_uppercase') }}</label>
                                                <input type="text" name="language[code]" class="form-control" id="languageCode" placeholder="en" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="languageDefault">{{ __('This_language_is_the_main') }}</label>
                                                <select class="form-control" id="languageDefault" name="language[default]">
                                                    <option value="0">{{ __('no') }}</option>
                                                    <option value="1">{{ __('yes') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

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