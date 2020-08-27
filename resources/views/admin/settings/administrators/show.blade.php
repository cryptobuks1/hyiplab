@extends('admin.app')
@section('title', __('Admin').': '.$admin->login)

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.administrators.index') }}">{{ __('Administrators') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Admin') }}: {{ $admin->login }}</li>
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
                                <h4 class="card-title">{{ __('Control_administrator') }}: {{ $admin->login }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.settings.administrators.update', ['id' => $admin->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $admin->id }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="adminName">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" name="admin[name]" id="adminName" value="{{ $admin->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="adminLogin">{{ __('Login') }}</label>
                                    <input type="text" class="form-control" name="admin[login]" id="adminLogin" value="{{ $admin->login }}">
                                </div>

                                <div class="form-group">
                                    <label for="adminCreatedAt">{{ __('Registration_date') }}</label>
                                    <input type="datetime-local" class="form-control" name="admin[created_at]" id="adminCreatedAt" value="{{ \Carbon\Carbon::parse($admin->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <div class="form-group">
                                    <label for="adminPermissions">{{ __('Accesses_to_pages') }}</label>
                                    <select multiple="" class="form-control" name="permissions[]" id="adminPermissions" style="min-height: 300px;">
                                        @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                            <option value="{{ $permission->name }}"{{ admin()->hasPermissionTo($permission->name) ? ' selected' : '' }}>{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.settings.administrators.destroy', ['id' => $admin->id]) }}')">
                                    {{ __('Delete_admin') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Change_password') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.settings.administrators.update_password', ['id' => $admin->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="npass">{{ __('New_password') }}:</label>
                                    <input type="Password" class="form-control" name="password" id="npass" value="">
                                </div>
                                <div class="form-group">
                                    <label for="vpass">{{ __('Type_again') }}:</label>
                                    <input type="Password" class="form-control" name="password_confirm" id="vpass" value="">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Change_password') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Last_actions') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            @if($admin->actionLogs()->count() > 0)
                                <ul class="list-group">
                                    @foreach($actionLogs as $log)
                                        <li class="list-group-item">
                                            {{ $log->action }}
                                            <span class="badge badge-secondary" style="float:right;">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                {!! $actionLogs->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-light" role="alert">
                                    <div class="iq-alert-icon">
                                        <i class="ri-alert-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('No_logs') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('js')

@endsection