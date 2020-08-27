<?php
namespace App\Observers;

use App\Models\TransactionType;

/**
 * Class TransactionTypeObserver
 * @package App\Observers
 */
class TransactionTypeObserver
{
    /**
     * @param TransactionType $transactionType
     */
    public function deleting(TransactionType $transactionType)
    {
        foreach ($transactionType->transactions()->get() as $transaction) {
            $transaction->delete();
        }
    }

    /**
     * @param TransactionType $transactionType
     * @return array
     */
    private function getCacheKeys(TransactionType $transactionType): array
    {
        return [];
    }

    /**
     * @param TransactionType $transactionType
     * @return array
     */
    private function getCacheTags(TransactionType $transactionType): array
    {
        return [];
    }

    /**
     * Listen to the TransactionType created event.
     *
     * @param TransactionType $transactionType
     * @return void
     * @throws
     */
    public function created(TransactionType $transactionType)
    {
        clearCacheByArray($this->getCacheKeys($transactionType));
        clearCacheByTags($this->getCacheTags($transactionType));
    }

    /**
     * Listen to the TransactionType deleting event.
     *
     * @param TransactionType $transactionType
     * @return void
     * @throws
     */
    public function deleted(TransactionType $transactionType)
    {
        clearCacheByArray($this->getCacheKeys($transactionType));
        clearCacheByTags($this->getCacheTags($transactionType));
    }

    /**
     * Listen to the TransactionType updating event.
     *
     * @param TransactionType $transactionType
     * @return void
     * @throws
     */
    public function updated(TransactionType $transactionType)
    {
        clearCacheByArray($this->getCacheKeys($transactionType));
        clearCacheByTags($this->getCacheTags($transactionType));
    }
}