<?php
namespace App\Observers;

use App\Models\PageViews;

/**
 * Class PageViewsObserver
 * @package App\Observers
 */
class PageViewsObserver
{
    /**
     * Listen to the PageViews created event.
     *
     * @param PageViews $pageViews
     * @return void
     * @throws
     */
    public function created(PageViews $pageViews)
    {
        clearCacheByArray($this->getCacheKeys($pageViews));
        clearCacheByTags($this->getCacheTags($pageViews));
    }

    /**
     * @param PageViews $pageViews
     * @return array
     */
    private function getCacheKeys(PageViews $pageViews): array
    {
        return [];
    }

    /**
     * @param PageViews $pageViews
     * @return array
     */
    private function getCacheTags(PageViews $pageViews): array
    {
        return [];
    }

    /**
     * Listen to the PageViews deleting event.
     *
     * @param PageViews $pageViews
     * @return void
     * @throws
     */
    public function deleted(PageViews $pageViews)
    {
        clearCacheByArray($this->getCacheKeys($pageViews));
        clearCacheByTags($this->getCacheTags($pageViews));
    }

    /**
     * Listen to the PageViews updating event.
     *
     * @param PageViews $pageViews
     * @return void
     * @throws
     */
    public function updated(PageViews $pageViews)
    {
        clearCacheByArray($this->getCacheKeys($pageViews));
        clearCacheByTags($this->getCacheTags($pageViews));
    }
}