<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class EmailNotificationController
 * @package App\Http\Controllers\Account
 */
class EmailNotificationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.email_notification');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $notifications = $request->notification;

        /** @var User $user */
        $user = auth()->user();

        $user->notifications_settings = null;
        $user->save();

        foreach ($notifications as $key => $val) {
            $user->setNotificationSettings($key, $val);
        }

        session()->flash('success', __('notification_settings_saved'));
        return back();
    }
}
