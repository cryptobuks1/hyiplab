<?php
namespace App\Observers;

use App\Models\Deposit;
use App\Models\DepositQueue;

/**
 * Class DepositObserver
 * @package App\Observers
 */
class DepositObserver
{
    /**
     * @param Deposit $deposit
     */
    public function deleting(Deposit $deposit)
    {
        foreach ($deposit->transactions()->get() as $transaction) {
            $transaction->delete();
        }

        foreach ($deposit->queues()->get() as $queue) {
            $queue->delete();
        }
    }

    /**
     * @param Deposit $deposit
     * @return array
     */
    private function getCacheKeys(Deposit $deposit): array
    {
        return [];
    }

    /**
     * @param Deposit $deposit
     * @return array
     */
    private function getCacheTags(Deposit $deposit): array
    {
        return [];
    }

    /**
     * Listen to the Deposit created event.
     *
     * @param Deposit $deposit
     * @return void
     * @throws
     */
    public function created(Deposit $deposit)
    {
        clearCacheByArray($this->getCacheKeys($deposit));
        clearCacheByTags($this->getCacheTags($deposit));
    }

    /**
     * Listen to the Deposit deleting event.
     *
     * @param Deposit $deposit
     * @return void
     * @throws
     */
    public function deleted(Deposit $deposit)
    {
        clearCacheByArray($this->getCacheKeys($deposit));
        clearCacheByTags($this->getCacheTags($deposit));
    }

    /**
     * Listen to the Deposit updating event.
     *
     * @param Deposit $deposit
     * @return void
     * @throws
     */
    public function updated(Deposit $deposit)
    {
        clearCacheByArray($this->getCacheKeys($deposit));
        clearCacheByTags($this->getCacheTags($deposit));
    }
}