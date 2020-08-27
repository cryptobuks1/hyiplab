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
use App\Modules\PaymentSystems\BitcoinModule;
use Illuminate\Console\Command;

/**
 * Class CheckBitcoinConfirmationsCommand
 * @package App\Console\Commands\Automatic
 */
class CheckBitcoinConfirmationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:bitcoin_confirmations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking all bitcoin confirmations.';

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
     */
    public function handle()
    {
        $enterType      = TransactionType::getByName('enter');
        $paymentSysten  = PaymentSystem::where('code', 'bitcoin')->first();
        $transactions   = Transaction::where('type_id', $enterType->id)
            ->where('approved', 0)
            ->where('payment_system_id', $paymentSysten->id)
            ->whereNotNull('source')
            ->where('created_at', '>=', now()->subDays(3)->toDateTimeString())
            ->orderBy('created_at');

        $this->info('found '.$transactions->count().' transactions');

        /** @var Transaction $transaction */
        foreach ($transactions->get() as $transaction) {
            try {
                $bitcoin = new BitcoinModule();
                $getreceivedbyaddress = (float) $bitcoin->getreceivedbyaddress($transaction->source);
            } catch (\Exception $e) {
                $msg = 'Error while tried to get information about wallet: '.$e->getMessage();
                \Log::error($msg);
                $this->error($msg);
                continue;
            }

            if ($getreceivedbyaddress < $transaction->amount) {
                $transaction->result = 'accepted '.$getreceivedbyaddress.' from '.$transaction->amount;
                $transaction->save();

                $this->comment('transaction '.$transaction->amount.': '.$transaction->result);

                continue;
            }

            if ($getreceivedbyaddress >= $transaction->amount) {
                $transaction->approved = 1;
                $transaction->result = 'transfer accepted';
                $transaction->save();

                /** @var Wallet $wallet */
                $wallet = $transaction->wallet;
                $wallet->refill($transaction->amount, '');

                $this->comment('transaction '.$transaction->amount.': '.$transaction->result);

                continue;
            }
        }
    }
}
