@extends('admin.app')
@section('title', __('Create_rate'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.rates.index') }}">{{ __('Rates') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Create_rate') }}</li>
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
                                <h4 class="card-title">{{ __('Create_rate') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="col-lg-12">
                                <form action="{{ route('admin.settings.rates.store') }}" method="POST" target="_top">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4>{{ __('Basic_settings') }}</h4>
                                            <hr>

                                            <div class="form-group">
                                                <label for="exampleInputText2">{{ __('Rate_name') }}</label>
                                                <input type="text" class="form-control" id="exampleInputText2" name="rate[name]" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('Currency') }}</label>
                                                <select class="form-control" name="rate[currency_id]">
                                                    @foreach(\App\Models\Currency::all() as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('Autoclose') }}</label>
                                                <select class="form-control" name="rate[autoclose]">
                                                    <option value="0">{{ __('no') }}</option>
                                                    <option value="1">{{ __('when_expired') }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('Active') }}</label>
                                                <select class="form-control" name="rate[active]">
                                                    <option value="0">{{ __('no') }}</option>
                                                    <option value="1">{{ __('yes') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4>{{ __('Finance_settings') }}</h4>
                                            <hr>

                                            <div class="form-group">
                                                <label>{{ __('Minimum_investment') }}</label>
                                                <input type="number" step="any" class="form-control" name="rate[min]" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('Maximum_investment') }}</label>
                                                <input type="number" step="any" class="form-control" name="rate[max]" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('Earnings_from_deposit_1_cycle_day') }}</label>
                                                <input type="number" step="any" class="form-control" name="rate[daily]" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('Body_return_percent') }}</label>
                                                <input type="number" step="any" class="form-control" name="rate[payout]" value="" placeholder="100">
                                            </div>

                                            <div class="form-group">
                                                <label>{{ __('Work_period_in_days') }}</label>
                                                <input type="text" class="form-control" name="rate[duration]" value="">
                                            </div>
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