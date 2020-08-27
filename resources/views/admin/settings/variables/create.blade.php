@extends('admin.app')
@section('title', __('Register_variable'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.variables.index') }}">{{ __('Variables') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Register_variable') }}</li>
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
                                <h4 class="card-title">{{ __('Register_variable') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="tab-content" id="myTabContent-3">
                                <form action="{{ route('admin.settings.variables.store') }}" method="POST" target="_top">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="s_key">{{ __('Key') }}</label>
                                                <input class="form-control" type="text" name="setting[s_key]" id="s_key" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="s_key">{{ __('Value') }}</label>
                                                <input class="form-control" type="text" name="setting[s_value]" id="s_value" value="" placeholder="">
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