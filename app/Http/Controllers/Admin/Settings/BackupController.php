<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class BackupController
 * @package App\Http\Controllers\Admin\Settings
 */
class BackupController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $backups = \Storage::disk('dropbox')->files($path = preg_replace('/[^a-zA-Z0-9.]/', '-', env('APP_NAME', $_SERVER['HTTP_HOST'])));
        } catch (\Exception $e) {
            back()->with('error', __('unable_to_connect_to_dropbox'));

            return view('admin.settings.backups.index', [
                'backups' => [],
            ]);
        }

        if ($request->has('search')) {
            foreach ($backups as $key => $file) {
                if (!preg_match('/'.preg_replace('/[^0-9-:]/', '', $request->search).'/', $file)) {
                    unset($backups[$key]);
                }
            }
        }

        return view('admin.settings.backups.index', [
            'backups' => $backups,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backupDB()
    {
        \Artisan::call('backup:run', ['--only-db' => true]);
        return back()->with('success', __('database_backup_created'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backupFiles()
    {
        \Artisan::call('backup:run', ['--only-files' => true]);
        return back()->with('success', __('files_backed_up'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backupAll()
    {
        \Artisan::call('backup:run');
        return back()->with('success', __('files_and_database_backed_up'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if (!$request->has('file')) {
            return back()->with('error', __('no_backup_found'));
        }

        \Storage::disk('dropbox')->delete($request->file);
        return back()->with('success', __('backup_deleted'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function download(Request $request)
    {
        if (!$request->has('file')) {
            return back()->with('error', __('no_backup_found'));
        }
        return \Storage::disk('dropbox')->download($request->file);
    }
}
