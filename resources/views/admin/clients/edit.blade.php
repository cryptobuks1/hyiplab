@extends('admin.app')
@section('title', __('Edit_data').': '.$user->login)

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">{{ __('Users') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.clients.show', ['id' => $user->id]) }}">{{ __('Profile') }}: {{ $user->login }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit_data') }}: {{ $user->login }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-body p-0">
                            <div class="iq-edit-list">
                                <ul class="iq-edit-profile d-flex nav nav-pills">
                                    <li class="col-md-3 p-0">
                                        <a class="nav-link active" data-toggle="pill" href="#personal-information">
                                            {{ __('Control_profile') }}
                                        </a>
                                    </li>
                                    <li class="col-md-3 p-0">
                                        <a class="nav-link" data-toggle="pill" href="#chang-pwd">
                                            {{ __('Change_password') }}
                                        </a>
                                    </li>
                                    <li class="col-md-3 p-0">
                                        <a class="nav-link" data-toggle="pill" href="#wallets">
                                            {{ __('Wallets') }}
                                        </a>
                                    </li>
                                    <li class="col-md-3 p-0">
                                        <a class="nav-link" data-toggle="pill" href="#manage-contact">
                                            {{ __('Deposits') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="iq-edit-list-data">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">{{ __('Control_profile') }}</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <form action="{{ route('admin.clients.update', ['id' => $user->id]) }}" method="POST" target="_top">
                                            {{ csrf_field() }}
{{--                                            <div class="form-group row align-items-center">--}}
{{--                                                <div class="col-md-12">--}}
{{--                                                    <div class="profile-img-edit">--}}
{{--                                                        <img class="profile-pic" src="/admin_assets/images/user/11.png" alt="profile-pic">--}}
{{--                                                        <div class="p-image">--}}
{{--                                                            <i class="ri-pencil-line upload-button"></i>--}}
{{--                                                            <input class="file-upload" type="file" accept="image/*"/>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class=" row align-items-center">
                                                <div class="form-group col-sm-6">
                                                    <label for="fname">{{ __('Name') }}:</label>
                                                    <input type="text" name="user[name]" class="form-control" id="fname" value="{{ $user->name }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="lname">{{ __('Email') }}:</label>
                                                    <input type="text" name="user[email]" class="form-control" id="lname" value="{{ $user->email }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>{{ __('Partner') }}:</label>
                                                    <select class="form-control" name="user[partner_id]" id="userPartnerId">
                                                        <option value="null">{{ __('no_partner') }}</option>
                                                        @foreach(\App\Models\User::all() as $u)
                                                            <option value="{{ $u->my_id }}"{{ $user->partner_id == $u->my_id ? ' selected' : '' }}>{{ $u->login }} - {{ $u->email }} [link: {{ $u->my_id }}]</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="cname">{{ __('Login') }}:</label>
                                                    <input type="text" name="user[login]" class="form-control" id="cname" value="{{ $user->login }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="d-block">{{ __('Gender') }}:</label>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio6" name="user[sex]" value="male" class="custom-control-input" {{ ($user->sex !== 'male' && $user->sex !== 'female') || $user->sex == 'male' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="customRadio6">
                                                            {{ __('Male') }} </label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio7" name="user[sex]" value="female" class="custom-control-input" {{ $user->sex == 'female' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="customRadio7">
                                                            {{ __('Famale') }} </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="dob">{{ __('Ref_link') }}:</label>
                                                    <input type="text" class="form-control" id="dob" name="user[my_id]" value="{{ $user->my_id }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="phone">{{ __('Phone_number') }}:</label>
                                                    <input type="text" class="form-control" id="phone" name="user[phone]" value="{{ $user->phone }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="skype">{{ __('Skype') }}:</label>
                                                    <input type="text" class="form-control" id="skype" name="user[skype]" value="{{ $user->skype }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>{{ __('Email_verified') }}:</label>
                                                    <select class="form-control" name="user[email_verified_at]" id="emailVerified">
                                                        <option value="0"{{ $user->email_verified_at == null ? ' selected' : '' }}>
                                                            {{ __('no') }}</option>
                                                        <option value="1"{{ $user->email_verified_at !== null ? ' selected' : '' }}>
                                                            {{ __('yes') }}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>{{ __('Representative_status') }}:</label>
                                                    <select class="form-control" name="user[representative]" id="representative">
                                                        <option value="0"{{ $user->representative == 0 ? ' selected' : '' }}>
                                                            {{ __('no') }}</option>
                                                        <option value="1"{{ $user->representative == 1 ? ' selected' : '' }}>
                                                            {{ __('yes') }}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>{{ __('Label_for_Email_tests') }}:</label>
                                                    <select class="form-control" name="user[email_tester]" id="email_tester">
                                                        <option value="0"{{ $user->email_tester == 0 ? ' selected' : '' }}>
                                                            {{ __('not_active') }}</option>
                                                        <option value="1"{{ $user->email_tester == 1 ? ' selected' : '' }}>
                                                            {{ __('active') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">{{ __('Save') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">{{ __('Change_password') }}</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <form action="{{ route('admin.clients.update_password', ['id' => $user->id]) }}" method="POST" target="_top">
                                            {{ csrf_field() }}

                                            <div class="form-group">
                                                <label for="npass">{{ __('New_password') }}:</label>
                                                <input type="Password" class="form-control" name="password" id="npass" value="">
                                            </div>
                                            <div class="form-group">
                                                <label for="vpass">{{ __('Type_again') }}:</label>
                                                <input type="Password" class="form-control" name="password_confirm" id="vpass" value="">
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">{{ __('Change_password') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="wallets" role="tabpanel">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">{{ __('Wallets') }}</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        @if($user->wallets()->count() > 0)
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Payment_System') }}</th>
                                                    <th scope="col">{{ __('Currency') }}</th>
                                                    <th scope="col">{{ __('Balance') }}</th>
                                                    <th scope="col">{{ __('Datetime_last_changed') }}</th>
                                                    <th scope="col">{{ __('Actions') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($wallets = $user->wallets()->orderBy('updated_at', 'desc')->paginate(20) as $wallet)
                                                    <form action="{{ route('admin.clients.update_balance', ['walletId' => $wallet->id]) }}" method="POST" target="_top">
                                                        {{ csrf_field() }}

                                                        <tr>
                                                            <td>{{ $wallet->paymentSystem->name }}</td>
                                                            <td>{{ $wallet->currency->name }}</td>
                                                            <td>
                                                                <input type="number" step="any" value="{{ amountWithPrecision($wallet->balance, $wallet->currency) }}" name="balance" placeholder="0">
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($wallet->updated_at)->diffForHumans() }}</td>
                                                            <td>
                                                                <input type="submit" class="btn btn-success" value="{{ __('save') }}">
                                                            </td>
                                                        </tr>
                                                    </form>
                                                @endforeach
                                                </tbody>
                                            </table>

                                            {!! $wallets->appends(request()->input())->links() !!}
                                        @else
                                            <div class="alert alert-secondary" role="alert">
                                                <div class="iq-alert-icon">
                                                    <i class="ri-information-line"></i>
                                                </div>
                                                <div class="iq-alert-text">{{ __('Wallets_not_found') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="manage-contact" role="tabpanel">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">{{ __('Deposits') }}</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        @if($deposits->count() > 0)
                                            <table class="table table-striped table-bordered mt-4">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{ __('Investments') }}</th>
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
                                            <div class="alert alert-secondary" role="alert">
                                                <div class="iq-alert-icon">
                                                    <i class="ri-information-line"></i>
                                                </div>
                                                <div class="iq-alert-text">{{ __('No deposits') }}</div>
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#userPartnerId').select2();
        });
    </script>
@endsection