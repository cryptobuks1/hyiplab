<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use App\Http\Controllers\Admin\WithdrawalRequestsController;
use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Console\Command;

/**
 * Class ProcessInstantPaymentsCommand
 * @package App\Console\Commands\Automatic
 *
 * TODO: консоль инстант выводов не закончен и не работает! Так как нет контроллера для обработки вывода средств в спейсе admin.
 */
class ProcessInstantPaymentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:instant_payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process customers instant payments.';

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
     * @throws \Throwable
     */
    public function handle()
    {
        /** @var TransactionType $transactionWithdrawType */
        $transactionWithdrawType = TransactionType::getByName('withdraw');

        /** @var Transaction $orders */
        $orders = Transaction::where('type_id', $transactionWithdrawType->id)
            ->where('result', null)
            ->where('approved', 0)
            ->orderBy('amount')
            ->orderBy('created_at')
            ->get();
        $messages = [];

        $this->info('Found '.$orders->count().' orders.');
        $this->line('---');

        /** @var Transaction $order */
        foreach ($orders as $order) {
            $this->info('Start processing withdraw order with ID '.$order->id.' and amount '.$order->amount);

            /** @var Wallet $wallet */
            $wallet = $order->wallet;
            
            if (null == $wallet) {
                continue;
            }

            /** @var PaymentSystem $paymentSystem */
            $paymentSystem = $wallet->paymentSystem;

            /** @var Currency $currency */
            $currency = $wallet->currency;

            if (null == $paymentSystem || null == $currency) {
                continue;
            }

            if (null === $limits = $paymentSystem->instant_limit) {
                $this->info('Limits is not set up..');
                continue;
            }

            $decodedLimits = @json_decode($limits, true);

            if (!isset($decodedLimits[$currency->code])) {
                $this->info('Limit for this currency '.$currency->code.' not found.');
                continue;
            }

            $limit = (float) $decodedLimits[$currency->code];

            if ($limit <= 0) {
                $this->info('Skip. Payment system instant limit is 0.');
                continue;
            }

            if ($order->amount > $limit) {
                $this->info('Skip. Order amount '.$order->amount.' and payment system limit '.$limit);
                continue;
            }

            /** @var User $user */
            $user = $wallet->user;

            $checkTodaysOrders = $user->transactions()
                ->where('type_id', $transactionWithdrawType->id)
                ->where('id', '!=', $order->id)
                ->where('created_at', '>=', now()->subHours(24))
                ->count();

            if ($checkTodaysOrders > 0) {
                continue;
            }

            try {
                $message = WithdrawalRequestsController::approve($order->id, true);
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

            $messages[] = $message;
        }

        if (count($messages) == 0) {
            return;
        }

        $msg = 'Processed '.count($messages).' instant payments. Results:\n'.implode('<hr>', $messages);
        $this->info($msg);
        \Log::info($msg);
    }
}
