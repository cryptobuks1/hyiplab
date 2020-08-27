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
 * Class ChangePinController
 * @package App\Http\Controllers\Account
 */
class ChangePinController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.change_pin');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $pin           = $request->pin;
        $new_pin       = $request->new_pin;
        $repeat_pin    = $request->repeat_pin;

        if (!empty($user->pin)) {
            if (false === \Hash::check($pin, $user->pin)) {
                return redirect()->back()->with('error', __('current_pin_incorrect'));
            }
        }

        if ($new_pin !== $repeat_pin) {
            return redirect()->back()->with('error', __('new_code_dont_match'));
        }

        if ($new_pin == $pin) {
            return redirect()->back()->with('error', __('new_pin_must_be_different'));
        }

        $user->setPin($new_pin);
        $user->sendEmailNotification('change_pin', [], true);

        session()->flash('success', __('pin_changed'));
        return back();
    }
}
