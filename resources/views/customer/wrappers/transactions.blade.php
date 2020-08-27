<!-- transaction wrapper start -->
<div class="transaction_wrapper float_left">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="sv_heading_wraper heading_wrapper_dark dark_heading index2_heading index2_heading_center index3_heading ">
                    <h4>{{ __('check') }}</h4>
                    <h3>{{ __('Latest_transactions') }}</h3>
                    <div class="line_shape line_shape2"></div>

                </div>
                <div class="x_offer_tabs_wrapper index3_offer_tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home"> {{ __('investments') }}</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#menu2">{{ __('withdrawals') }}</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table_next_race index3_table_race league_table overflow-scroll">
                                    @php($transactions = \App\Models\Transaction::where('type_id', \App\Models\TransactionType::getByName('enter')->id)->where('approved', 1)->orderBy('created_at', 'desc')->limit(8)->get())
                                    @if(count($transactions))
                                        <table class="table table-striped table-bordered mt-4">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('Payment_System') }}</th>
                                                <th scope="col">{{ __('Amount') }}</th>
                                                <th scope="col">{{ __('Client') }}</th>
                                                <th scope="col">{{ __('Date') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->paymentSystem->name }}</td>
                                                    <td>{{ amountWithPrecision($transaction->amount, $transaction->currency) }}{{ $transaction->currency->symbol }}</td>
                                                    <td>
                                                        {{ $transaction->user->login }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="iq-alert-icon">
                                                <i class="ri-information-line"></i>
                                            </div>
                                            <div class="iq-alert-text">{{ __('No_withdrawals_found') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table_next_race index3_table_race league_table overflow-scroll">
                                    @php($transactions = \App\Models\Transaction::where('type_id', \App\Models\TransactionType::getByName('withdraw')->id)->where('approved', 1)->orderBy('created_at', 'desc')->limit(8)->get())
                                    @if(count($transactions))
                                        <table class="table table-striped table-bordered mt-4">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('Payment_System') }}</th>
                                                <th scope="col">{{ __('Amount') }}</th>
                                                <th scope="col">{{ __('Client') }}</th>
                                                <th scope="col">{{ __('Batch') }}</th>
                                                <th scope="col">{{ __('Date') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->paymentSystem->name }}</td>
                                                    <td>{{ amountWithPrecision($transaction->amount, $transaction->currency) }}{{ $transaction->currency->symbol }}</td>
                                                    <td>
                                                        {{ $transaction->user->login }}
                                                    </td>
                                                    <td>{!! !empty($transaction->batch_id) ? '<input type="text" value="'.$transaction->batch_id.'" readonly>' : '<span class="badge border border-warning text-warning">'.__('no_batch').'</span>' !!}</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="iq-alert-icon">
                                                <i class="ri-information-line"></i>
                                            </div>
                                            <div class="iq-alert-text">{{ __('No_withdrawals_found') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- transaction wrapper start -->