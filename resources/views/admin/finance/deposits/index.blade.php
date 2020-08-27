@extends('admin.app')
@section('title', __('Deposits'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Deposits') }}</li>
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
                                <h4 class="card-title">{{ __('Deposits') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top" id="searchByRateForm">
                                            <div class="form-group mb-0">
                                                <label for="searchByRate">{{ __('Filter_by_rate') }}:</label>
                                                <select class="form-control" name="searchByRate" id="searchByRate">
                                                    <option value="">{{ __('any_rate') }}</option>
                                                    @foreach(\App\Models\Rate::orderBy('min')->get() as $rate)
                                                        <option value="{{ $rate->id }}"{{ request('searchByRate') == $rate->id ? ' selected' : '' }}>{{ $rate->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top" id="searchByUserForm">
                                            <div class="form-group mb-0">
                                                <label for="searchByUser">{{ __('Filter_by_clients') }}:</label>
                                                <select class="form-control" name="searchByUser" id="searchByUser">
                                                    <option value="">{{ __('any_client') }}</option>
                                                    @foreach(\App\Models\User::all() as $user)
                                                        <option value="{{ $user->id }}"{{ request('searchByUser') == $user->id ? ' selected' : '' }}>{{ $user->login }} - {{ $user->email }} [ref link: {{ $user->my_id }}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @if($deposits->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Client') }}</th>
                                        <th scope="col">{{ __('Investment') }}</th>
                                        <th scope="col">{{ __('Rate') }}</th>
                                        <th scope="col">{{ __('Next accrual') }}</th>
                                        <th scope="col">{{ __('Created') }}</th>
                                        <th scope="col">{{ __('Datetime closing') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deposits as $deposit)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.finance.deposits.show', ['id' => $deposit->id]) }}" target="_blank">{{ $deposit->id }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.clients.show', ['id' => $deposit->user->id]) }}" target="_blank">{{ $deposit->user->login }}</a>
                                            </td>
                                            <td>{{ amountWithPrecision($deposit->invested, $deposit->currency) }}{{ $deposit->currency->symbol }}</td>
                                            <td>{{ $deposit->rate->name }}</td>
                                            <td>
                                                <?php
                                                $nextAccrual = \App\Models\DepositQueue::where('deposit_id', $deposit->id)
                                                    ->where('type', \App\Models\DepositQueue::TYPE_ACCRUE)
                                                    ->where('done', 0)
                                                    ->orderBy('available_at')
                                                    ->limit(1)
                                                    ->first();
                                                ?>
                                                {{ null !== $nextAccrual ? __('after').' '.\Carbon\Carbon::parse($nextAccrual->available_at)->diffInHours().' '.__('h.') : __('undefined') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($deposit->created_at)->format('Y-m-d H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($deposit->datetime_closing)->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $deposits->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('No_deposits') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#searchByRate').select2();
            $('#searchByRate').change(function(){
                $('#searchByRateForm').submit();
            });

            $('#searchByUser').select2();
            $('#searchByUser').change(function(){
                $('#searchByUserForm').submit();
            });
        });
    </script>
@endsection