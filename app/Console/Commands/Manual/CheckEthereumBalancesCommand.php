<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Manual;

use App\Modules\PaymentSystems\EthereumModule;
use Illuminate\Console\Command;

/**
 * Class CheckEthereumBalancesCommand
 * @package App\Console\Commands\Manual
 */
class CheckEthereumBalancesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:ethereum_balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking all ethereum balances.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function handle()
    {
        try {
            $ethereum = new EthereumModule();
            $accounts = json_decode($ethereum->getAccounts(), true);
        } catch (\Exception $e) {
            $this->error('Can not get accounts: '.$e->getMessage());
            return;
        }

        foreach ($accounts as $account) {
            try {
                $ethereum = new EthereumModule();
                $walletBalance = $ethereum->getBalance($account);
            } catch (\Exception $e) {
                $this->warn('Can not get balance for '.$account.', error - '.$e->getMessage());
                continue;
            }

            $main = env('ETHEREUM_PARENT_WALLET') == $account ? ' MAIN' : '';
            $this->info($walletBalance.$main.' -> '.$account);
        }
    }
}
