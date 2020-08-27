<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers;

use App\Http\Requests\RequestSubscribe;
use App\Http\Requests\RequestSupport;
use App\Models\Subscriber;

/**
 * Class SubscribeController
 * @package App\Http\Controllers
 */
class SubscribeController extends Controller
{
    /**
     * @param RequestSubscribe $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(RequestSubscribe $request)
    {
        $email          = trim($request->email);
        $checkExists    = Subscriber::where('email', $email)->count();

        if ($checkExists > 0) {
            return redirect()->back()->with('error', __('this_email_already_registered'));
        }

        Subscriber::create([
            'email' => $email,
        ]);

        return back()->with('success', __('mailbox_added_to_our_database'));
    }
}