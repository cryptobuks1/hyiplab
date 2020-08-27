<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Jobs;

use App\Models\DepositQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Deposit;

/**
 * Class CloseDeposit
 * @package App\Jobs
 *
 * @property Deposit deposit
 * @property DepositQueue depositQueue
 */
class CloseDeposit implements ShouldQueue
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Deposit $deposit */
    protected $deposit;

    /** @var DepositQueue $depositQueue */
    protected $depositQueue;

    /**
     * CloseDeposit constructor.
     * @param Deposit $deposit
     * @param DepositQueue $depositQueue
     */
    public function __construct(Deposit $deposit, DepositQueue $depositQueue)
    {
        /** @var Deposit deposit */
        $this->deposit      = $deposit;

        /** @var DepositQueue depositQueue */
        $this->depositQueue = $depositQueue;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $deposit = $this->deposit;
        $depositQueue = $this->depositQueue;

        $deposit->refresh();
        $depositQueue->refresh();

        if ($depositQueue->fired == 1) {
            return 1;
        }

        $deposit->close($depositQueue);
    }
}
