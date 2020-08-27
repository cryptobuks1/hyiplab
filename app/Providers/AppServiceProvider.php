<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Providers;

use App\Models\Admin;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Faq;
use App\Models\MailSent;
use App\Models\News;
use App\Models\PageViews;
use App\Models\PaymentSystem;
use App\Models\Rate;
use App\Models\Referral;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use App\Models\Wallet;
use App\Observers\CurrencyObserver;
use App\Observers\DepositObserver;
use App\Observers\FaqObserver;
use App\Observers\MailSentObserver;
use App\Observers\NewsObserver;
use App\Observers\PageViewsObserver;
use App\Observers\PaymentSystemObserver;
use App\Observers\RateObserver;
use App\Observers\ReferralObserver;
use App\Observers\SettingObserver;
use App\Observers\TransactionObserver;
use App\Observers\TransactionTypeObserver;
use App\Observers\UserObserver;
use App\Observers\WalletObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Horizon::auth(function ($request) {
            /** @var Admin $admin */
            $admin = auth()->guard('admin')->user();

            if (null == $admin) {
                return false;
            }

            if ($admin->can('horizon')) {
                return true;
            }

            return false;
        });

        Currency::observe(CurrencyObserver::class);
        Deposit::observe(DepositObserver::class);
        MailSent::observe(MailSentObserver::class);
        PageViews::observe(PageViewsObserver::class);
        PaymentSystem::observe(PaymentSystemObserver::class);
        Rate::observe(RateObserver::class);
        Referral::observe(ReferralObserver::class);
        Setting::observe(SettingObserver::class);
        Transaction::observe(TransactionObserver::class);
        TransactionType::observe(TransactionTypeObserver::class);
        User::observe(UserObserver::class);
        Wallet::observe(WalletObserver::class);
        Faq::observe(FaqObserver::class);
        News::observe(NewsObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
