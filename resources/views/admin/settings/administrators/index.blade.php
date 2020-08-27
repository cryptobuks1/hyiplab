@extends('admin.app')
@section('title', __('Administrators'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Administrators') }}</li>
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
                                <h4 class="card-title">{{ __('Administrators_list') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search_by_login_name') }} ..." aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="text-align: right;">
                                    <input type="button" class="btn btn-primary" value="{{ __('Create_admin') }}" onClick="location.assign('{{ route('admin.settings.administrators.create') }}');">
                                </div>
                            </div>

                            @if($admins->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Login') }}</th>
                                        <th scope="col">{{ __('Country') }}</th>
                                        <th scope="col">{{ __('Accesses_to_pages') }}</th>
                                        <th scope="col">{{ __('Registration date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.settings.administrators.show', ['id' => $admin->id]) }}">{{ $admin->login }}</a>
                                            </td>
                                            <td>
                                                <?php
                                                $userLastIp = \App\Models\PageViews::where('user_id', $admin->id)
                                                    ->orderBy('created_at', 'desc')
                                                    ->limit(1)
                                                    ->first();

                                                $geoIp = !empty($userLastIp)
                                                    ? geoip()->getLocation($userLastIp->user_ip)
                                                    : null;
                                                ?>
                                                {{ null !== $geoIp ? $geoIp->country : __('undefined') }}
                                            </td>
                                            <td style="width:30%;">
                                                @if($admin->permissions()->count() > 0)
                                                    @foreach($admin->permissions as $permission)
                                                        <?php
                                                            $totalCount = $admin->permissions()->count();

                                                            if ($loop->index == 5 && $totalCount > 6) {
                                                                $leftCount = $totalCount - 5;
                                                                echo '<strong>+ '.$leftCount.' '.__('permissions').'</strong>';
                                                                break;
                                                            }
                                                        ?>
                                                        <span class="badge badge-secondary">{{ $permission->name }}</span>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-secondary" role="alert">
                                                        <div class="iq-alert-icon">
                                                            <i class="ri-information-line"></i>
                                                        </div>
                                                        <div class="iq-alert-text">{{ __('No_permissions') }}</div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($admin->created_at)->toDateTimeString() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $admins->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('Administrators_not_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection