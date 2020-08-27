@extends('admin.app')
@section('title', __('Currency_details'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.currencies.index') }}">{{ __('Currencies') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Currency_details') }}: {{ $currency->code }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Currency_details') }}: {{ $currency->code }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.settings.currencies.update', ['id' => $currency->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $currency->id }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText2">{{ __('Code') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText2" value="{{ $currency->code }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText3">{{ __('Symbols_count') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText3" value="{{ $currency->precision }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText4">{{ __('Symbol') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText4" value="{{ $currency->symbol }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText5">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText5" name="currency[name]" value="{{ $currency->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="currencyIsMain">{{ __('Is_main_currency') }}</label>
                                    <select class="form-control" name="currency[main_currency]" id="currencyIsMain">
                                        <option value="0">{{ __('no') }}</option>
                                        <option value="1">{{ __('yes') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="currencyIsFiat">{{ __('This_is_fiat') }}</label>
                                    <select class="form-control" name="currency[is_fiat]" id="currencyIsFiat" readonly="">
                                        <option value="0">{{ __('no') }}</option>
                                        <option value="1"{{ $currency->is_fiat == 1 ? ' selected' : '' }}>{{ __('yes') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="currencyCreatedAt">{{ __('Creation_date') }}</label>
                                    <input type="datetime-local" class="form-control" name="currency[created_at]" id="currencyCreatedAt" value="{{ \Carbon\Carbon::parse($currency->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.settings.currencies.destroy', ['id' => $currency->id]) }}')">
                                    {{ __('Delete_currency') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection