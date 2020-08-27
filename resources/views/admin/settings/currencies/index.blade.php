@extends('admin.app')
@section('title', __('Currencies'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
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
                                <h4 class="card-title">@yield('title')</h4>
                            </div>
                            <input type="button" class="btn btn-primary" value="{{ __('create_currency') }}" onClick="location.assign('{{ route('admin.settings.currencies.create') }}')" {{ count($availableCurrencies) == 0 ? 'disabled' : '' }}>
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-sm-12 col-md-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search_by_code') }}" aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @if($currencies->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Code') }}</th>
                                        <th scope="col">{{ __('Is_main_currency') }}</th>
                                        <th scope="col">{{ __('Is_fiat') }}</th>
                                        <th scope="col">{{ __('Symbols_count') }}</th>
                                        <th scope="col">{{ __('Symbol') }}</th>
                                        <th scope="col">{{ __('Creation_date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($currencies as $currency)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.settings.currencies.show', ['id' => $currency->id]) }}" target="_blank">{{ $currency->id }}</a>
                                            </td>
                                            <td>{{ $currency->name }}</td>
                                            <td>{{ $currency->code }}</td>
                                            <td>{!! $currency->main_currency == 1 ? '<span class="badge badge-success">'.__('yes').'</span>' : '<span class="badge badge-danger">'.__('no').'</span>' !!}</td>
                                            <td>{!! $currency->is_fiat == 1 ? '<span class="badge badge-success">'.__('yes').'</span>' : '<span class="badge badge-danger">'.__('no').'</span>' !!}</td>
                                            <td style="font-weight: bold;">{{ $currency->precision }}</td>
                                            <td style="font-weight: bold;">{{ $currency->symbol }}</td>
                                            <td>{{ \Carbon\Carbon::parse($currency->created_at)->toDateTimeString() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $currencies->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('Currencies_not_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection