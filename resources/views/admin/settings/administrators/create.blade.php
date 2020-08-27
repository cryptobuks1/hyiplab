@extends('admin.app')
@section('title', __('Register_admin'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.administrators.index') }}">{{ __('Administrators') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Register_admin') }}</li>
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
                                <h4 class="card-title">{{ __('Register_admin') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.settings.administrators.store') }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="adminName">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" name="admin[name]" id="adminName" value="">
                                </div>

                                <div class="form-group">
                                    <label for="adminLogin">{{ __('Login') }}</label>
                                    <input type="text" class="form-control" name="admin[login]" id="adminLogin" value="">
                                </div>

                                <div class="form-group">
                                    <label for="adminCreatedAt">{{ __('Register_date') }}</label>
                                    <input type="datetime-local" class="form-control" name="admin[created_at]" id="adminCreatedAt" value="{{ now()->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <div class="form-group">
                                    <label for="npass">{{ __('Password') }}:</label>
                                    <input type="Password" class="form-control" name="password" id="npass" value="">
                                </div>

                                <div class="form-group">
                                    <label for="vpass">{{ __('Type_again') }}:</label>
                                    <input type="Password" class="form-control" name="password_confirm" id="vpass" value="">
                                </div>

                                <div class="form-group">
                                    <label for="adminPermissions">{{ __('Accesses_to_pages') }}</label>
                                    <select multiple="" class="form-control" name="permissions[]" id="adminPermissions" style="min-height: 300px;">
                                        @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
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