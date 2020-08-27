<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Account
 */
class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.profile');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        if ($request->has('user')) {
            $user = [];
            $user['name'] = $request->user['name'];
            $user['login'] = $request->user['login'];
            $user['email'] = $request->user['email'];
            $user['phone'] = $request->user['phone'];
            $user['skype'] = $request->user['skype'];
            $user['sex'] = $request->user['sex'];
            $user['country'] = $request->user['country'];
            $user['city'] = $request->user['city'];

            foreach ($user as $key => $val) {
                $user[$key] = trim(strip_tags($val));
            }

            auth()->user()->update($user);
            auth()->user()->sendEmailNotification('change_settings', [], true);
        }

        if ($request->has('wallets')) {
            foreach ($request->wallets as $id => $external) {
                /** @var Wallet $findWallet */
                $findWallet = auth()->user()->wallets()->where('id', $id)->first();

                if (null == $findWallet) {
                    continue;
                }

                $findWallet->external = trim(strip_tags($external));
                $findWallet->save();
            }
            auth()->user()->sendEmailNotification('change_wallets', [], true);
        }

        session()->flash('success', __('settings_saved_successfully'));
        return back();
    }
}
