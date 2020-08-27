@extends('admin.app')
@section('title', __('Profile').': '.$user->login)

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">{{ __('Users') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}: {{ $user->login }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')
            @if($user->isBlocked())
                <div class="alert alert-danger" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-information-line"></i>
                    </div>
                    <div class="iq-alert-text">{{ __('User_blocked!') }}</div>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body profile-page p-0">
                            <div class="profile-header">
                                <div class="cover-container">
                                    <img src="/admin_assets/images/page-img/profile-bg.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                                    <ul class="header-nav d-flex flex-wrap justify-end p-0 m-0">
                                        <li><a href="{{ route('admin.clients.edit', ['id' => $user->id]) }}"><i class="ri-pencil-line"></i></a></li>
                                    </ul>
                                </div>
                                <div class="profile-info p-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="user-detail pl-5">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="profile-img pr-4">
                                                        <img src="https://fakeimg.pl/130x130/?retina=1&text={{ substr($user->login, 0, 1) }}&font=lobster" alt="profile-img" class="avatar-130 img-fluid" />
                                                    </div>
                                                    <div class="profile-detail d-flex align-items-center">
                                                        <h3>{{ $user->login }}</h3>
                                                        <p class="m-0 pl-3">{{ !empty($user->name) ? ' - '.$user->name : '' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <ul class="nav nav-pills d-flex align-items-end float-right profile-feed-items p-0 m-0">
                                                <li>
                                                    <button type="button" class="btn btn-outline-primary" onClick="location.assign('{{ route('admin.impersonate', ['id' => $user->id]) }}');">
                                                        {{ __('Impersonalization') }}</button>
                                                </li>
                                                <li style="margin-left:10px;">
                                                    <button type="button" class="btn btn-light" onclick="location.assign('{{ $pageViewsCount > 0 ? route('admin.clients.page_views', ['id' => $user->id]) : '' }}')" {{ $pageViewsCount == 0 ? ' disabled' : '' }}>
                                                        {{ __('Page_views') }} <span class="badge badge-primary ml-2">{{ $pageViewsCount }}</span></button>
                                                </li>
                                                <li style="margin-left:10px;">
                                                    <button type="button" class="btn btn-light" onclick="location.assign('{{ $logsCount > 0 ? route('admin.clients.logs', ['id' => $user->id]) : '' }}')" {{ $logsCount == 0 ? ' disabled' : '' }}>
                                                        {{ __('Logs') }} <span class="badge badge-primary ml-2">{{ $logsCount }}</span></button>
                                                </li>
                                                <li style="margin-left:10px;">
                                                        <button type="button" class="btn {{ !$user->isBlocked() ? 'btn-outline-danger' : 'btn-outline-success' }}" onClick="location.assign('{{ route('admin.clients.'.(!$user->isBlocked() ? 'block' : 'unblock'), ['id' => $user->id]) }}')">{{ !$user->isBlocked() ? __('Block') : __('Unblock') }}</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @if($user->deposits()->count() > 0)
                <div class="row">
                    <div class="col-sm-12">
                        <div id="card-slider" class="row">
                            @foreach($user->deposits()->orderBy('created_at', 'desc')->get() as $deposit)
                                <div class="col-md-3">
                                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                        <div class="iq-card-body">
                                            <div class="bg-cobalt-blue p-3 rounded d-flex align-items-center justify-content-between mb-3">
                                                <h5 class="text-white">{{ __('Deposit') }}</h5>
                                                <div style="width:200px;">
                                                    <div class="progress mb-3" style="margin-top:15px;">
                                                        <?php
                                                        $totalAccruals = \App\Models\DepositQueue::where('deposit_id', $deposit->id)
                                                            ->where('type', \App\Models\DepositQueue::TYPE_ACCRUE)
                                                            ->count();
                                                        $doneAccruals = \App\Models\DepositQueue::where('deposit_id', $deposit->id)
                                                            ->where('type', \App\Models\DepositQueue::TYPE_ACCRUE)
                                                            ->where('done', 1)
                                                            ->count();
                                                        $percentDone = 100 - round((($totalAccruals-$doneAccruals)/$totalAccruals)*100);
                                                        ?>
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ round($percentDone) }}%;" aria-valuenow="{{ round($percentDone) }}" aria-valuemin="0" aria-valuemax="100">{{ $percentDone }}%</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-dark">
                                                <tbody>
                                                <tr>
                                                    <td>{{ __('Rate') }}</td>
                                                    <td>{{ $deposit->rate->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Invested') }}</td>
                                                    <td>{{ amountWithPrecision($deposit->invested, $deposit->currency) }}{{ $deposit->currency->symbol }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Next accrual') }}</td>
                                                    <td>
                                                        <?php
                                                        $nextAccrual = \App\Models\DepositQueue::where('deposit_id', $deposit->id)
                                                            ->where('type', \App\Models\DepositQueue::TYPE_ACCRUE)
                                                            ->where('done', 0)
                                                            ->orderBy('available_at')
                                                            ->limit(1)
                                                            ->first();
                                                        ?>
                                                        {{ null == $nextAccrual ? __('no') : \Carbon\Carbon::parse($nextAccrual->available_at)->format('Y-m-d H:i') }}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                        @endif
                    <div class="row">
                        <div class="col-lg-3 profile-left">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">{{ __('Last_10_actions') }}</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    @if($user->actionLogs()->count() > 0)
                                        <ul class="list-group">
                                            @foreach($user->actionLogs()->orderBy('created_at', 'desc')->limit(10)->get() as $log)
                                                <li class="list-group-item">
                                                    {{ $log->action }}
                                                    <span class="badge badge-secondary" style="float:right;">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
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
                        <div class="col-lg-6 profile-center">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">{{ __('Transactions_list') }}</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    @if($transactions->count() > 0)
                                        <table class="table table-striped table-dark">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('Amount') }}</th>
                                                <th scope="col">{{ __('Type') }}</th>
                                                <th scope="col">{{ __('Batch') }}</th>
                                                <th scope="col">{{ __('Date') }}</th>
                                                <th scope="col">{{ __('Verified') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($transactions as $transaction)
                                                <tr>
                                                    <td>{{ amountWithPrecision($transaction->amount, $transaction->currency) }}{{ $transaction->currency->symbol }}</td>
                                                    <td>{{ $transaction->type->name }}</td>
                                                    <td>{{ $transaction->batch_id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $transaction->approved == 1 ? '+' : '-' }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {!! $transactions->appends(request()->input())->links() !!}
                                    @else
                                        <div class="alert alert-light" role="alert">
                                            <div class="iq-alert-icon">
                                                <i class="ri-alert-line"></i>
                                            </div>
                                            <div class="iq-alert-text">{{ __('No_transactions') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 profile-right">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">{{ __('Wallets_balances') }}</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    @if($user->wallets()->count() > 0)
                                        <ul class="list-group">
                                            @foreach($user->wallets()->orderBy('created_at', 'desc')->get() as $wallet)
                                                <li class="list-group-item">
                                                    {{ $wallet->paymentSystem->name }} {{ $wallet->currency->code }}
                                                    <span class="badge badge-secondary" style="float:right;">{{ amountWithPrecision($wallet->balance, $wallet->currency) }}{{ $wallet->currency->symbol }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="alert alert-light" role="alert">
                                            <div class="iq-alert-icon">
                                                <i class="ri-alert-line"></i>
                                            </div>
                                            <div class="iq-alert-text">{{ __('No_wallets') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 profile-center">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title" style="width:100%;">
                                        <h4 class="card-title" style="text-align: center;">{{ __('referral_tree_scroll') }}</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    <table style="width:100%; height:400px;">
                                        <tr>
                                            <td style="vertical-align: central; text-align: center;">
                                                <iframe src="{{ route('admin.clients.reftree', ['id' => $user->id]) }}" style="width:100%; height: 500px;"></iframe>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery('#card-slider').slick({
            centerMode: false,
            centerPadding: '60px',
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay:true,
            arrows: false,
            focusOnSelect: true,
            responsive: [{
                breakpoint: 992,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '30',
                    slidesToShow: 2
                }
            }, {
                breakpoint: 650,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '15',
                    slidesToShow: 1
                }
            }],
            // nextArrow: '<a href="#" class="ri-arrow-left-s-line left"></a>',
            // prevArrow: '<a href="#" class="ri-arrow-right-s-line right"></a>',
        });
    </script>
@endsection