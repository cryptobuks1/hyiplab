@extends('admin.app')
@section('title', __('Users'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Users') }}</li>
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
                                <h4 class="card-title">{{ __('Users_list') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-sm-12 col-md-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search') }}" aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @if($users->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Login') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                        <th scope="col">{{ __('Partner') }}</th>
                                        <th scope="col">{{ __('Country') }}</th>
                                        <th scope="col">{{ __('Registration date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.clients.show', ['id' => $user->id]) }}">{{ $user->login }}</a>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a>
                                            </td>
                                            <td>
                                                @if($partner = $user->partner)
                                                    <div class="badge badge-pill badge-info">
                                                        <a href="{{ route('admin.clients.show', ['id' => $partner->id]) }}" target="_blank">{{ $partner->login }}</a>
                                                    </div>
                                                @else
                                                    <div class="badge badge-pill badge-warning">{{ __('No_partner') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <?php
                                                $userLastIp = \App\Models\PageViews::where('user_id', $user->id)
                                                    ->orderBy('created_at', 'desc')
                                                    ->limit(1)
                                                    ->first();

                                                $geoIp = !empty($userLastIp)
                                                    ? geoip()->getLocation($userLastIp->user_ip)
                                                    : null;
                                                ?>
                                                {{ null !== $geoIp ? $geoIp->country : __('undefined') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->toDateTimeString() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $users->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('Users_not_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection