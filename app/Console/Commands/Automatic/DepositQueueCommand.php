<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use App\Jobs\AccrueDeposit;
use App\Jobs\CloseDeposit;
use App\Models\DepositQueue;
use Illuminate\Console\Command;

/**
 * Class DepositQueueCommand
 * @package App\Console\Commands\Automatic
 */
class DepositQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposits:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run deposits queues.';

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
     * @return void
     */
    public function handle()
    {
        /** @var DepositQueue $queues */
        $queues = DepositQueue::where('available_at', '<=', now()->toDateTimeString())
            ->where('done', 0)
            ->where('fired', 0)
            ->orderBy('available_at');

        if ($queues->count() === 0) {
            $this->warn('Available deposits queue not found.');
            return;
        }

        /** @var DepositQueue $queue */
        foreach ($queues->get() as $queue){
            $queue->fired = 1;
            $queue->save();

            /** @var DepositQueue $deposit */
            $deposit = $queue->deposit;

            if ($queue->isTypeAccrue()) {
                AccrueDeposit::dispatch($deposit, $queue)->onQueue(getSupervisorName().'-high')->delay(now());
                $this->info('Deposit '.$deposit->id.'. Queue "accrue" sent to work.');
                continue;
            }

            if ($queue->isTypeClosing()) {
                CloseDeposit::dispatch($deposit, $queue)->onQueue(getSupervisorName().'-high')->delay(now());
                $this->info('Deposit '.$deposit->id.'. Queue "closing" sent to work.');
                continue;
            }
        }
    }
}
