@extends('admin.app')
@section('title', __('Register_wallet'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.wallets.index') }}">{{ __('Wallets') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Register_wallet') }}</li>
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
                                <h4 class="card-title">{{ __('Register_wallet') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="tab-content" id="myTabContent-3">
                                <form action="{{ route('admin.settings.wallets.store') }}" method="POST" target="_top">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Choose_wallet') }}</label>
                                                <select class="form-control" id="" name="paymentSystemId">
                                                    @foreach($availablePaymentSystems as $code => $paymentSystem)
                                                    <option value="{{ $code }}">{{ $paymentSystem['name'] }}</option>
                                                    @endforeach
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