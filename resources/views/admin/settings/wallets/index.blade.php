@extends('admin.app')
@section('title', __('Wallets'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Wallets') }}</li>
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
                                <h4 class="card-title">{{ __('Wallets') }}</h4>
                            </div>
                            <input type="button" class="btn btn-primary" value="{{ __('create_wallet') }}" onClick="location.assign('{{ route('admin.settings.wallets.create') }}')" {{ count($availablePaymentSystems) == 0 ? 'disabled' : '' }}>
                        </div>
                        <div class="iq-card-body">
                            <ul class="nav nav-tabs justify-content-center" id="myTab-2" role="tablist">
                                @foreach($paymentSystems as $paymentSystem)
                                <li class="nav-item">
                                    <a class="nav-link{{ $loop->index == 0 ? ' active' : '' }}" id="home-tab-justify" data-toggle="tab" href="#{{ $paymentSystem->code }}" role="tab" aria-controls="home" aria-selected="true" style="{{ $paymentSystem->connected == 1 ? '' : 'color:red;' }}">{{ $paymentSystem->name }}</a>
                                </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="myTabContent-3">
                                @foreach($paymentSystems as $paymentSystem)
                                <div class="tab-pane fade show {{ $loop->index == 0 ? ' active' : '' }}" id="{{ $paymentSystem->code }}" role="tabpanel" aria-labelledby="home-tab-justify">
                                    <div class="col-lg-12">
                                        <form action="{{ route('admin.settings.wallets.update', ['id' => $paymentSystem->id]) }}" method="POST" target="_top">
                                            {{ csrf_field() }}

                                            <div style="margin-bottom: 40px; text-align: center;">
                                                <span class="badge badge-{{ $paymentSystem->connected == 1 ? 'success' : 'danger' }}" style="font-size: 17px;">{{ __('Connection') }} {{ $paymentSystem->connected == 1 ? __('established') : __('not_established') }}</span>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <h4>{{ __('Settings') }}</h4>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label for="exampleInputText1">{{ __('ID') }}</label>
                                                        <input type="text" class="form-control" id="exampleInputText1" value="{{ $paymentSystem->id }}" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputText2">{{ __('Wallet_name') }}</label>
                                                        <input type="text" class="form-control" id="exampleInputText2" name="paymentSystem[name]" value="{{ $paymentSystem->name }}">
                                                    </div>

                                                    <hr>

                                                    <ul class="nav nav-tabs" id="myTab-three" role="tablist">
                                                        @foreach($paymentSystem->currencies as $currency)
                                                            <li class="nav-item">
                                                                <a class="nav-link {{ $loop->index == 0 ? 'active' : '' }}" data-toggle="tab" href="#{{ $paymentSystem->code.'-'.$currency->code }}" role="tab" aria-controls="home" aria-selected="true">{{ $currency->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <div class="tab-content" id="myTabContent-1">
                                                        @foreach($paymentSystem->currencies as $currency)
                                                            <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : '' }}" id="{{ $paymentSystem->code.'-'.$currency->code }}" role="tabpanel" aria-labelledby="{{ $paymentSystem->code.'-'.$currency->code }}">
                                                                <div class="form-group">
                                                                    <label>{{ __('Maximum_amount_of_automatic_withdrawals') }}</label>
                                                                    <input type="text" class="form-control" name="paymentSystem[instant_limit][{{ $currency->code }}]" value="{{ json_decode($paymentSystem->instant_limit, true)[$currency->code] ?? 0 }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{ __('Minimum_amount_of_replenishment') }}</label>
                                                                    <input type="text" class="form-control" name="paymentSystem[minimum_topup][{{ $currency->code }}]" value="{{ json_decode($paymentSystem->minimum_topup, true)[$currency->code] ?? 0 }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{ __('Minimum_withdraw_amount') }}</label>
                                                                    <input type="text" class="form-control" name="paymentSystem[minimum_withdraw][{{ $currency->code }}]" value="{{ json_decode($paymentSystem->minimum_withdraw, true)[$currency->code] ?? 0 }}">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4>{{ __('Accesses') }}</h4>
                                                    <hr>
                                                    @foreach($paymentSystem->systems[$paymentSystem->code]['settings'] as $name => $setting)
                                                    <div class="form-group">
                                                        <label>{{ $name }}</label>
                                                        <input type="text" class="form-control" name="paymentSystem[settings][{{ $name }}]" value="{{ $paymentSystem->systems[$paymentSystem->code]['settings'][$name] == 'show' ? (json_decode($paymentSystem->settings, true)[$name] ?? '') : '' }}">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <hr>

                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                            <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.settings.wallets.destroy', ['id' => $paymentSystem->id]) }}')">
                                                {{ __('Delete_wallet') }} {{ $paymentSystem->name }}</button>
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