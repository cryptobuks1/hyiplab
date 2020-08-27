<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console;

use App\Console\Commands\Automatic\CheckEthereumConfirmationsCommand;
use App\Console\Commands\Automatic\CheckPaymentSystemsConnectionsCommand;
use App\Console\Commands\Automatic\CleanDemoCommand;
use App\Console\Commands\Automatic\CleanPageViewsCommand;
use App\Console\Commands\Automatic\CleanSentMailsCommand;
use App\Console\Commands\Automatic\DepositQueueCommand;
use App\Console\Commands\Automatic\GenerateDemoDataCommand;
use App\Console\Commands\Automatic\ProcessInstantPaymentsCommand;
use App\Console\Commands\Automatic\ScanSysLoadCommand;
use App\Console\Commands\Automatic\UpdateCurrencyRatesCommand;
use App\Console\Commands\Manual\CheckEthereumBalancesCommand;
use App\Console\Commands\Manual\CreateAdminCommand;
use App\Console\Commands\Manual\InstallScriptCommand;
use App\Console\Commands\Manual\RegisterCurrenciesCommand;
use App\Console\Commands\Manual\RegisterPaymentSystemsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CleanDemoCommand::class,
        GenerateDemoDataCommand::class,
        CreateAdminCommand::class,
        InstallScriptCommand::class,
        RegisterCurrenciesCommand::class,
        RegisterPaymentSystemsCommand::class,
        ProcessInstantPaymentsCommand::class,
        CheckPaymentSystemsConnectionsCommand::class,
        ScanSysLoadCommand::class,
        DepositQueueCommand::class,
        CleanSentMailsCommand::class,
        UpdateCurrencyRatesCommand::class,
        CheckEthereumConfirmationsCommand::class,
        CheckEthereumBalancesCommand::class,
        CleanPageViewsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // finances
        $schedule->command('deposits:queue')->everyMinute()->withoutOverlapping();
        $schedule->command('check:payment_systems_connections')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('process:instant_payments')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('check:bitcoin_confirmations')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('check:ethereum_confirmations')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('update:currency_rates')->hourly()->withoutOverlapping();

        // delete old data
        $schedule->command('log:clear')->daily()->withoutOverlapping();
        $schedule->command('clean:page_views')->hourly()->withoutOverlapping();
        $schedule->command('clean:demo')->daily()->at('03:00');

        // backups and server
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('scan:sys_load')->everyMinute()->withoutOverlapping();

        if (config('app.env') != 'demo') {
            $schedule->command('backup:run', ['--only-db'])->twiceDaily();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands/Automatic');
        $this->load(__DIR__ . '/Commands/Manual');

        require base_path('routes/console.php');
    }
}
