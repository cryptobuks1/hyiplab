@extends('admin.app')
@section('title', __('User_logs').' '.$user->login)

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.clients.show', ['id' => $user->id]) }}">{{ __('Profile') }}: {{ $user->login }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Action_logs') }}</li>
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
                                <h4 class="card-title">{{ __('User_logs') }} {{ $user->login }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            @if($logs->count() > 0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Action') }}</th>
                                        <th scope="col">{{ __('IP_address') }}</th>
                                        <th scope="col">{{ __('Country') }}</th>
                                        <th scope="col">{{ __('GET_data') }}</th>
                                        <th scope="col">{{ __('POST_data') }}</th>
                                        <th scope="col">{{ __('Date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $adminLog)
                                        <tr>
                                            <td>{{ $adminLog->action }}</td>
                                            <td>{{ $adminLog->user_ip }}</td>
                                            <td>
                                                <?php
                                                $geoIp = !empty($adminLog->user_ip)
                                                    ? geoip()->getLocation($adminLog->user_ip)
                                                    : null;
                                                ?>
                                                {{ null !== $geoIp ? $geoIp->country : __('undefined') }}
                                            </td>
                                            <td>
                                        <textarea style="max-width: 100%; min-width: 300px;" readonly>
                                            {{ $adminLog->get_data }}
                                        </textarea>
                                            </td>
                                            <td>
                                        <textarea style="max-width: 100%; min-width: 300px;" readonly>
                                            {{ $adminLog->post_data }}
                                        </textarea>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($adminLog->created_at)->toDateTimeString() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $logs->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('Logs_not_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection