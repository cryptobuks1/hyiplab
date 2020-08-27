<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\Wallet;
use App\Modules\PaymentSystems\EthereumModule;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class CheckEthereumConfirmationsCommand
 * @package App\Console\Commands\Automatic
 */
class CheckEthereumConfirmationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:ethereum_confirmations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking all ethereum confirmations.';

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
            $this->line('---------------------');
            $this->comment('Working with wallet '.$account);

            try {
                $ethereum = new EthereumModule();
                $walletBalance = $ethereum->getBalance($account);
            } catch (\Exception $e) {
                $this->warn('Can not get balance for '.$account.', error - '.$e->getMessage());
                continue;
            }

            if (0 == $walletBalance) {
                $this->comment('Wallet '.$account.' balance is empty.. skipping.');
                continue;
            }

            if ($account == env('ETHEREUM_PARENT_WALLET')) {
                $this->comment('Account '.$account.' is PARENT. Skipping.. Account balance '.$walletBalance);
                continue;
            }

            /** @var TransactionType $enterType */
            $enterType = TransactionType::getByName('enter');
            /** @var PaymentSystem $paymentSysten */
            $paymentSysten = PaymentSystem::where('code', 'ethereum')->first();

            /** @var Transaction $searchTransaction */
            $searchTransaction = Transaction::where('type_id', $enterType->id)
                ->where('approved', 0)
                ->where('payment_system_id', $paymentSysten->id)
                ->where('source', $account)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->first();

            if (null == $searchTransaction) {
                $this->info('Transaction for wallet '.$account.' is not found. Balance '.$walletBalance.'. Sending money to PARENT wallet.');

                try {
                    $ethereum = new EthereumModule();
                    $ethereum->sendtoaddress($account, env('ETHEREUM_PARENT_WALLET'), $walletBalance);
                } catch (\Exception $e) {
                    $this->warn('Can not send money from '.$account.' to parent balance '.env('ETHEREUM_PARENT_WALLET').'. Amount '.$walletBalance.'. Error '.$e->getMessage());
                    continue;
                }

                $this->info('Successfully sent '.$walletBalance.' ETH to parent account. From '.$account.' to '.env('ETHEREUM_PARENT_WALLET'));
                continue;
            }

            if ($walletBalance < $searchTransaction->amount) {
                $this->info('Not enough money at balance. Balance: '.$walletBalance.', need: '.$searchTransaction->amount.' ETH ... Skipping.');

                if (Carbon::parse($searchTransaction->created_at)->diffInDays(now()) > 5) {
                    $this->info('Passed more than 5 days from wallet been created. Sending balance to parent.');

                    try {
                        $ethereum = new EthereumModule();
                        $txid = $ethereum->sendtoaddress($account, env('ETHEREUM_PARENT_WALLET'), $walletBalance);
                    } catch (\Exception $e) {
                        $this->warn('Can not send money from '.$account.' to parent balance '.env('ETHEREUM_PARENT_WALLET').'. Amount '.$walletBalance.'. Error '.$e->getMessage());
                        continue;
                    }

                    $searchTransaction->result = $txid;
                    $searchTransaction->save();

                    $this->info('Successfully sent '.$walletBalance.' ETH to parent account. From '.$account.' to '.env('ETHEREUM_PARENT_WALLET'));
                    continue;
                }

                $searchTransaction->result = 'accepted '.$walletBalance.' from '.$searchTransaction->amount;
                $searchTransaction->save();

                continue;
            }

            $searchTransaction->approved = 1;
            $searchTransaction->result = 'transfer accepted';
            $searchTransaction->save();

            /** @var Wallet $wallet */
            $wallet = $searchTransaction->wallet;
            $wallet->refill($searchTransaction->amount, '');

            $this->comment('transaction '.$searchTransaction->amount.': '.$searchTransaction->result);

            continue;
        }
    }
}
