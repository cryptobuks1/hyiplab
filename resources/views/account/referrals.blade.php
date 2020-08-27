@extends('layouts.account')
@section('title', __('Referrals'))

@section('content')
    @include('account.blocks.loader')
    @include('account.blocks.cp_navigation')

    <div class="cp_navi_main_wrapper inner_header_wrapper dashboard_header_middle float_left">
        <div class="container-fluid">
            @include('account.blocks.logo')
            @include('account.blocks.header')
            @include('account.blocks.top_header_right_wrapper')
            @include('account.blocks.menu')
        </div>
    </div>

    @include('account.blocks.dashboard_title')
    @include('account.blocks.sidebar')

    <!-- Main section Start -->
    <div class="l-main">
    @include('account.blocks.account_info')
        <!-- referrals wrapper start -->
        <div class="view_profile_wrapper_top float_left">

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">

                        <h3>@yield('title')</h3>

                    </div>
                </div>
                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="view_profile_wrapper float_left">
                        <ul class="profile_list referal_list">
                            <li><span class="detail_left_part">{{ __('Active_referrals') }}
</span> <span class="detail_right_part">{{ auth()->user()->referrals()->whereHas('deposits')->count() }}
</span>
                            </li>
                            <li><span class="detail_left_part">{{ __('Not_active_referrals') }}
 </span> <span class="detail_right_part">{{ auth()->user()->referrals()->doesnthave('deposits')->count() }}
</span>
                            </li>
                            <li><span class="detail_left_part">{{ __('Total_earned_on_referrals') }}</span> <span class="detail_right_part">${{ amountWithPrecisionByCurrencyCode(auth()->user()->transactions()->where('type_id', \App\Models\TransactionType::getByName('partner'))->sum('main_currency_amount'), 'USD') }} USD
</span>
                            </li>
                            <li><span class="detail_left_part">{{ __('Referral_link') }}</span> <span class="detail_right_part">{{ route('ref_link', ['partner_id' => auth()->user()->my_id]) }}</span>
                            </li>
                            <li><span class="detail_left_part">{{ __('Your_partner') }}</span> <span class="detail_right_part">{{ auth()->user()->partner->email ?? __('no_partner') }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- referrals wrapper end -->
        <!--  transactions wrapper start -->
        <div class="last_transaction_wrapper float_left">

            <div class="row">

                <div class="crm_customer_table_main_wrapper float_left">

                    <table style="width:100%; height:400px;">
                        <tr>
                            <td style="vertical-align: central; text-align: center;">
                                <iframe src="{{ route('account.reftree') }}" style="width:100%; height: 500px;"></iframe>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <!--  transactions wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection