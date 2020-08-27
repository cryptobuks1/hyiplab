<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }} - {{ __('Control_project') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="/admin_assets/images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/responsive.css">

    @yield('css')
</head>
<body class="iq-page-menu-horizontal right-column-fixed">
@include('admin.blocks.servertime')
@include('admin.blocks.loader')
@include('admin.blocks.choose_template')
<!-- Wrapper Start -->
<div class="wrapper">
    <!-- TOP Nav Bar -->
    <div class="iq-top-navbar">
        <div class="iq-navbar-custom d-flex align-items-center justify-content-between">
            <div class="iq-sidebar-logo">
                <div class="top-logo">
                    @include('admin.blocks.logo')
                </div>
            </div>
            <div class="iq-menu-horizontal">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu d-flex">
                        @include('admin.blocks.menu-horizontal')
                    </ul>
                </nav>
            </div>
            @include('admin.blocks.navbar_right')
        </div>
    </div>
    <!-- TOP Nav Bar END -->
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-body">
                                    <h5>{{ __('Deposits_sum') }}</h5>
                                    <hr>
                                    @foreach($totalInvestedArr as $code => $total)
                                        <h4 class="mb-2"><span class="badge border border-info text-info" style="display:block; width:50%;">{{ amountWithPrecisionByCurrencyCode($total, $code, '`') }} {{ $code }}</span></h4>
                                    @endforeach
                                    <h6 class="mb-4" style="margin-top:20px;"><span class="text-{{ $differentInvested24H >= 0 ? 'success' : 'warning' }}">{{ $differentInvested24H > 0 ? '+' : '' }}{{ $differentInvested24H }}%</span>
                                        {{ __('change_24_hours') }}</h6>
                                    <h5 style="margin-top:20px;">{{ __('Withdrawals_sum') }}</h5>
                                    <hr>
                                    @foreach($totalWithdrewArr as $code => $total)
                                        <h4 class="mb-2"><span class="badge border border-info text-info" style="display:block; width:50%;">{{ amountWithPrecisionByCurrencyCode($total, $code, '`') }} {{ $code }}</span></h4>
                                    @endforeach
                                    <a href="{{ route('admin.finance.statistic.index') }}" class="btn btn-outline-primary d-block mt-5 mb-5">
                                        {{ __('Detailed_statistics') }}</a>
{{--                                    <hr>--}}
{{--                                    <div class="d-flex align-items-center justify-content-between">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <span class="title">Sales: 75%</span>--}}
{{--                                            <div class="iq-progress-bar-linear d-inline-block w-100">--}}
{{--                                                <div class="iq-progress-bar">--}}
{{--                                                    <span class="bg-primary" data-percent="75"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <span class="title">Referal: 25%</span>--}}
{{--                                            <div class="iq-progress-bar-linear d-inline-block w-100">--}}
{{--                                                <div class="iq-progress-bar">--}}
{{--                                                    <span class="bg-warning" data-percent="25"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
{{--                            <div class="iq-card iq-card-block iq-card-stretch">--}}
{{--                                <div class="iq-card-body">--}}
{{--                                    <h2 class="d-inline-block">75%</h2><span class="d-inline-block ml-2">5% up</span>--}}
{{--                                    <p>From the Last Month</p>--}}
{{--                                </div>--}}
{{--                                <div id="chart-8"></div>--}}
{{--                            </div>--}}
                        </div>
                        <div class="col-xl-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                        <div class="iq-card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="d-flex align-items-center mb-3 mb-lg-0">
                                                        <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-group-line"></i></div>
                                                        <div class="text-left">
                                                            <h4>{{ $usersCount }}</h4>
                                                            <p class="mb-0">{{ __('Users_count') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="d-flex align-items-center mb-3 mb-lg-0">
                                                        <div class="rounded-circle iq-card-icon iq-bg-info mr-3"> <i class="ri-money-dollar-box-line"></i></div>
                                                        <div class="text-left">
                                                            <h4>{{ $depositsCount }}</h4>
                                                            <p class="mb-0">{{ __('Deposits_count') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="d-flex align-items-center mb-3 mb-md-0">
                                                        <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"> <i class="ri-mail-line"></i></div>
                                                        <div class="text-left">
                                                            <h4>{{ $mailsCount }}</h4>
                                                            <p class="mb-0">{{ __('Mails_count') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="d-flex align-items-center mb-3 mb-md-0">
                                                        <div class="rounded-circle iq-card-icon iq-bg-warning mr-3"> <i class="ri-focus-line"></i></div>
                                                        <div class="text-left">
                                                            <h4>{{ $transactionsCount }}</h4>
                                                            <p class="mb-0">{{ __('Transactions_count') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="iq-card iq-card-block iq-card-stretch">
                                        <div class="iq-card-header d-flex justify-content-between">
                                            <div class="iq-header-title">
                                                <h4 class="card-title">{{ __('Deposits_summary_by_days_usd') }} </h4>
                                            </div>
{{--                                            <div class="iq-card-header-toolbar d-flex align-items-center">--}}
{{--                                                <div class="custom-control custom-switch custom-switch-text custom-control-inline">--}}
{{--                                                    <div class="custom-switch-inner">--}}
{{--                                                        <input type="checkbox" class="custom-control-input" id="switch-title" checked="">--}}
{{--                                                        <label class="custom-control-label" for="switch-title" data-on-label="On" data-off-label="Off">--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </div>
                                        <div class="iq-card-body rounded pb-primary">
                                            <div class="d-flex justify-content-around">
                                                <div class="price-week-box mr-5">
                                                    <span>{{ __('Current_week') }}</span>
                                                    <h3>{{ $mainCurrency->symbol }}<span class="counter">{{ amountWithPrecision($thisWeekInvestments, $mainCurrency, '`') }}</span> <i class="ri-funds-line text-success font-size-18"></i></h3>
                                                </div>
                                                <div class="price-week-box">
                                                    <span>{{ __('Previous_week') }}</span>
                                                    <h3>{{ $mainCurrency->symbol }}<span class="counter">{{ amountWithPrecision($previousWeekInvestments, $mainCurrency, '`') }}</span> <i class="ri-funds-line text-danger font-size-18"></i></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="menu-chart-02"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="iq-card iq-card-block iq-card-stretch">
                                        <div class="iq-card-body rounded">
                                            <p>{{ __('Withdrawal_activity') }}</p>
                                            <h5>{{ $mainCurrency->symbol }}{{ amountWithPrecision($totalWithdrew, $mainCurrency, '`') }}</h5>
                                            <div id="chart-3"></div>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-card-block iq-card-stretch">
                                        <div class="iq-card-body p-0">
                                            <div id="apex-pie-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(count($ratesStat) > 0)
                            <div class="col-lg-12" style="margin-bottom: 20px;">
                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">{{ __('Rates_popularity') }}</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <div id="high-rates-chart"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">{{ __('New_users') }} </h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    @if($latestUsers->count() > 0)
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('Login') }}</th>
                                            <th scope="col">{{ __('Partner') }}</th>
                                            <th scope="col">{{ __('Registration_date') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestUsers->get() as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.clients.show', ['id' => $user->id]) }}" target="_blank">{{ $user->login }}</a>
                                            </td>
                                            <td>
                                                @if($partner = $user->partner)
                                                    <div class="badge badge-pill badge-info"><a href="{{ route('admin.clients.show', ['id' => $partner->id]) }}" target="_blank">{{ $partner->login }}</a></div>
                                                @else
                                                    <div class="badge badge-pill badge-warning">{{ __('No_partner') }}</div>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="iq-alert-icon">
                                                <i class="ri-information-line"></i>
                                            </div>
                                            <div class="iq-alert-text">{{ __('No_users_found') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">{{ __('New_deposits') }} </h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    @if($latestDeposits->count() > 0)
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            <th scope="col">{{ __('Rate') }}</th>
                                            <th scope="col">{{ __('Creation_date') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestDeposits->get() as $deposit)
                                            <?php
                                            if ($deposit->user == null) {
                                                die(print_r($deposit,true));
                                            }
                                            ?>
                                        <tr>
                                            <td>{{ amountWithPrecision($deposit->invested, $deposit->currency, '`') }}{{ $deposit->currency->symbol }}</td>
                                            <td>{{ $deposit->rate->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($deposit->created_at)->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="iq-alert-icon">
                                                <i class="ri-information-line"></i>
                                            </div>
                                            <div class="iq-alert-text">{{ __('No_new_deposits_found') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="iq-right-fixed rounded iq-card iq-card iq-card-block iq-card-stretch iq-card-height">
{{--                        <div class="iq-card-body">--}}
{{--                            <img src="/admin_assets/images/page-img/41.png" class="img-fluid iq-image-full w-100">--}}
{{--                        </div>--}}
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Latest_events') }}</h4>
                            </div>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
{{--                                <div class="dropdown">--}}
{{--                                 <span class="dropdown-toggle text-primary" id="dropdownMenuButton4" data-toggle="dropdown">--}}
{{--                                 View All--}}
{{--                                 </span>--}}
{{--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="iq-card-body">
                            @if($adminLogs->count() > 0)
                            <ul class="iq-timeline">
                                @foreach($adminLogs->get() as $adminLog)
                                <li>
                                    <div class="timeline-dots border-success"></div>
                                    <h6 class="float-left mb-1">{{ $adminLog->admin->login }}</h6>
                                    <small class="float-right mt-1">{{ \Carbon\Carbon::parse($adminLog->created_at)->toDateTimeString() }}</small>
                                    <div class="d-inline-block w-100">
                                        <p>{{ $adminLog->action }}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                                <div class="alert text-white bg-secondary" role="alert">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('No_events_found') }}</div>
                                </div>
                            @endif
                        </div>
{{--                        <div class="iq-card-header d-flex justify-content-between">--}}
{{--                            <div class="iq-header-title">--}}
{{--                                <h4 class="card-title">Country</h4>--}}
{{--                            </div>--}}
{{--                            <div class="iq-card-header-toolbar d-flex align-items-center">--}}
{{--                                <div class="dropdown">--}}
{{--                                    <span class="dropdown-toggle text-primary" id="dropdownMenuButton6" data-toggle="dropdown">--}}
{{--                                    <i class="ri-more-2-fill text-white"></i>--}}
{{--                                    </span>--}}
{{--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton6">--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>--}}
{{--                                        <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="iq-card-body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-12">--}}
{{--                                    <div class="iq-details">--}}
{{--                                        <span class="title">United States</span>--}}
{{--                                        <div class="percentage float-right text-primary">95 <span>%</span></div>--}}
{{--                                        <div class="iq-progress-bar-linear d-inline-block w-100">--}}
{{--                                            <div class="iq-progress-bar">--}}
{{--                                                <span class="bg-primary" data-percent="95"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="iq-details mt-3">--}}
{{--                                        <span class="title">India</span>--}}
{{--                                        <div class="percentage float-right text-success">75 <span>%</span></div>--}}
{{--                                        <div class="iq-progress-bar-linear d-inline-block w-100">--}}
{{--                                            <div class="iq-progress-bar">--}}
{{--                                                <span class="bg-success" data-percent="75"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="iq-details mt-3">--}}
{{--                                        <span class="title">Australia</span>--}}
{{--                                        <div class="percentage float-right text-spring-green">72 <span>%</span></div>--}}
{{--                                        <div class="iq-progress-bar-linear d-inline-block w-100">--}}
{{--                                            <div class="iq-progress-bar">--}}
{{--                                                <span class="bg-spring-green" data-percent="72"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper END -->
<!-- Footer -->
<footer class="bg-white iq-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('customer.main') }}">{{ __('Go_to_main_page') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-6 text-right">
                {{ date('Y') > 2020 ? '2020' : '' }}{{ date('Y') }} - <a href="https://hyiplab.net" target="_blank">Hyiplab</a>
            </div>
        </div>
    </div>
</footer>
<!-- Footer END -->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/admin_assets/js/jquery.min.js"></script>
<script src="/admin_assets/js/popper.min.js"></script>
<script src="/admin_assets/js/bootstrap.min.js"></script>
<!-- Appear JavaScript -->
<script src="/admin_assets/js/jquery.appear.js"></script>
<!-- Countdown JavaScript -->
<script src="/admin_assets/js/countdown.min.js"></script>
<!-- Counterup JavaScript -->
<script src="/admin_assets/js/waypoints.min.js"></script>
<script src="/admin_assets/js/jquery.counterup.min.js"></script>
<!-- Wow JavaScript -->
<script src="/admin_assets/js/wow.min.js"></script>
<!-- Apexcharts JavaScript -->
<script src="/admin_assets/js/apexcharts.js"></script>
<!-- Slick JavaScript -->
<script src="/admin_assets/js/slick.min.js"></script>
<!-- Select2 JavaScript -->
<script src="/admin_assets/js/select2.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="/admin_assets/js/owl.carousel.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="/admin_assets/js/jquery.magnific-popup.min.js"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="/admin_assets/js/smooth-scrollbar.js"></script>
<!-- lottie JavaScript -->
<script src="/admin_assets/js/lottie.js"></script>
<!-- core JavaScript -->
<script src="/admin_assets/js/core.js"></script>
<!-- charts JavaScript -->
<script src="/admin_assets/js/charts.js"></script>
<!-- animated JavaScript -->
<script src="/admin_assets/js/animated.js"></script>
<!-- Chart Custom JavaScript -->
<script src="/admin_assets/js/chart-custom.js"></script>
<!-- Custom JavaScript -->
<script src="/admin_assets/js/custom.js"></script>

@yield('js')
<!-- highcharts JavaScript -->
<script src="/admin_assets/js/highcharts.js"></script>
<!-- highcharts-3d JavaScript -->
<script src="/admin_assets/js/highcharts-3d.js"></script>
<!-- highcharts-more JavaScript -->
<script src="/admin_assets/js/highcharts-more.js"></script>

<script>
    if(jQuery('#menu-chart-02').length){
        var options = {
            series: [{
                name: '{{ __('Current_week') }}',
                data: ["{!! implode('", "', $investmentChartData['this_week']) !!}"]
            }, {
                name: '{{ __('Previous_week') }}',
                data: ["{!! implode('", "', $investmentChartData['previous_week']) !!}"]
            }],
            chart: {
                height: 350,
                foreColor: '#8c91b6',
                type: 'area'
            },
            colors: ['#0084ff','#00ca00'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                categories: ["{!! implode('", "', $investmentChartData['this_week_datetime']) !!}"]
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#menu-chart-02"), options);
        chart.render();
    }
</script>
<script>
    var options = {
        chart: {
            height: 80,
            type: 'area',
            sparkline: {
                enabled: true
            },
            group: 'sparklines',

        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.5,
                opacityTo: 0,
            }
        },
        series: [{
            name: '{{ __('withdrew') }}',
            data: ["{!! implode('", "', $withdrawChartData['this_week']) !!}"],
        }, ],
        colors: ['#00ca00'],

        xaxis: {
            type: 'datetime',
            categories: ["{!! implode('", "', $withdrawChartData['this_week_datetime']) !!}"],
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        }
    };
    if(jQuery('#chart-3').length){
        var chart = new ApexCharts(
            document.querySelector("#chart-3"),
            options
        );
        chart.render();
    }
</script>
<script>
    if(jQuery('#apex-pie-chart').length){
        var options = {
            chart: {
                foreColor: '#8c91b6',
                width: 280,
                type: 'pie',
            },
            labels: ['{{ __('Replenishments') }}', '{{ __('Withdrawals') }}'],
            series: [{{ $allTimeEnterPercent }}, {{ $allTimeWithdrawPercent }}],
            colors: ['#006400', '#ff9966'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position:'bottom',
                    }
                },
            }],
            legend: {
                show: false
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#apex-pie-chart"),
            options
        );

        chart.render();
    }
</script>
@if(count($ratesStat) > 0)
<script>
    // high-rates-chart
    if(jQuery('#high-rates-chart').length){
        Highcharts.chart('high-rates-chart', {

            chart: {
                backgroundColor: '{{ auth()->guard('admin')->user()->admin_template == 'light' ? '#F1F4FF' : '#2D325A' }}'
            },
            title: {
                text: '',

                style: {
                    color: '#8c91b6'
                },

            },

            subtitle: {
                text: ''
            },
            xAxis: {
                labels: {
                    style: {
                        color: '#8c91b6'
                    }
                },
                categories: ["{!! implode('","', $ratesStat['dates']) !!}"]
            },
            yAxis: {
                title: {
                    text: '{{ \App\Models\Currency::where('main_currency', 1)->first()->code ?? 'USD' }}'
                },
                labels: {
                    style: {
                        color: '#8c91b6'
                    }
                },
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                itemStyle: {
                    color: '#8c91b6'
                },
            },

            series: [
                <?php
                $faker = \Faker\Factory::create();
                ?>
                @foreach($ratesStat['rates'] as $rate)
                {
                    name: '{{ $rate['rate']->name }}',
                    data: [{{ implode(',', $rate['days']) }}],
                    color: '{{ $faker->hexColor }}'
                },
                @endforeach
            ],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    }
</script>
@endif
</body>
</html>