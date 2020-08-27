<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class ImpersonateController
 * @package App\Http\Controllers\Admin
 */
class ImpersonateController extends AdminController
{
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function impersonate($id)
    {
        $user = User::find($id);

        if (null == $user) {
            return back()->with('error', __('user_not_found'))->withInput();
        }

        Auth::guard('admin')->user()->impersonate($user, 'web');
        return redirect(route('account.my-account'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function leave()
    {
        Auth::guard('web')->user()->leaveImpersonation();
        return redirect(route('admin.dashboard'));
    }
}
