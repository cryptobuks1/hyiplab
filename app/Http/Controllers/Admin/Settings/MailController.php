<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class MailController
 * @package App\Http\Controllers\Admin\Settings
 */
class MailController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.settings.mail.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        $emails = [];

        switch ($request->recipients) {
            case "special_users":
                $emails = User::where('email_tester', 1)->pluck('email');
                break;

            case "users":
                $emails = User::pluck('email');
                break;

            default:
                back();
        }

        if (count($emails) == 0) {
            session()->flash('error', __('mailboxes_not_found'));
            return back();
        }

        $counter = 0;

        foreach ($emails as $email) {
            $notificationMail = (new NotificationMail($email, 'news', []))
                ->onQueue(getSupervisorName().'-emails')
                ->delay(now()->addSeconds(0));

            \Mail::to($email)->queue($notificationMail);
            $counter++;
        }

        session()->flash('success', __('mails_sent').': '.$counter);
        return back();
    }
}
