<?php
namespace App\Observers;

use App\Models\Referral;

/**
 * Class ReferralObserver
 * @package App\Observers
 */
class ReferralObserver
{
    /**
     * Listen to the Referral created event.
     *
     * @param Referral $referral
     * @return void
     * @throws
     */
    public function created(Referral $referral)
    {
        clearCacheByArray($this->getCacheKeys($referral));
        clearCacheByTags($this->getCacheTags($referral));
    }

    /**
     * @param Referral $referral
     * @return array
     */
    private function getCacheKeys(Referral $referral): array
    {
        return [];
    }

    /**
     * @param Referral $referral
     * @return array
     */
    private function getCacheTags(Referral $referral): array
    {
        return [];
    }

    /**
     * Listen to the Referral deleting event.
     *
     * @param Referral $referral
     * @return void
     * @throws
     */
    public function deleted(Referral $referral)
    {
        clearCacheByArray($this->getCacheKeys($referral));
        clearCacheByTags($this->getCacheTags($referral));
    }

    /**
     * Listen to the Referral updating event.
     *
     * @param Referral $referral
     * @return void
     * @throws
     */
    public function updated(Referral $referral)
    {
        clearCacheByArray($this->getCacheKeys($referral));
        clearCacheByTags($this->getCacheTags($referral));
    }
}