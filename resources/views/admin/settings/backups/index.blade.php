@extends('admin.app')
@section('title', __('Backups'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Backups') }}</li>
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
                                <h4 class="card-title">{{ __('Backups_list') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search_by_date') }}" aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="text-align:right;">
                                    <input type="button" class="btn btn-primary" value="{{ __('Create_DB_backup') }}" onclick="location.assign('{{ route('admin.settings.backups.backup_db') }}')">
                                    <input type="button" class="btn btn-primary" value="{{ __('Create_files_backup') }}" onclick="location.assign('{{ route('admin.settings.backups.backup_files') }}')">
                                    <input type="button" class="btn btn-primary" value="{{ __('Create_full_backup') }}" onclick="location.assign('{{ route('admin.settings.backups.backup_all') }}')">
                                </div>
                            </div>
                            @if(count($backups) > 0)
                                <div class="row">
                                    <div class="col-lg-5">
                                        <table class="table table-striped table-bordered mt-4">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('File') }}</th>
                                                <th scope="col">{{ __('Control') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($backups as $backup)
                                                <tr>
                                                    <td>
                                                        {{ $backup }}
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <form action="{{ route('admin.settings.backups.download') }}" method="POST" target="_top">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="file" value="{{ $backup }}">
                                                                    <input type="submit" class="btn btn-primary" value="{{ __('download') }}" style="display:block;width:100%;">
                                                                </form>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <form action="{{ route('admin.settings.backups.destroy') }}" method="POST" target="_top">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="file" value="{{ $backup }}">
                                                                    <input type="submit" class="btn btn-danger" value="{{ __('delete') }}" style="display:block;width:100%;">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('Backups_not_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection