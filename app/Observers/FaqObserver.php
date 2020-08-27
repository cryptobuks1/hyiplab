<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Observers;

use App\Models\Faq;

/**
 * Class FaqObserver
 * @package App\Observers
 */
class FaqObserver
{
    /**
     * @param Faq $faq
     */
    public function deleting(Faq $faq)
    {
        
    }

    /**
     * Listen to the Faq created event.
     *
     * @param Faq $faq
     * @return void
     * @throws
     */
    public function created(Faq $faq)
    {
        clearCacheByArray($this->getCacheKeys($faq));
        clearCacheByTags($this->getCacheTags($faq));
    }

    /**
     * @param Faq $faq
     * @return array
     */
    private function getCacheKeys(Faq $faq): array
    {
        return [];
    }

    /**
     * @param Faq $faq
     * @return array
     */
    private function getCacheTags(Faq $faq): array
    {
        return [];
    }

    /**
     * Listen to the Faq deleting event.
     *
     * @param Faq $faq
     * @return void
     * @throws
     */
    public function deleted(Faq $faq)
    {
        clearCacheByArray($this->getCacheKeys($faq));
        clearCacheByTags($this->getCacheTags($faq));
    }

    /**
     * Listen to the Faq updating event.
     *
     * @param Faq $faq
     * @return void
     * @throws
     */
    public function updated(Faq $faq)
    {
        clearCacheByArray($this->getCacheKeys($faq));
        clearCacheByTags($this->getCacheTags($faq));
    }
}