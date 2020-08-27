<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers;

use App\Http\Requests\RequestSupport;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;

/**
 * Class SupportController
 * @package App\Http\Controllers
 */
class SupportController extends Controller
{
    /**
     * @param RequestSupport $request
     */
    public function handle(RequestSupport $request)
    {
        /** @var array $data */
        $data = [
            'name'      => $request->name,
            'subject'   => $request->subject,
            'email'     => $request->email,
            'body'      => $request->body,
        ];

        $notificationMail = (new NotificationMail($data['email'], 'support_form', $data))
            ->onQueue(getSupervisorName().'-emails')
            ->delay(now()->addSeconds(0));

        \Mail::to($data['email'])->queue($notificationMail);

        return back()->with('success', __('email_sent'));
    }
}