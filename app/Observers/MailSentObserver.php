<?php
namespace App\Observers;

use App\Models\MailSent;

/**
 * Class MailSentObserver
 * @package App\Observers
 */
class MailSentObserver
{
    /**
     * Listen to the MailSent created event.
     *
     * @param MailSent $mailSent
     * @return void
     * @throws
     */
    public function created(MailSent $mailSent)
    {
        clearCacheByArray($this->getCacheKeys($mailSent));
        clearCacheByTags($this->getCacheTags($mailSent));
    }

    /**
     * @param MailSent $mailSent
     * @return array
     */
    private function getCacheKeys(MailSent $mailSent): array
    {
        return [];
    }

    /**
     * @param MailSent $mailSent
     * @return array
     */
    private function getCacheTags(MailSent $mailSent): array
    {
        return [];
    }

    /**
     * Listen to the MailSent deleting event.
     *
     * @param MailSent $mailSent
     * @return void
     * @throws
     */
    public function deleted(MailSent $mailSent)
    {
        clearCacheByArray($this->getCacheKeys($mailSent));
        clearCacheByTags($this->getCacheTags($mailSent));
    }

    /**
     * Listen to the MailSent updating event.
     *
     * @param MailSent $mailSent
     * @return void
     * @throws
     */
    public function updated(MailSent $mailSent)
    {
        clearCacheByArray($this->getCacheKeys($mailSent));
        clearCacheByTags($this->getCacheTags($mailSent));
    }
}