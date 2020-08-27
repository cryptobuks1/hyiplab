<?php
namespace App\Observers;

use App\Models\Admin;

/**
 * Class AdminObserver
 * @package App\Observers
 */
class AdminObserver
{
    /**
     * @param Admin $admin
     * @throws \Exception
     */
    public function deleting(Admin $admin) {
        foreach ($admin->actionLogs()->get() as $item) {
            $item->delete();
        }
    }

    /**
     * @param Admin $admin
     * @return array
     */
    private function getCacheKeys(Admin $admin): array
    {
        return [];
    }

    /**
     * @param Admin $admin
     * @return array
     */
    private function getCacheTags(Admin $admin): array
    {
        return [];
    }

    /**
     * Listen to the Admin saving event.
     *
     * @param Admin $admin
     * @return void
     * @throws
     */
    public function saving(Admin $admin)
    {
        //
    }

    /**
     * Listen to the Admin deleting event.
     *
     * @param Admin $admin
     * @return void
     * @throws
     */
    public function deleted(Admin $admin)
    {
        clearCacheByArray($this->getCacheKeys($admin));
        clearCacheByTags($this->getCacheTags($admin));
    }
}