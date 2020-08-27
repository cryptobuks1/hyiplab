@extends('admin.app')
@section('title', __('Statistic'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Statistic') }}</li>
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
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4>{{ __('Summary_statistics') }}</h4>
                                    <hr>
                                    <table class="table table-dark">
                                        <tbody>
                                        <tr>
                                            <td>{{ __('Total_users') }}</td>
                                            <td>{{ \App\Models\User::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total_deposits') }}</td>
                                            <td>{{ \App\Models\Deposit::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Sum_of_all_deposits') }}</td>
                                            @php($createDepType = \App\Models\TransactionType::getByName('create_dep'))
                                            <td>{{ amountWithPrecisionByCurrencyCode(\App\Models\Transaction::where('type_id', $createDepType->id)->sum('amount'), 'USD') }} $</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total_rates') }}</td>
                                            <td>{{ \App\Models\Rate::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total_user_wallets') }}</td>
                                            <td>{{ \App\Models\Wallet::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total_transactions') }}</td>
                                            <td>{{ \App\Models\Transaction::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total_page_views') }}</td>
                                            <td>{{ \App\Models\PageViews::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total currencies') }}</td>
                                            <td>{{ \App\Models\Currency::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total_payment_systems') }}</td>
                                            <td>{{ \App\Models\PaymentSystem::count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total_admins') }}</td>
                                            <td>{{ \App\Models\Admin::count() }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <h4>&nbsp;</h4>
                                    <hr>
                                    <div id="high-basicline-chart"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="apex-bubble-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- highcharts JavaScript -->
    <script src="/admin_assets/js/highcharts.js"></script>
    <!-- highcharts-3d JavaScript -->
    <script src="/admin_assets/js/highcharts-3d.js"></script>
    <!-- highcharts-more JavaScript -->
    <script src="/admin_assets/js/highcharts-more.js"></script>

<script>
    if(jQuery('#high-basicline-chart').length){
        Highcharts.chart('high-basicline-chart', {

            chart: {
                backgroundColor: '#2d325a'
            },
            title: {
                text: '{{ __('Server_load_for_last_1_week') }}',

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
                categories: ["{!! implode('","', $serverLoadLastWeek['dates']) !!}"]
            },
            yAxis: {
                title: {
                    text: '%'
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

            series: [{
                name: '{{ __('CPU') }}',
                data: [{{ implode(',', $serverLoadLastWeek['cpu']) }}],
                color: '#007bff'
            }, {
                name: '{{ __('RAM') }}',
                data: [{{ implode(',', $serverLoadLastWeek['ram']) }}],
                color: '#dc3545'
            }],

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
    <script>
        if(jQuery('#apex-bubble-chart').length){
            // function generateData(baseval, count, yrange) {
            //     var i = 0;
            //     var series = [];
            //     while (i < count) {
            //         var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
            //         var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;
            //
            //         series.push([baseval, y, z]);
            //         baseval += 86400000;
            //         i++;
            //     }
            //     return series;
            // }


            var options = {
                chart: {
                    foreColor: '#8c91b6',
                    height: 350,
                    type: 'bubble',
                },
                dataLabels: {
                    enabled: false
                },
                series: [
                    @foreach($popularUsers as $user)
                    {
                        name: '{{ $user->parent->login }}',
                        data: [
                            [new Date('{{ \Carbon\Carbon::parse($user->last_ref->created_at)->format('Y-m-d') }}').getTime(), {{ $user->user_count }}, {{ $user->user_count }}],
                        ]
                    },
                    @endforeach
                ],
                fill: {
                    type: 'gradient',
                },
                colors:['#0084ff', '#00ca00', '#e64141'],
                title: {
                    text: '{{ __('Most_active_refs') }}'
                },
                xaxis: {
                    tickAmount: 12,
                    type: 'datetime',

                    labels: {
                        rotate: 0,
                    }
                },
                yaxis: {
                    max: 40
                },
                theme: {
                    palette: 'palette2'
                }
            }

            var chart = new ApexCharts(
                document.querySelector("#apex-bubble-chart"),
                options
            );

            chart.render();
        }
    </script>
@endsection