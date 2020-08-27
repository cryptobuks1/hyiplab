<li class="{{ \Route::is('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}"><i class="ri-home-4-line"></i><span>{{ __('Dashboard') }}</span></a>
</li>
@if(admin()->can('admin.clients.index'))
    <li class="{{ \Route::is('admin.clients.*') ? 'active' : '' }}">
        <a href="{{ route('admin.clients.index') }}"><i class="la la-users"></i><span>{{ __('Clients') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\User::count() }}</span></a>
    </li>
@endif
@if(admin()->can('admin.action_logs.index'))
    <li class="{{ \Route::is('admin.action_logs.*') ? 'active' : '' }}">
        <a href="{{ route('admin.action_logs.index') }}"><i class="la la-shoe-prints"></i><span>{{ __('Logs') }}</span></a>
    </li>
@endif

        @if(admin()->can('admin.finance.transactions.index'))
            <li class="{{ \Route::is('admin.finance.transactions.index') ? 'active' : '' }}">
                <a href="{{ route('admin.finance.transactions.index') }}"><i class="la la-history"></i><span>{{ __('Transactions') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Transaction::count() }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.finance.deposits.index'))
            <li class="{{ \Route::is('admin.finance.deposits.index') ? 'active' : '' }}">
                <a href="{{ route('admin.finance.deposits.index') }}"><i class="la la-business-time"></i><span>{{ __('Deposits') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Deposit::count() }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.finance.withdrawals.index'))
            <li class="{{ \Route::is('admin.finance.withdrawals.index') ? 'active' : '' }}">
                <a href="{{ route('admin.finance.withdrawals.index') }}"><i class="la la-money-bill"></i><span>{{ __('Withdrawals') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Transaction::where('type_id', \App\Models\TransactionType::getByName('withdraw')->id)->where('approved', 0)->count() }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.finance.statistic.index'))
            <li class="{{ \Route::is('admin.finance.statistic.index') ? 'active' : '' }}">
                <a href="{{ route('admin.finance.statistic.index') }}"><i class="la la-tachometer"></i><span>{{ __('Statistic') }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.settings.currencies.index'))
            <li class="{{ \Route::is('admin.settings.currencies.index') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.currencies.index') }}"><i class="la la-dollar"></i><span>{{ __('Currencies') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Currency::count() }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.settings.variables.index'))
            <li class="{{ \Route::is('admin.settings.variables.index') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.variables.index') }}"><i class="la la-box"></i><span>{{ __('Variables') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Setting::count() }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.settings.wallets.index'))
            <li class="{{ \Route::is('admin.settings.wallets.index') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.wallets.index') }}"><i class="la la-wallet"></i><span>{{ __('Wallets') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Wallet::count() }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.settings.rates.index'))
            <li class="{{ \Route::is('admin.settings.rates.index') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.rates.index') }}"><i class="la la-funnel-dollar"></i><span>{{ __('Rates') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Rate::count() }}</span></a>
            </li>
        @endif
@if(admin()->can('admin.settings.affiliate.index'))
    <li class="{{ \Route::is('admin.settings.affiliate.index') ? 'active' : '' }}">
        <a href="{{ route('admin.settings.affiliate.index') }}"><i class="la la-handshake"></i><span>{{ __('Affiliate') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Referral::count() }}</span></a>
    </li>
@endif
@if(admin()->can('admin.settings.languages.index'))
    <li class="{{ \Route::is('admin.settings.languages.index') ? 'active' : '' }}">
        <a href="{{ route('admin.settings.languages.index') }}"><i class="la la-language"></i><span>{{ __('Languages') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Language::count() }}</span></a>
    </li>
@endif
        @if(admin()->can('admin.settings.mail.index'))
            <li class="{{ \Route::is('admin.settings.mail.index') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.mail.index') }}"><i class="la la-mail-bulk"></i><span>{{ __('Mail') }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.settings.backups.index'))
            <li class="{{ \Route::is('admin.settings.backups.index') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.backups.index') }}"><i class="la la-cloud"></i><span>{{ __('Backups') }}</span></a>
            </li>
        @endif
        @if(admin()->can('admin.settings.administrators.index'))
            <li class="{{ \Route::is('admin.settings.administrators.index') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.administrators.index') }}"><i class="la la-user-astronaut"></i><span>{{ __('Administrators') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Admin::count() }}</span></a>
            </li>
        @endif
@if(admin()->can('admin.settings.translations.index'))
    <li class="{{ \Route::is('admin.settings.translations.index') ? 'active' : '' }}">
        <a href="{{ route('admin.settings.translations.index') }}"><i class="la la-language"></i><span>{{ __('Translations') }}</span></a>
    </li>
@endif

@if(admin()->can('admin.content.news.index'))
    <li class="{{ \Route::is('admin.content.news.index') ? 'active' : '' }}">
        <a href="{{ route('admin.content.news.index') }}"><i class="la la-newspaper"></i><span>{{ __('News') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\News::count() }}</span></a>
    </li>
@endif

@if(admin()->can('admin.content.faq.index'))
    <li class="{{ \Route::is('admin.content.faq.index') ? 'active' : '' }}">
        <a href="{{ route('admin.content.faq.index') }}"><i class="la la-question-circle"></i><span>{{ __('FAQ') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Faq::count() }}</span></a>
    </li>
@endif

@if(admin()->can('admin.content.testimonials.index'))
    <li class="{{ \Route::is('admin.content.testimonials.index') ? 'active' : '' }}">
        <a href="{{ route('admin.content.testimonials.index') }}"><i class="la la-comment"></i><span>{{ __('Testimonials') }}</span><span class="badge border border-light text-light" style="float:right; padding:3px;">{{ \App\Models\Testimonial::count() }}</span></a>
    </li>
@endif

@if(admin()->can('admin.tickets.index'))
{{--    <li class="{{ \Route::is('admin.tickets.index') ? 'active' : '' }}">--}}
{{--        <a href="{{ route('admin.tickets.index') }}"><i class="la la-support"></i><span>{{ __('Tickets') }}</span></a>--}}
{{--    </li>--}}
@endif
