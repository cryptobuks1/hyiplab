<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

Route::group(['middleware' => ['web']], function () {
    /*
     * User login routes
     */
    Auth::routes();

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot_password.reset');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('forgot_password.email');
//    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('user.logout');

    Route::group(['middleware' => ['site.status']], function () {
        /*
         * Technical routes
         */
        Route::get('/confirm_email/{hash}', 'Customer\ConfirmEmailController@index')->name('email.confirm');
        Route::get('/ref/{partner_id}', 'SetPartnerController@index')->name('ref_link');
        Route::get('/language/set/{code}', 'LanguageController@index')->name('language.set');
        Route::post('/support', 'SupportController@handle')->name('support.handle');
        Route::post('/subscribe', 'SubscribeController@handle')->name('subscribe.handle');

        // IPN
        Route::prefix('status')->namespace('Payment')->group(function () {
            Route::post('/perfectmoney', 'PerfectMoneyController@status')->name('perfectmoney.status');
            Route::post('/payeer', 'PayeerController@status')->name('payeer.status');
            Route::post('/coinpayments', 'CoinpaymentsController@status')->name('coinpayments.status');
            Route::post('/free-kassa', 'FreeKassaController@status')->name('free-kassa.status');
            Route::post('/yandex', 'FreeKassaController@status')->name('yandex.status');
            Route::post('/qiwi', 'FreeKassaController@status')->name('qiwi.status');
            Route::post('/visa_mastercard', 'FreeKassaController@status')->name('visa_mastercard.status');
        });

        /*
         * Basic routes
         */
        Route::namespace('Customer')->group(function () {
            Route::get('/', 'MainController@index')->name('customer.main');
            Route::get('/about-us', 'AboutUsController@index')->name('customer.about-us');
            Route::get('/contact-us', 'ContactUsController@index')->name('customer.contact-us');
            Route::get('/faq', 'FaqController@index')->name('customer.faq');
            Route::get('/investment', 'InvestmentController@index')->name('customer.investment');
        });

        /*
         * User profile routes
         */
        Route::group(['middleware' => ['auth']], function () {
            /*
             * Account technical routes
             */
            Route::get('/impersonate/leave', 'Admin\ImpersonateController@leave')->name('impersonate.leave');
            Route::get('/get_exchange_rate_by_wallet', 'Account\TechnicalController@getExchangeRateByWallet')->name('json.get_exchange_rate_by_wallet');
            Route::get('/get_user_exists_by_email_or_login', 'Account\TechnicalController@getUserExistsByEmailOrLogin')->name('json.get_user_exists_by_email_or_login');
            Route::get('/reftree', 'Account\TechnicalController@reftree')->name('account.reftree');

            /*
             * BUY balance
             */
            Route::prefix('buy')->namespace('Payment')->group(function () {
                Route::get('/perfectmoney', 'PerfectMoneyController@topUp')->name('account.buy.perfectmoney');
                Route::get('/payeer', 'PayeerController@topUp')->name('account.buy.payeer');
                Route::get('/coinpayments', 'CoinpaymentsController@topUp')->name('account.buy.coinpayments');
                Route::get('/bitcoin', 'BitcoinController@topUp')->name('account.buy.bitcoin');
                Route::get('/ethereum', 'EthereumController@topUp')->name('account.buy.ethereum');
                Route::get('/free-kassa', 'FreeKassaController@topUp')->name('account.buy.free-kassa');
                Route::get('/yandex', 'YandexController@topUp')->name('account.buy.yandex');
                Route::get('/qiwi', 'QiwiController@topUp')->name('account.buy.qiwi');
                Route::get('/visa_mastercard', 'VisaMastercardController@topUp')->name('account.buy.visa_mastercard');
            });

            // user account routes
            Route::prefix(env('ACCOUNT_URL', 'account'))->namespace('Account')->group(function () {
                Route::get('/', 'MyAccountController@index')->name('account.my-account');

                Route::get('/transactions', 'TransactionsController@index')->name('account.transactions');
                Route::get('/banners', 'BannersController@index')->name('account.banners');

                Route::get('/change_password', 'ChangePasswordController@index')->name('account.change-password');
                Route::post('/change_password', 'ChangePasswordController@handle')->name('account.change-password');

                Route::get('/change_pin', 'ChangePinController@index')->name('account.change-pin');
                Route::post('/change_pin', 'ChangePinController@handle')->name('account.change-pin');

                Route::get('/deposit_history', 'DepositHistoryController@index')->name('account.deposit-history');
                Route::get('/deposit_list', 'DepositListController@index')->name('account.deposit-list');
                Route::get('/earnings_history', 'EarningsHistoryController@index')->name('account.earnings-history');

                Route::get('/email_notification', 'EmailNotificationController@index')->name('account.email-notification');
                Route::post('/email_notification', 'EmailNotificationController@update')->name('account.email-notification');

                Route::get('/exchange_history', 'ExchangeHistoryController@index')->name('account.exchange-history');

                Route::get('/exchange_money', 'ExchangeMoneyController@index')->name('account.exchange-money');
                Route::post('/exchange_money', 'ExchangeMoneyController@handle')->name('account.exchange-money.handle');

                Route::get('/make_deposit', 'MakeDepositController@index')->name('account.make-deposit');
                Route::post('/make_deposit', 'MakeDepositController@handle')->name('account.make-deposit.handle');

                Route::get('/payment_request', 'PaymentRequestController@index')->name('account.payment-request');
                Route::post('/payment_request', 'PaymentRequestController@handle')->name('account.payment-request.handle');

                Route::get('/pending_history', 'PendingHistoryController@index')->name('account.pending-history');
                Route::get('/referral_earnings', 'ReferralEarningsController@index')->name('account.referral-earnings');
                Route::get('/referrals', 'ReferralsController@index')->name('account.referrals');
                Route::get('/tickets', 'TicketsController@index')->name('account.tickets');

                Route::get('/transfer_fund', 'TransferFundController@index')->name('account.transfer-fund');
                Route::post('/transfer_fund', 'TransferFundController@handle')->name('account.transfer-fund.handle');

                Route::get('/profile', 'ProfileController@index')->name('account.profile');
                Route::post('/profile', 'ProfileController@update')->name('account.profile');
            });
        });
    });

    /*
     * Admin panel routes
     */
    Route::prefix(env('ADMIN_URL', 'admin'))->namespace('Admin')->group(function () {
        /*
         * Admin login route
         */
        Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.handler');

        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::group(['middleware' => ['auth:admin']], function () {
            /*
             * Technical routes
             */
            Route::get('/', 'DashboardController@index')->name('admin.dashboard');
            Route::get('logout', '\App\Http\Controllers\Admin\Auth\AdminLoginController@logout')->name('admin.logout');
            Route::get('choose_template/{template}', '\App\Http\Controllers\Admin\ChooseTemplateController@index')->name('admin.choose_template');
            Route::post('servertime', '\App\Http\Controllers\Admin\ServertimeController@handle')->name('admin.servertime');

            Route::get('unlock', '\App\Http\Controllers\Admin\UnlockController@index')->name('admin.unlock');
            Route::post('unlock', '\App\Http\Controllers\Admin\UnlockController@handle')->name('admin.unlock.handle');

            // ---

            Route::group(['middleware' => ['permission:admin.impersonate']], function () {
                Route::get('/impersonate/{id}', 'ImpersonateController@impersonate')->name('admin.impersonate');
            });

            // ---

            Route::group(['middleware' => ['permission:logs']], function () {
                Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');
            });

            // ---

            Route::group(['middleware' => ['permission:admin.action_logs.index']], function () {
                Route::get('/action_logs', 'ActionLogsController@index')->name('admin.action_logs.index');
            });

            // ---

            Route::prefix('/settings/wallets')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.wallets.index']], function () {
                    Route::get('/', 'WalletsController@index')->name('admin.settings.wallets.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.wallets.create']], function () {
                    Route::get('/create', 'WalletsController@create')->name('admin.settings.wallets.create');
                });
                Route::group(['middleware' => ['permission:admin.settings.wallets.store']], function () {
                    Route::post('/store', 'WalletsController@store')->name('admin.settings.wallets.store');
                });
                Route::group(['middleware' => ['permission:admin.settings.wallets.update']], function () {
                    Route::post('/{id}/update', 'WalletsController@update')->name('admin.settings.wallets.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.wallets.destroy']], function () {
                    Route::get('/{id}/destroy', 'WalletsController@destroy')->name('admin.settings.wallets.destroy');
                });
            });

            // ---

            Route::prefix('/settings/rates')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.rates.index']], function () {
                    Route::get('/', 'RatesController@index')->name('admin.settings.rates.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.rates.create']], function () {
                    Route::get('/create', 'RatesController@create')->name('admin.settings.rates.create');
                });
                Route::group(['middleware' => ['permission:admin.settings.rates.store']], function () {
                    Route::post('/store', 'RatesController@store')->name('admin.settings.rates.store');
                });
                Route::group(['middleware' => ['permission:admin.settings.rates.update']], function () {
                    Route::post('/{id}/update', 'RatesController@update')->name('admin.settings.rates.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.rates.destroy']], function () {
                    Route::get('/{id}/destroy', 'RatesController@destroy')->name('admin.settings.rates.destroy');
                });
            });

            // ---

            Route::prefix('/settings/affiliate')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.affiliate.index']], function () {
                    Route::get('/', 'AffiliateController@index')->name('admin.settings.affiliate.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.affiliate.create']], function () {
                    Route::get('/create', 'AffiliateController@create')->name('admin.settings.affiliate.create');
                });
                Route::group(['middleware' => ['permission:admin.settings.affiliate.store']], function () {
                    Route::post('/store', 'AffiliateController@store')->name('admin.settings.affiliate.store');
                });
                Route::group(['middleware' => ['permission:admin.settings.affiliate.update']], function () {
                    Route::post('/{id}/update', 'AffiliateController@update')->name('admin.settings.affiliate.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.affiliate.destroy']], function () {
                    Route::get('/{id}/destroy', 'AffiliateController@destroy')->name('admin.settings.affiliate.destroy');
                });
            });

            // ---

            Route::prefix('/settings/mail')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.mail.index']], function () {
                    Route::get('/', 'MailController@index')->name('admin.settings.mail.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.mail.send']], function () {
                    Route::post('/send', 'MailController@send')->name('admin.settings.mail.send');
                });
            });

            // ---

            Route::prefix('/settings/backups')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.backups.index']], function () {
                    Route::get('/', 'BackupController@index')->name('admin.settings.backups.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.backups.backup_db']], function () {
                    Route::get('/backup_db', 'BackupController@backupDB')->name('admin.settings.backups.backup_db');
                });
                Route::group(['middleware' => ['permission:admin.settings.backups.backup_files']], function () {
                    Route::get('/backup_files', 'BackupController@backupFiles')->name('admin.settings.backups.backup_files');
                });
                Route::group(['middleware' => ['permission:admin.settings.backups.backup_all']], function () {
                    Route::get('/backup_all', 'BackupController@backupAll')->name('admin.settings.backups.backup_all');
                });
                Route::group(['middleware' => ['permission:admin.settings.backups.destroy']], function () {
                    Route::post('/destroy', 'BackupController@destroy')->name('admin.settings.backups.destroy');
                });
                Route::group(['middleware' => ['permission:admin.settings.backups.download']], function () {
                    Route::post('/download', 'BackupController@download')->name('admin.settings.backups.download');
                });
            });

            // ---

            Route::prefix('/settings/administrators')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.administrators.index']], function () {
                    Route::get('/', 'AdministratorsController@index')->name('admin.settings.administrators.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.administrators.create']], function () {
                    Route::get('/create', 'AdministratorsController@create')->name('admin.settings.administrators.create');
                });
                Route::group(['middleware' => ['permission:admin.settings.administrators.store']], function () {
                    Route::post('/store', 'AdministratorsController@store')->name('admin.settings.administrators.store');
                });
                Route::group(['middleware' => ['permission:admin.settings.administrators.show']], function () {
                    Route::get('/{id}', 'AdministratorsController@show')->name('admin.settings.administrators.show');
                });
                Route::group(['middleware' => ['permission:admin.settings.administrators.update']], function () {
                    Route::post('/{id}/update', 'AdministratorsController@update')->name('admin.settings.administrators.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.administrators.destroy']], function () {
                    Route::get('/{id}/destroy', 'AdministratorsController@destroy')->name('admin.settings.administrators.destroy');
                });
                Route::group(['middleware' => ['permission:admin.settings.administrators.update_password']], function () {
                    Route::post('/{id}/update_password', 'AdministratorsController@updatePassword')->name('admin.settings.administrators.update_password');
                });
            });

            // ---

            Route::prefix('/settings/translations')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.translations.index']], function () {
                    Route::get('/', 'TranslationsController@index')->name('admin.settings.translations.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.translations.update']], function () {
                    Route::post('/{key}/update', 'TranslationsController@update')->name('admin.settings.translations.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.translations.store']], function () {
                    Route::post('/store', 'TranslationsController@store')->name('admin.settings.translations.store');
                });
            });

            // ---

            Route::prefix('/settings/currencies')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.currencies.index']], function () {
                    Route::get('/', 'CurrenciesController@index')->name('admin.settings.currencies.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.currencies.create']], function () {
                    Route::get('/create', 'CurrenciesController@create')->name('admin.settings.currencies.create');
                });
                Route::group(['middleware' => ['permission:admin.settings.currencies.store']], function () {
                    Route::post('/store', 'CurrenciesController@store')->name('admin.settings.currencies.store');
                });
                Route::group(['middleware' => ['permission:admin.settings.currencies.show']], function () {
                    Route::get('/{id}', 'CurrenciesController@show')->name('admin.settings.currencies.show');
                });
                Route::group(['middleware' => ['permission:admin.settings.currencies.update']], function () {
                    Route::post('/{id}/update', 'CurrenciesController@update')->name('admin.settings.currencies.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.currencies.destroy']], function () {
                    Route::get('/{id}/destroy', 'CurrenciesController@destroy')->name('admin.settings.currencies.destroy');
                });
            });

            // ---

            Route::prefix('/settings/variables')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.variables.index']], function () {
                    Route::get('/', 'VariablesController@index')->name('admin.settings.variables.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.variables.create']], function () {
                    Route::get('/create', 'VariablesController@create')->name('admin.settings.variables.create');
                });
                Route::group(['middleware' => ['permission:admin.settings.variables.store']], function () {
                    Route::post('/store', 'VariablesController@store')->name('admin.settings.variables.store');
                });
                Route::group(['middleware' => ['permission:admin.settings.variables.update']], function () {
                    Route::post('/{id}/update', 'VariablesController@update')->name('admin.settings.variables.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.variables.destroy']], function () {
                    Route::get('/{id}/destroy', 'VariablesController@destroy')->name('admin.settings.variables.destroy');
                });
            });

            // ---

            Route::prefix('/settings/languages')->namespace('Settings')->group(function () {
                Route::group(['middleware' => ['permission:admin.settings.languages.index']], function () {
                    Route::get('/', 'LanguagesController@index')->name('admin.settings.languages.index');
                });
                Route::group(['middleware' => ['permission:admin.settings.languages.create']], function () {
                    Route::get('/create', 'LanguagesController@create')->name('admin.settings.languages.create');
                });
                Route::group(['middleware' => ['permission:admin.settings.languages.store']], function () {
                    Route::post('/store', 'LanguagesController@store')->name('admin.settings.languages.store');
                });
                Route::group(['middleware' => ['permission:admin.settings.languages.update']], function () {
                    Route::post('/{id}/update', 'LanguagesController@update')->name('admin.settings.languages.update');
                });
                Route::group(['middleware' => ['permission:admin.settings.languages.destroy']], function () {
                    Route::get('/{id}/destroy', 'LanguagesController@destroy')->name('admin.settings.languages.destroy');
                });
                Route::group(['middleware' => ['permission:admin.settings.languages.show']], function () {
                    Route::get('/{id}', 'LanguagesController@show')->name('admin.settings.languages.show');
                });
            });

            // ---

            Route::prefix('/finance/transactions')->namespace('Finance')->group(function () {
                Route::group(['middleware' => ['permission:admin.finance.transactions.index']], function () {
                    Route::get('/', 'TransactionsController@index')->name('admin.finance.transactions.index');
                });
                Route::group(['middleware' => ['permission:admin.finance.transactions.show']], function () {
                    Route::get('/{id}', 'TransactionsController@show')->name('admin.finance.transactions.show');
                });
                Route::group(['middleware' => ['permission:admin.finance.transactions.edit']], function () {
                    Route::get('/{id}/edit', 'TransactionsController@edit')->name('admin.finance.transactions.edit');
                });
                Route::group(['middleware' => ['permission:admin.finance.transactions.update']], function () {
                    Route::post('/{id}/update', 'TransactionsController@update')->name('admin.finance.transactions.update');
                });
                Route::group(['middleware' => ['permission:admin.finance.transactions.destroy']], function () {
                    Route::get('/{id}/destroy', 'TransactionsController@destroy')->name('admin.finance.transactions.destroy');
                });
            });

            // ---

            Route::prefix('/finance/deposits')->namespace('Finance')->group(function () {
                Route::group(['middleware' => ['permission:admin.finance.deposits.index']], function () {
                    Route::get('/', 'DepositsController@index')->name('admin.finance.deposits.index');
                });
                Route::group(['middleware' => ['permission:admin.finance.deposits.show']], function () {
                    Route::get('/{id}', 'DepositsController@show')->name('admin.finance.deposits.show');
                });
                Route::group(['middleware' => ['permission:admin.finance.deposits.update']], function () {
                    Route::post('/{id}/update', 'DepositsController@update')->name('admin.finance.deposits.update');
                });
                Route::group(['middleware' => ['permission:admin.finance.deposits.destroy']], function () {
                    Route::get('/{id}/destroy', 'DepositsController@destroy')->name('admin.finance.deposits.destroy');
                });
            });

            // ---

            Route::prefix('/finance/withdrawals')->namespace('Finance')->group(function () {
                Route::group(['middleware' => ['permission:admin.finance.withdrawals.index']], function () {
                    Route::get('/', 'WithdrawalsController@index')->name('admin.finance.withdrawals.index');
                });
                Route::group(['middleware' => ['permission:admin.finance.withdrawals.approve']], function () {
                    Route::get('/{id}/approve', 'WithdrawalsController@approve')->name('admin.finance.withdrawals.approve');
                });
                Route::group(['middleware' => ['permission:admin.finance.withdrawals.manually']], function () {
                    Route::get('/{id}/manually', 'WithdrawalsController@manually')->name('admin.finance.withdrawals.manually');
                });
                Route::group(['middleware' => ['permission:admin.finance.withdrawals.reject']], function () {
                    Route::get('/{id}/reject', 'WithdrawalsController@reject')->name('admin.finance.withdrawals.reject');
                });
            });

            // ---

            Route::prefix('/finance/statistic')->namespace('Finance')->group(function () {
                Route::group(['middleware' => ['permission:admin.finance.statistic.index']], function () {
                    Route::get('/', 'StatisticController@index')->name('admin.finance.statistic.index');
                });
            });

            // ---

            Route::prefix('/clients')->namespace('Clients')->group(function () {
                Route::group(['middleware' => ['permission:admin.clients.index']], function () {
                    Route::get('', 'ClientsController@index')->name('admin.clients.index');
                });
                Route::group(['middleware' => ['permission:admin.clients.show']], function () {
                    Route::get('/{id}', 'ClientsController@show')->name('admin.clients.show');
                });
                Route::group(['middleware' => ['permission:admin.clients.reftree']], function () {
                    Route::get('/{id}/reftree', 'ClientsController@reftree')->name('admin.clients.reftree');
                });
                Route::group(['middleware' => ['permission:admin.clients.page_views']], function () {
                    Route::get('/{id}/page_views', 'ClientPageViewsController@index')->name('admin.clients.page_views');
                });
                Route::group(['middleware' => ['permission:admin.clients.logs']], function () {
                    Route::get('/{id}/logs', 'ClientLogsController@index')->name('admin.clients.logs');
                });
                Route::group(['middleware' => ['permission:admin.clients.edit']], function () {
                    Route::get('/{id}/edit', 'ClientsController@edit')->name('admin.clients.edit');
                });
                Route::group(['middleware' => ['permission:admin.clients.update']], function () {
                    Route::post('/{id}/update', 'ClientsController@update')->name('admin.clients.update');
                });
                Route::group(['middleware' => ['permission:admin.clients.update_password']], function () {
                    Route::post('/{id}/update_password', 'ClientsController@updatePassword')->name('admin.clients.update_password');
                });
                Route::group(['middleware' => ['permission:admin.clients.update_balance']], function () {
                    Route::post('/{walletId}/update_balance', 'ClientsController@updateBalance')->name('admin.clients.update_balance');
                });
                Route::group(['middleware' => ['permission:admin.clients.block']], function () {
                    Route::get('/{id}/block', 'ClientsController@block')->name('admin.clients.block');
                });
                Route::group(['middleware' => ['permission:admin.clients.unblock']], function () {
                    Route::get('/{id}/unblock', 'ClientsController@unblock')->name('admin.clients.unblock');
                });
            });

            // ---

            Route::prefix('/content/news')->namespace('Content')->group(function () {
                Route::group(['middleware' => ['permission:admin.content.news.index']], function () {
                    Route::get('/', 'NewsController@index')->name('admin.content.news.index');
                });
                Route::group(['middleware' => ['permission:admin.content.news.create']], function () {
                    Route::get('/create', 'NewsController@create')->name('admin.content.news.create');
                });
                Route::group(['middleware' => ['permission:admin.content.news.store']], function () {
                    Route::post('/store', 'NewsController@store')->name('admin.content.news.store');
                });
                Route::group(['middleware' => ['permission:admin.content.news.update']], function () {
                    Route::post('/{id}/update', 'NewsController@update')->name('admin.content.news.update');
                });
                Route::group(['middleware' => ['permission:admin.content.news.destroy']], function () {
                    Route::get('/{id}/destroy', 'NewsController@destroy')->name('admin.content.news.destroy');
                });
                Route::group(['middleware' => ['permission:admin.content.news.show']], function () {
                    Route::get('/{id}', 'NewsController@show')->name('admin.content.news.show');
                });
            });

            // ---

            Route::prefix('/content/faq')->namespace('Content')->group(function () {
                Route::group(['middleware' => ['permission:admin.content.faq.index']], function () {
                    Route::get('/', 'FaqController@index')->name('admin.content.faq.index');
                });
                Route::group(['middleware' => ['permission:admin.content.faq.create']], function () {
                    Route::get('/create', 'FaqController@create')->name('admin.content.faq.create');
                });
                Route::group(['middleware' => ['permission:admin.content.faq.store']], function () {
                    Route::post('/store', 'FaqController@store')->name('admin.content.faq.store');
                });
                Route::group(['middleware' => ['permission:admin.content.faq.update']], function () {
                    Route::post('/{id}/update', 'FaqController@update')->name('admin.content.faq.update');
                });
                Route::group(['middleware' => ['permission:admin.content.faq.destroy']], function () {
                    Route::get('/{id}/destroy', 'FaqController@destroy')->name('admin.content.faq.destroy');
                });
                Route::group(['middleware' => ['permission:admin.content.faq.show']], function () {
                    Route::get('/{id}', 'FaqController@show')->name('admin.content.faq.show');
                });
            });

            // ---

            Route::prefix('/content/testimonials')->namespace('Content')->group(function () {
                Route::group(['middleware' => ['permission:admin.content.testimonials.index']], function () {
                    Route::get('/', 'TestimonialsController@index')->name('admin.content.testimonials.index');
                });
                Route::group(['middleware' => ['permission:admin.content.testimonials.create']], function () {
                    Route::get('/create', 'TestimonialsController@create')->name('admin.content.testimonials.create');
                });
                Route::group(['middleware' => ['permission:admin.content.testimonials.store']], function () {
                    Route::post('/store', 'TestimonialsController@store')->name('admin.content.testimonials.store');
                });
                Route::group(['middleware' => ['permission:admin.content.testimonials.update']], function () {
                    Route::post('/{id}/update', 'TestimonialsController@update')->name('admin.content.testimonials.update');
                });
                Route::group(['middleware' => ['permission:admin.content.testimonials.destroy']], function () {
                    Route::get('/{id}/destroy', 'TestimonialsController@destroy')->name('admin.content.testimonials.destroy');
                });
                Route::group(['middleware' => ['permission:admin.content.testimonials.show']], function () {
                    Route::get('/{id}', 'TestimonialsController@show')->name('admin.content.testimonials.show');
                });
            });

            // ---

            Route::prefix('/tickets')->group(function () {
                Route::group(['middleware' => ['permission:admin.tickets.index']], function () {
                    Route::get('/', 'TicketsController@index')->name('admin.tickets.index');
                });
            });
        });
    });
});
