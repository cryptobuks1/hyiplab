@extends('admin.app')
@section('title', __('Rates'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Rates') }}</li>
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
                                <h4 class="card-title">{{ __('Rates') }}</h4>
                            </div>
                            <input type="button" class="btn btn-primary" value="{{ __('create_rate') }}" onClick="location.assign('{{ route('admin.settings.rates.create') }}')">
                        </div>
                        <div class="iq-card-body">
                            <ul class="nav nav-tabs justify-content-center" id="myTab-2" role="tablist">
                                @foreach($rates as $rate)
                                    <li class="nav-item">
                                        <a class="nav-link{{ $loop->index == 0 ? ' active' : '' }}" id="home-tab-justify" data-toggle="tab" href="#{{ $rate->id }}" role="tab" aria-controls="home" aria-selected="true" style="{{ $rate->active == 1 ? '' : 'color:red;' }}">{{ $rate->name }} [{{ $rate->currency->code }}]</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="myTabContent-3">
                                @foreach($rates as $rate)
                                    <div class="tab-pane fade show {{ $loop->index == 0 ? ' active' : '' }}" id="{{ $rate->id }}" role="tabpanel" aria-labelledby="home-tab-justify">
                                        <div class="col-lg-12">
                                            <form action="{{ route('admin.settings.rates.update', ['id' => $rate->id]) }}" method="POST" target="_top">
                                                {{ csrf_field() }}

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h4>{{ __('Basic_settings') }}</h4>
                                                        <hr>
                                                        <div class="form-group">
                                                            <label for="exampleInputText1">{{ __('ID') }}</label>
                                                            <input type="text" class="form-control" id="exampleInputText1" value="{{ $rate->id }}" readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputText2">{{ __('Rate_name') }}</label>
                                                            <input type="text" class="form-control" id="exampleInputText2" name="rate[name]" value="{{ $rate->name }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('Currency') }}</label>
                                                            <select class="form-control" name="rate[currency_id]">
                                                                @foreach(\App\Models\Currency::all() as $currency)
                                                                    <option value="{{ $currency->id }}"{{ $currency->id == $rate->currency_id ? ' selected' : '' }}>{{ $currency->code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('Autoclose') }}</label>
                                                            <select class="form-control" name="rate[autoclose]">
                                                                <option value="0">{{ __('no') }}</option>
                                                                <option value="1"{{ $rate->autoclose == 1 ? ' selected' : '' }}>
                                                                    {{ __('when_expired') }}</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('Active') }}</label>
                                                            <select class="form-control" name="rate[active]">
                                                                <option value="0">{{ __('no') }}</option>
                                                                <option value="1"{{ $rate->active == 1 ? ' selected' : '' }}>
                                                                    {{ __('yes') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h4>{{ __('Finance_settings') }}</h4>
                                                        <hr>

                                                        <div class="form-group">
                                                            <label>{{ __('Minimum_investment') }}</label>
                                                            <input type="number" step="any" class="form-control" name="rate[min]" value="{{ $rate->min }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('Maximum_investment') }}</label>
                                                            <input type="number" step="any" class="form-control" name="rate[max]" value="{{ $rate->max }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('Earnings_from_deposit_1_cycle_day') }}</label>
                                                            <input type="number" step="any" class="form-control" name="rate[daily]" value="{{ $rate->daily }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('Body_return_percent') }}</label>
                                                            <input type="number" step="any" class="form-control" name="rate[payout]" value="{{ $rate->payout }}" placeholder="100">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('Duration') }}</label>
                                                            <input type="text" class="form-control" name="rate[duration]" value="{{ $rate->duration }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.settings.rates.destroy', ['id' => $rate->id]) }}')">
                                                    {{ __('Delete_rate') }} {{ $rate->name }}</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection