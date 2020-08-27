<?php
namespace App\Observers;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\User;

/**
 * Class TransactionObserver
 * @package App\Observers
 */
class TransactionObserver
{
    public function creating(Transaction $transaction)
    {
        $amount     = $transaction->amount;
        $currency   = $transaction->currency;

        /** @var Currency $mainCurrency */
        $mainCurrency = Currency::where('main_currency', 1)->first();

        if (null !== $currency && null !== $mainCurrency && $amount > 0) {
            if ($currency->code == $mainCurrency->code) {
                $transaction->main_currency_amount = $amount;
            } else {
                $transaction->main_currency_amount = convertToCurrency($currency, $mainCurrency, $amount);
            }
        }
    }

    /**
     * @param Transaction $transaction
     * @return array
     * @throws
     */
    private function getCacheKeys(Transaction $transaction): array
    {
        return [];
    }

    /**
     * @param Transaction $transaction
     * @return array
     * @throws \Exception
     */
    private function getCacheTags(Transaction $transaction): array
    {
        return [];
    }

    /**
     * @param Transaction $transaction
     */
    public function updating(Transaction $transaction)
    {
        $amount     = $transaction->amount;
        $currency   = $transaction->currency;

        /** @var Currency $mainCurrency */
        $mainCurrency = Currency::where('main_currency', 1)->first();

        if (null !== $currency && null !== $mainCurrency && $amount > 0) {
            if ($currency->code == $mainCurrency->code) {
                $transaction->main_currency_amount = $amount;
            } else {
                $transaction->main_currency_amount = convertToCurrency($currency, $mainCurrency, $amount);
            }
        }
    }

    /**
     * Listen to the Transaction created event.
     *
     * @param Transaction $transaction
     * @return void
     * @throws
     */
    public function created(Transaction $transaction)
    {
        clearCacheByArray($this->getCacheKeys($transaction));
        clearCacheByTags($this->getCacheTags($transaction));
    }

    /**
     * Listen to the Transaction deleting event.
     *
     * @param Transaction $transaction
     * @return void
     * @throws
     */
    public function deleted(Transaction $transaction)
    {
        clearCacheByArray($this->getCacheKeys($transaction));
        clearCacheByTags($this->getCacheTags($transaction));
    }

    /**
     * Listen to the Transaction updating event.
     *
     * @param Transaction $transaction
     * @return void
     * @throws
     */
    public function updated(Transaction $transaction)
    {
        clearCacheByArray($this->getCacheKeys($transaction));
        clearCacheByTags($this->getCacheTags($transaction));
    }
}