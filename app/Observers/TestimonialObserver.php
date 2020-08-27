<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Observers;

use App\Models\Testimonial;

/**
 * Class TestimonialObserver
 * @package App\Observers
 */
class TestimonialObserver
{
    /**
     * @param Testimonial $testimonial
     */
    public function deleting(Testimonial $testimonial)
    {

    }

    /**
     * Listen to the Testimonial created event.
     *
     * @param Testimonial $testimonial
     * @return void
     * @throws
     */
    public function created(Testimonial $testimonial)
    {
        clearCacheByArray($this->getCacheKeys($testimonial));
        clearCacheByTags($this->getCacheTags($testimonial));
    }

    /**
     * @param Testimonial $testimonial
     * @return array
     */
    private function getCacheKeys(Testimonial $testimonial): array
    {
        return [];
    }

    /**
     * @param Testimonial $testimonial
     * @return array
     */
    private function getCacheTags(Testimonial $testimonial): array
    {
        return [];
    }

    /**
     * Listen to the Testimonial deleting event.
     *
     * @param Testimonial $testimonial
     * @return void
     * @throws
     */
    public function deleted(Testimonial $testimonial)
    {
        clearCacheByArray($this->getCacheKeys($testimonial));
        clearCacheByTags($this->getCacheTags($testimonial));
    }

    /**
     * Listen to the Testimonial updating event.
     *
     * @param Testimonial $testimonial
     * @return void
     * @throws
     */
    public function updated(Testimonial $testimonial)
    {
        clearCacheByArray($this->getCacheKeys($testimonial));
        clearCacheByTags($this->getCacheTags($testimonial));
    }
}