@extends('admin.app')
@section('title', __('Settings_variables'))

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
                            <input type="button" class="btn btn-primary" value="{{ __('create_variable') }}" onClick="location.assign('{{ route('admin.settings.variables.create') }}')">
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-sm-12 col-md-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search_by_content') }}" aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @if($settings->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Key') }}</th>
                                        <th scope="col">{{ __('Value') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($settings as $setting)
                                        <form action="{{ route('admin.settings.variables.update', ['id' => $setting->id]) }}" method="POST" target="_top">
                                            {{ csrf_field() }}

                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="setting[s_key]" placeholder="{{ __('key') }}" value="{{ $setting->s_key }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="setting[s_value]" placeholder="{{ __('value') }}" value="{{ $setting->s_value }}">
                                                </td>
                                                <td>
                                                    <input type="submit" class="btn btn-primary" value="{{ __('save') }}">
                                                    <input type="button" class="btn btn-danger" value="{{ __('delete') }}" onClick="sureAndRedirect(this, '{{ route('admin.settings.variables.destroy', ['id' => $setting->id]) }}')">
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $settings->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('No_variables_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection