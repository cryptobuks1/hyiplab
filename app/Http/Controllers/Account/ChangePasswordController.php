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
 * Class ChangePasswordController
 * @package App\Http\Controllers\Account
 */
class ChangePasswordController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.change_password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $password           = $request->password;
        $new_password       = $request->new_password;
        $repeat_password    = $request->repeat_password;

        if (false === \Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', __('current_password_incorrect'));
        }

        if ($new_password !== $repeat_password) {
            return redirect()->back()->with('error', __('new_password_dont_match'));
        }

        if ($new_password == $password) {
            return redirect()->back()->with('error', __('new_password_should_be_different'));
        }

        $user->setPassword($new_password);
        $user->sendEmailNotification('change_password', [], true);

        session()->flash('success', __('password_changed'));
        return back();
    }
}
