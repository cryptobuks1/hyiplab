<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Observers;

use App\Models\Language;

/**
 * Class LanguageObserver
 * @package App\Observers
 */
class LanguageObserver
{
    /**
     * @param Language $language
     */
    public function deleting(Language $language)
    {
        foreach ($language->faq()->get() as $item) {
            $item->delete();
        }

        foreach ($language->news()->get() as $item) {
            $item->delete();
        }

        foreach ($language->testimonials()->get() as $item) {
            $item->delete();
        }
    }

    /**
     * Listen to the Language created event.
     *
     * @param Language $language
     * @return void
     * @throws
     */
    public function created(Language $language)
    {
        clearCacheByArray($this->getCacheKeys($language));
        clearCacheByTags($this->getCacheTags($language));
    }

    /**
     * @param Language $language
     * @return array
     */
    private function getCacheKeys(Language $language): array
    {
        return [];
    }

    /**
     * @param Language $language
     * @return array
     */
    private function getCacheTags(Language $language): array
    {
        return [];
    }

    /**
     * Listen to the Language deleting event.
     *
     * @param Language $language
     * @return void
     * @throws
     */
    public function deleted(Language $language)
    {
        clearCacheByArray($this->getCacheKeys($language));
        clearCacheByTags($this->getCacheTags($language));
    }

    /**
     * Listen to the Language updating event.
     *
     * @param Language $language
     * @return void
     * @throws
     */
    public function updated(Language $language)
    {
        clearCacheByArray($this->getCacheKeys($language));
        clearCacheByTags($this->getCacheTags($language));
    }
}