<?php
namespace App\Observers;

use App\Models\Rate;

/**
 * Class RateObserver
 * @package App\Observers
 */
class RateObserver
{
    /**
     * @param Rate $rate
     */
    public function deleting(Rate $rate)
    {
        foreach ($rate->deposits()->get() as $deposit) {
            $deposit->delete();
        }

        foreach ($rate->transactions()->get() as $transaction) {
            $transaction->delete();
        }
    }

    /**
     * Listen to the Rate created event.
     *
     * @param Rate $rate
     * @return void
     * @throws
     */
    public function created(Rate $rate)
    {
        clearCacheByArray($this->getCacheKeys($rate));
        clearCacheByTags($this->getCacheTags($rate));
    }

    /**
     * @param Rate $rate
     * @return array
     */
    private function getCacheKeys(Rate $rate): array
    {
        return [];
    }

    /**
     * @param Rate $rate
     * @return array
     */
    private function getCacheTags(Rate $rate): array
    {
        return [];
    }

    /**
     * Listen to the Rate deleting event.
     *
     * @param Rate $rate
     * @return void
     * @throws
     */
    public function deleted(Rate $rate)
    {
        clearCacheByArray($this->getCacheKeys($rate));
        clearCacheByTags($this->getCacheTags($rate));
    }

    /**
     * Listen to the Rate updating event.
     *
     * @param Rate $rate
     * @return void
     * @throws
     */
    public function updated(Rate $rate)
    {
        clearCacheByArray($this->getCacheKeys($rate));
        clearCacheByTags($this->getCacheTags($rate));
    }
}